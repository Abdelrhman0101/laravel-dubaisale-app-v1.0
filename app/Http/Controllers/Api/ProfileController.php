<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Storage;
use App\Models\User; // <<< من الأفضل دائمًا استدعاء الـ Models التي تستخدمها

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
            'phone' => 'sometimes|nullable|string|max:20|unique:users,phone,' . $user->id,
            'whatsapp' => 'sometimes|nullable|string|max:20|unique:users,whatsapp,' . $user->id,
            'advertiser_name' => 'nullable|string|max:255',
            'advertiser_type' => 'nullable|string|max:255',
            'advertiser_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'advertiser_location' => 'nullable|string',
        ]);

        // 2. تعامل مع رفع صورة الشعار (إذا تم إرسالها)
        if ($request->hasFile('advertiser_logo')) {
            // أ. احذف الشعار القديم إذا كان موجودًا
            if ($user->advertiser_logo) {
                Storage::disk('public')->delete($user->advertiser_logo);
            }
            
            // ب. ارفع الشعار الجديد واحصل على مساره
            $path = $request->file('advertiser_logo')->store('logos', 'public');
            
            // ج. أضف المسار الجديد إلى البيانات التي سيتم حفظها
            $validatedData['advertiser_logo'] = $path;
        }

        // 3. قم بتحديث بيانات المستخدم باستخدام البيانات التي تم التحقق منها فقط
        $user->update($validatedData);
        
        // 4. أرجع بيانات المستخدم المحدثة بالكامل
        //    ->fresh() يضمن أننا نرسل أحدث نسخة من قاعدة البيانات
        return response()->json($user->fresh());
    }

    /**
     * تغيير كلمة المرور للمستخدم الحالي.
     */
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