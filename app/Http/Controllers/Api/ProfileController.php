<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    /**
     * تحديث بيانات الملف الشخصي للمستخدم الحالي.
     */
    public function update(Request $request)
    {
        $user = $request->user();

        $validatedData = $request->validate([
            'username' => 'sometimes|required|string|max:255|unique:users,username,' . $user->id,
            'advertiser_name' => 'nullable|string|max:255',
            'advertiser_type' => 'nullable|string|max:255',
            'advertiser_logo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // صورة بحجم أقصى 2MB
            'advertiser_location' => 'nullable|string',
        ]);

        $updateData = $request->except('advertiser_logo');

        // التعامل مع رفع صورة الشعار
        if ($request->hasFile('advertiser_logo')) {
            // يمكنك هنا حذف الشعار القديم إذا كان موجوداً
            // if ($user->advertiser_logo) { Storage::disk('public')->delete($user->advertiser_logo); }

            $path = $request->file('advertiser_logo')->store('logos', 'public');
            $updateData['advertiser_logo'] = $path;
        }

        $user->update($updateData);

        // نرجع بيانات المستخدم المحدثة بالكامل
        return response()->json($user->fresh());
    }

    public function changePassword(Request $request)
{
    $validatedData = $request->validate([
        'current_password' => 'required|string',
        'new_password' => ['required', 'string', Password::min(8), 'confirmed'],
    ]);
    
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