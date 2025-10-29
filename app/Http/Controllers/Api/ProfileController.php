<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Storage;
use App\Models\User; // <<< من الأفضل دائمًا استدعاء الـ Models التي تستخدمها
use Faker\Core\Number;

class ProfileController extends Controller
{
    /**
     * تحديث بيانات الملف الشخصي للمستخدم الحالي، مع دعم رفع الشعار.
     */
    public function update(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = $request->user();

        // 1. التحقق من صحة البيانات المدخلة
        $validatedData = $request->validate([
            'username' => 'sometimes|required|string|max:255|unique:users,username,' . $user->id,
            'email' => 'sometimes|nullable|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'sometimes|nullable|string|max:30|unique:users,phone,' . $user->id,
            'whatsapp' => 'sometimes|nullable|string|max:20|unique:users,whatsapp,' . $user->id,
            'advertiser_name' => 'nullable|string|max:255',
            'advertiser_type' => 'nullable|string|max:255',
            'advertiser_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:20480',
            'advertiser_location' => 'nullable|string',
            'referral_code' => 'sometimes|string|max:255',
        ]);



        // 2. تعامل مع رفع صورة الشعار (إذا تم إرسالها)
        if ($request->hasFile('advertiser_logo')) {
            // أ. احذف الشعار القديم إذا كان موجودًا
            if ($user->advertiser_logo) {
                Storage::disk('public')->delete($user->advertiser_logo);
            }

            // ب. ارفع الشعار الجديد واحصل على مساره
            $path = $request->file('advertiser_logo')->store('logos', 'public');


            $validatedData['advertiser_logo'] = $path;
        }

        if (!empty($validatedData['referral_code'])) {
            $referralId = (int) $validatedData['referral_code'];
            if ($referralId == $request->user()->id) {
                return response()->json([
                    'error' => "You can't add yourself as a referral",
                ], 400);
            }
            $userReferral = User::where('id', $referralId)->first();
            if ($userReferral) {
                $referrals = $userReferral->referral_code_list ?? [];
                $referrals[] = $request->user()->id;
                $userReferral->referral_code_list = $referrals;
                $userReferral->save();
            } else {
                return response()->json([
                    'error' => "Referral ID {$referralId} Not found",
                ], 400);
            }
        }


        $user->update($validatedData);

        return response()->json($user->fresh());
    }


    public function changePassword(Request $request)
    {
        $validatedData = $request->validate([
            'current_password' => 'required|string',
            'new_password' => ['required', 'string', Password::min(8)->letters()->symbols(), 'confirmed'],
        ]);

        /** @var \App\Models\User $user */
        $user = $request->user();

        // التحقق من أن كلمة المرور الحالية صحيحة
        if (!Hash::check($validatedData['current_password'], $user->password)) {
            return response()->json(['error' => 'The provided current password does not match your password.'], 422);
        }

        // تحديث كلمة المرور
        $user->password = Hash::make($validatedData['new_password']);
        $user->save();

        return response()->json(['message' => 'Password updated successfully.']);
    }
}
