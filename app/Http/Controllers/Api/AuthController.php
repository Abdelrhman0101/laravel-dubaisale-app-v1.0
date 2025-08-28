<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Services\WhatsAppService; // استدعاء الخدمة
use App\Mail\SendActivationCode;   // استدعاء كلاس البريد
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Exception;

class AuthController extends Controller
{
    /**
     * تسجيل حساب جديد وإنشاء كود تفعيل
     */
    /**
     * تسجيل حساب جديد وتفعيله تلقائياً (مؤقتاً).
     */
    public function signup(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:255',
            'email' => 'nullable|email|max:255|unique:users,email',
            'phone' => 'nullable|string|max:20|unique:users,phone',
            'whatsapp' => 'nullable|string|max:20|unique:users,whatsapp',
            'password' => 'required|string|min:8',
            'referral_code' => 'nullable|string',
            "role" => 'nullable|string|in:admin,user', // إضافة حقل الدور
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        if (!$request->filled('email') && !$request->filled('phone') && !$request->filled('whatsapp')) {
            return response()->json(['message' => 'Email, phone, or WhatsApp field is required.'], 422);
        }
        
        try {
            // =================================================================
            // ==== بداية الكود الذي سيتم إعادة تفعيله لاحقاً ====
            //
            // $activationCode = random_int(100000, 999999); 
            //
            // ==== نهاية الكود الذي سيتم إعادة تفعيله لاحقاً ====
            // =================================================================

            $user = User::create([
                'username' => $request->username,
                'email' => $request->email,
                'phone' => $request->phone,
                'whatsapp' => $request->whatsapp,
                'password' => Hash::make($request->password),
                'referral_code' => $request->referral_code,
                'role' => $request->role ?? 'user', // تعيين الدور الافتراضي للمستخدم

                // === التغيير الرئيسي: التفعيل التلقائي ===
                'is_active' => true, 
                'email_verified_at' => now(), // يمكن اعتبار الإيميل موثقاً طالما تم التفعيل

                // === حقول ستُستخدم لاحقاً ===
                // 'activation_code' => $activationCode,
                // 'activation_code_expires_at' => now()->addMinutes(15),
            ]);
            
            // =================================================================
            // ==== بداية الكود الذي سيتم إعادة تفعيله لاحقاً ====
            //
            // $activationMessage = "Your account activation code is: {$activationCode}";
            //
            // if ($user->whatsapp) {
            //     (new WhatsAppService())->sendMessage($user->whatsapp, $activationMessage);
            // } elseif ($user->email) {
            //     Mail::to($user->email)->send(new SendActivationCode((string)$activationCode));
            // } elseif ($user->phone) {
            //     (new WhatsAppService())->sendMessage($user->phone, $activationMessage);
            // }
            //
            // ==== نهاية الكود الذي سيتم إعادة تفعيله لاحقاً ====
            // =================================================================

            // إنشاء Token للمستخدم الجديد حتى يتمكن من تسجيل الدخول مباشرة
            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'message' => 'User registered and activated successfully.', // تم تغيير الرسالة
                'user' => $user,
                'access_token' => $token,
                'token_type' => 'Bearer',
            ], 201);

        } catch (Exception $e) {
            return response()->json(['message' => 'Registration failed, please try again later.', 'error' => $e->getMessage()], 500);
        }
    }

        /**
     * تفعيل حساب المستخدم باستخدام الكود.
     */
    public function activate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'identifier' => 'required|string', // سيكون هذا إما الإيميل أو رقم الهاتف
            'activation_code' => 'required|numeric|digits:6',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // البحث عن المستخدم عن طريق الإيميل أو الهاتف أو الواتساب
        $user = User::where('email', $request->identifier)
                    ->orWhere('phone', $request->identifier)
                    ->orWhere('whatsapp', $request->identifier)
                    ->first();

        // حالة 1: المستخدم غير موجود
        if (!$user) {
            return response()->json(['message' => 'User not found.'], 404);
        }

        // حالة 2: الحساب مفعل بالفعل
        if ($user->is_active) {
            return response()->json(['message' => 'Account is already activated.'], 400);
        }

        // حالة 3: الكود خاطئ أو منتهي الصلاحية
        if ($user->activation_code !== $request->activation_code || now()->isAfter($user->activation_code_expires_at)) {
            return response()->json(['message' => 'Invalid or expired activation code.'], 422);
        }

        // --- عملية التفعيل الناجحة ---
        $user->is_active = true;
        $user->email_verified_at = now();
        $user->activation_code = null; // خطوة أمان مهمة: مسح الكود بعد استخدامه
        $user->activation_code_expires_at = null; // مسح تاريخ انتهاء الصلاحية
        $user->save();
        
        // إنشاء Token بعد التفعيل للسماح له بتسجيل الدخول
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
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'identifier' => 'required|string', // يمكن أن يكون email أو phone أو whatsapp
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // 1. البحث عن المستخدم باستخدام المُعرّف (identifier)
        $user = User::where('email', $request->identifier)
                    ->orWhere('phone', $request->identifier)
                    ->orWhere('whatsapp', $request->identifier)
                    ->first();

        // 2. التحقق من وجود المستخدم وصحة كلمة المرور
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Invalid credentials' // رسالة عامة لأسباب أمنية
            ], 401); // 401 Unauthorized
        }

        // 3. التحقق مما إذا كان الحساب مفعّلاً
        if (!$user->is_active) {
            // (هذه الحالة ستعمل عندما تعيد تفعيل نظام الأكواد)
            return response()->json([
                'message' => 'Your account is not activated. Please check your email/WhatsApp for the activation code.'
            ], 403); // 403 Forbidden
        }

        // 4. حذف التوكنز القديمة وإصدار توكن جديد (أفضل ممارسة أمنية)
        $user->tokens()->delete();
        $token = $user->createToken('auth_token')->plainTextToken;

        // 5. إرجاع رد ناجح مع التوكن
        return response()->json([
            'message' => 'Login successful.',
            'user' => $user,
            'access_token' => $token,
            'token_type' => 'Bearer',
        ], 200);
    }

      public function logout(Request $request)
    {
        // لارافيل ستحصل تلقائياً على المستخدم المُرتبط بالتوكن
        // $request->user()  ->  يصل للمستخدم الحالي
        // ->currentAccessToken()  ->  يصل للتوكن المستخدم في هذا الطلب تحديداً
        // ->delete()  ->  يحذف هذا التوكن من قاعدة البيانات
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Successfully logged out'
        ], 200);
    }
}