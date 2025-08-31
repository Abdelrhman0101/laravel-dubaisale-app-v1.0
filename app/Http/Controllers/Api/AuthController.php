<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Services\WhatsAppService;
use App\Mail\SendActivationCode;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth; // مهم جدًا لوظيفة جلسة الويب
use Illuminate\Validation\Rule;
use Exception;

class AuthController extends Controller
{
    /**
     * تسجيل حساب جديد وتفعيله تلقائياً (مؤقتاً).
     */
    public function signup(Request $request)
    {
        // تم إزالة الثغرة الأمنية للسماح للمستخدم بتحديد دوره بنفسه
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'phone' => 'required|string|max:20|unique:users,phone',
            'whatsapp' => 'required|string|max:20|unique:users,whatsapp',
            'password' => 'required|string|min:8',
            'referral_code' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        try {
            $user = User::create([
                'username' => $request->username,
                'email' => $request->email,
                'phone' => $request->phone,
                'whatsapp' => $request->whatsapp,
                'password' => Hash::make($request->password),
                'referral_code' => $request->referral_code,
                'role' => 'user', // الدور الافتراضي دائماً 'user'
                'is_active' => true, 
                'email_verified_at' => now(),
            ]);
            
            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'message' => 'User registered and activated successfully.',
                'user' => $user,
                'access_token' => $token,
                'token_type' => 'Bearer',
            ], 201);

        } catch (Exception $e) {
            return response()->json(['message' => 'Registration failed, please try again later.', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * تفعيل حساب المستخدم باستخدام الكود (للاستخدام المستقبلي).
     */
    public function activate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'identifier' => 'required|string',
            'activation_code' => 'required|numeric|digits:6',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = User::where('email', $request->identifier)
                    ->orWhere('phone', $request->identifier)
                    ->orWhere('whatsapp', $request->identifier)
                    ->first();

        if (!$user) {
            return response()->json(['message' => 'User not found.'], 404);
        }

        if ($user->is_active) {
            return response()->json(['message' => 'Account is already activated.'], 400);
        }

        if ($user->activation_code !== $request->activation_code || now()->isAfter($user->activation_code_expires_at)) {
            return response()->json(['message' => 'Invalid or expired activation code.'], 422);
        }

        $user->is_active = true;
        $user->email_verified_at = now();
        $user->activation_code = null;
        $user->activation_code_expires_at = null;
        $user->save();
        
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Account activated successfully.',
            'user' => $user,
            'access_token' => $token,
            'token_type' => 'Bearer',
        ], 200);
    }

    /**
     * تسجيل دخول مستخدم موجود وإصدار token.
     * النسخة المطورة التي تدعم إنشاء جلسة ويب للمشرفين.
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'identifier' => 'required|string',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = User::where('email', $request->identifier)
                    ->orWhere('phone', $request->identifier)
                    ->orWhere('whatsapp', $request->identifier)
                    ->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        if (!$user->is_active) {
            return response()->json(['message' => 'Your account is not activated.'], 403);
        }
        
        // --- "الجسر" الذي يربط بين عالمي الـ API والـ Web ---
        // إذا كان المستخدم الذي نجح في تسجيل الدخول هو admin،
        // قم بإنشاء جلسة ويب (session) له بالإضافة إلى التوكن.
        if ($user->role === 'admin') {
            Auth::guard('web')->login($user);
            $request->session()->regenerate();
        }
        
        // إصدار توكن الـ API (هذه الخطوة تتم لكل المستخدمين)
        $user->tokens()->delete();
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Login successful.',
            'user' => $user,
            'access_token' => $token,
            'token_type' => 'Bearer',
        ], 200);
    }

    /**
     * تسجيل خروج المستخدم وإبطال التوكن الحالي.
     */
    public function logout(Request $request)
    {
        // هذا يسجل الخروج من الـ API فقط عن طريق حذف التوكن
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Successfully logged out from API'
        ], 200);
    }
}