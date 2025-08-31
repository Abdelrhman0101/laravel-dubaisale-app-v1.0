<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * تحديث بيانات الملف الشخصي للمستخدم الحالي.
     */
   public function update(Request $request)
    {
        // 1. احصل على المستخدم الحالي
        $user = $request->user();

        // 2. التحقق من صحة البيانات المدخلة
        // 'sometimes' تعني أن الحقل ليس إجباريًا، ولكن إذا وُجد، يجب أن يتبع القواعد
        $validatedData = $request->validate([
            // unique يتأكد من أن اسم المستخدم فريد، ويتجاهل الـ id الخاص بالمستخدم الحالي
            'username' => 'sometimes|required|string|max:255|unique:users,username,' . $user->id,
            'advertiser_name' => 'nullable|string|max:255',
            'advertiser_type' => 'nullable|string|max:255',
            // صورة بحجم أقصى 2MB
            'advertiser_logo' => 'sometimes|image|mimes:jpg,jpeg,png|max:2048', 
            'advertiser_location' => 'nullable|string',
        ]);

        // 3. قم بتجهيز البيانات النصية للتحديث
        $updateData = $request->except('advertiser_logo');

        // ==============================================================
        // ====        المنطق الذكي لرفع وتحديث صورة الشعار        ====
        // ==============================================================
        
        // 4. تحقق مما إذا كان المستخدم قد أرسل ملف صورة جديد
        if ($request->hasFile('advertiser_logo')) {
            // أ. إذا كان لدى المستخدم شعار قديم، قم بحذفه من الـ storage
            if ($user->advertiser_logo) {
                Storage::disk('public')->delete($user->advertiser_logo);
            }
            
            // ب. قم برفع الشعار الجديد إلى مجلد 'logos' داخل 'storage/app/public'
            $path = $request->file('advertiser_logo')->store('logos', 'public');
            
            // ج. قم بإضافة مسار الشعار الجديد إلى البيانات التي سيتم تحديثها
            $updateData['advertiser_logo'] = $path;
        }

        // 5. قم بتحديث بيانات المستخدم في قاعدة البيانات
        $user->update($updateData);
        
        // 6. أرجع بيانات المستخدم المحدثة بالكامل
        // ->fresh() لجلب أحدث نسخة من البيانات من قاعدة البيانات
        // toArray() لتحويل مسار الصورة إلى رابط كامل إذا كان لديك accessor (خطوة متقدمة)
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