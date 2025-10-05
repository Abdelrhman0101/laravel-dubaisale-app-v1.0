<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Services\WhatsAppService; // (إذا كنت تستخدمه)
use App\Mail\SendActivationCode;   // (إذا كنت تستخدمه)
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth; // مهم جدًا لوظيفة جلسة الويب
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Carbon\Carbon;

use Exception;

class AuthController extends Controller
{

    public function signup(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required|string|max:20',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Invalid phone number'], 422);
        }

        $phone = $request->get('phone');

        try {
            $user = User::where('phone', $phone)->first();

            if (!$user) {
                // أول مرة → guest
                $user = User::create([
                    'phone' => $phone,
                    'whatsapp' => $phone,
                    'password' => '0123456789',
                    'user_type' => 'guest',
                    'is_active' => true,
                    'otp_verified' => false,
                ]);

                // $token = $user->createToken('auth_token')->plainTextToken;

                $message = 'Your registration was completed successfully. Welcome as a guest.';
            } else if ($user->user_type === 'guest') {

                $message = 'Welcome back, guest.';
            } else if ($user->user_type === 'advertiser') {

                if (Cache::has("otp_limit:$phone")) {
                    return response()->json([
                        'message' => 'Please wait before requesting another code.'
                    ], 429);
                }

                // $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
                // $otpHash = Hash::make($otp);
                $otp = '3457';
                $otpHash = Hash::make($otp);
                $otpExpiresAt = Carbon::now()->addMinutes(10);

                $user->update([
                    'otp_phone' => $otpHash,
                    'otp_expires_at' => $otpExpiresAt,
                    'otp_verified' => false,
                ]);
                // $this->sendOtpToPhone($phone, $otp);

                $message = 'OTP has been sent to your phone. Please verify to continue.';
                Cache::put("otp_limit:$phone", true, 60);
            }
            $user->refresh();

            return response()->json([
                'message' => $message,
                'user' => $user
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Signup request failed, please try again later.',
                'error' => $e->getMessage()
            ], 500);
        }
    }




    public function verifyOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required|string|max:20',
            'otp' => 'required|string|size:4',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Invalid input'], 422);
        }

        $phone = $request->get('phone');
        $otp = $request->get('otp');

        try {
            $user = User::where('phone', $phone)->first();

            if (!$user) {
                return response()->json(['message' => 'Invalid phone or code'], 400);
            }

            if (!$user->otp_phone && $user->user_type === 'guest') {
                return response()->json(['message' => 'Guest users do not require OTP verification'], 200);
            }

            if (!$user->otp_phone || !$user->otp_expires_at || Carbon::now()->gt($user->otp_expires_at)) {
                return response()->json(['message' => 'OTP expired, please request a new one'], 400);
            }

            if (!Hash::check($otp, $user->otp_phone)) {
                return response()->json(['message' => 'Invalid OTP'], 400);
            }
            $user->otp_verified = true;
            $user->otp_phone = null;
            $user->otp_expires_at = null;
            $user->user_type = 'advertiser';
            $user->is_active = true;
            $user->save();

            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'message' => 'OTP verified successfully',
                'user' => $user,
                'access_token' => $token,
                'token_type' => 'Bearer',
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Verification failed, please try again later.',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    public function resendOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required|string|max:20',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Invalid phone number'], 422);
        }

        $phone = $request->get('phone');

        try {
            $user = User::where('phone', $phone)->first();

            if (!$user) {
                return response()->json(['message' => 'User not found'], 404);
            }
            if ($user->user_type === 'guest') {
                return response()->json([
                    'message' => 'Guest users do not require OTP verification.'
                ], 200);
            }

            if (Cache::has("otp_limit:$phone")) {
                return response()->json([
                    'message' => 'Please wait before requesting another OTP.'
                ], 429);
            }
            // $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
            $otp = '3457';
            $otpHash = Hash::make($otp);
            $otpExpiresAt = Carbon::now()->addMinutes(10);

            $user->update([
                'otp_phone' => $otpHash,
                'otp_expires_at' => $otpExpiresAt,
                'otp_verified' => false,
            ]);

            Cache::put("otp_limit:$phone", true, 60);

            // $this->sendOtpToPhone($phone, $otp);
            return response()->json([
                'message' => 'A new OTP has been sent to your phone.',
                'expires_in' => 600
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to resend OTP, please try again later.',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    // private function sendOtpToPhone($phone, $otp)
    // {
    //    
    //     \Log::info("OTP to $phone: $otp");
    //     return true;
    // }
    // public function signup(Request $request)
    // {
    //     // تم إزالة الثغرة الأمنية للسماح للمستخدم بتحديد دوره بنفسه
    //     $validator = Validator::make($request->all(), [
    //         // 'username' => 'required|string|max:255',
    //         'email' => 'nullable|email|max:255|unique:users,email',
    //         'phone' => 'required|string|max:20|unique:users,phone',
    //         'whatsapp' => 'nullable|string|max:20|unique:users,whatsapp',
    //         // 'referral_code' => 'nullable|string',
    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json($validator->errors(), 422);
    //     }
    //     try {

    //         $user = User::where('phone', $request->get('phone'))->first();
    //         if ($user) {
    //             if ($user->otp_verified) {
    //                 //
    //             }
    //         } else {
    //             $user = User::create([
    //                 // 'username' => $request->username,
    //                 // 'email' => $request->email,
    //                 'phone' => $request->phone,
    //                 'whatsapp' => $request->phone,
    //                 'password' => '0123456789',
    //                 // 'referral_code' => $request->referral_code,
    //                 'role' => 'user', // الدور الافتراضي دائماً 'user'
    //                 'is_active' => true,
    //                 // 'email_verified_at' => now(),
    //             ]);

    //             $token = $user->createToken('auth_token')->plainTextToken;

    //             return response()->json([
    //                 'message' => 'User registered and activated successfully.',
    //                 'user' => $user,
    //                 'access_token' => $token,
    //                 'token_type' => 'Bearer',
    //             ], 201);
    //         }
    //     } catch (Exception $e) {
    //         return response()->json(['message' => 'Registration failed, please try again later.', 'error' => $e->getMessage()], 500);
    //     }
    // }

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
     * النسخة المطورة التي تدعم إنشاء جلسة ويب للمشرفين (عند استدعائها من route الويب).
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

        // تقييد تسجيل الدخول عبر كلمة المرور للمشرفين فقط
        if ($user->role !== 'admin') {
            return response()->json([
                'message' => 'Access denied. Password login is restricted to admins only.'
            ], 403);
        }

        // --- لقد قمنا بحذف منطق إنشاء الجلسة من هنا بالكامل ---

        // إصدار توكن الـ API (المنطق الأصلي والمستقر)
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
     * POST /request-otp
     * إرسال OTP للمستخدمين الضيوف الراغبين في التحول إلى معلنين،
     * أو للمعلنين الحاليين الذين يريدون تسجيل الدخول عبر OTP.
     */
    public function requestOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required|string|max:20',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Invalid phone number'], 422);
        }

        $phone = $request->get('phone');

        try {
            $user = User::where('phone', $phone)->first();

            if (!$user) {
                return response()->json([
                    'message' => 'User not found. Please sign up first via /newSignin.'
                ], 404);
            }

            // منع الإرسال المتكرر خلال 60 ثانية
            if (Cache::has("otp_limit:$phone")) {
                return response()->json([
                    'message' => 'Please wait before requesting another OTP.'
                ], 429);
            }

            // توليد وتخزين OTP
            $otp = '3457';
            $otpHash = Hash::make($otp);
            $otpExpiresAt = Carbon::now()->addMinutes(10);

            $user->update([
                'otp_phone' => $otpHash,
                'otp_expires_at' => $otpExpiresAt,
                'otp_verified' => false,
            ]);

            Cache::put("otp_limit:$phone", true, 60);

            // رسالة حسب نوع المستخدم
            $message = $user->user_type === 'guest'
                ? 'OTP has been sent. Verify to convert your account to advertiser.'
                : 'OTP has been sent. Verify to login as advertiser.';

            return response()->json([
                'message' => $message,
                'expires_in' => 600,
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to request OTP, please try again later.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * تسجيل خروج المستخدم وإبطال التوكن الحالي (للـ API).
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Successfully logged out from API'
        ], 200);
    }


}
