<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CarSalesAd;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Gate;

class CarSalesAdController extends Controller
{
    // عرض جميع الإعلانات
    public function index()
    {
        // We will only show 'Valid' and 'admin_approved' ads to the public
        $ads = CarSalesAd::where('add_status', 'Valid')
                       ->where('admin_approved', true)
                       ->latest()
                       ->paginate(15);
        return response()->json($ads);
    }

    // إنشاء إعلان جديد
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'make' => 'required|string',
            'model' => 'required|string',
            'year' => 'required|digits:4',
            'km' => 'required|integer',
            'price' => 'required|numeric',
            'trans_type' => 'required|string',
            'phone_number' => 'required|string',
            'emirate' => 'required|string',
            'main_image' => 'required|image|max:5120', // 5MB
            'thumbnail_images.*' => 'image|max:5120', // 5MB for each image
            // Add other validations as needed
        ]);

        $data = $request->all();

        // Handle Main Image Upload
        $mainImagePath = $request->file('main_image')->store('cars/main', 'public');
        $data['main_image'] = $mainImagePath;

        // Handle Thumbnail Images Upload
        if ($request->hasFile('thumbnail_images')) {
            $thumbnailPaths = [];
            foreach ($request->file('thumbnail_images') as $file) {
                $thumbnailPaths[] = $file->store('cars/thumbnails', 'public');
            }
            $data['thumbnail_images'] = $thumbnailPaths;
        }

        // Associate with logged-in user
        $data['user_id'] = $request->user()->id;
        
        $ad = CarSalesAd::create($data);

        return response()->json($ad, 201);
    }

    // عرض إعلان واحد محدد
    public function show(CarSalesAd $carSalesAd)
    {
        return response()->json($carSalesAd);
    }

    // تحديث إعلان
    public function update(Request $request, CarSalesAd $carSalesAd)
    {
        // Authorization Check: Only the owner can update
        if ($request->user()->id !== $carSalesAd->user_id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        
        // Validate incoming data
        $validatedData = $request->validate([ 'title' => 'sometimes|required|string|max:255', /*...*/]);

        // For this example, we'll just update simple fields
        $carSalesAd->update($request->except(['main_image', 'thumbnail_images']));

        // Logic to update images can be added here (delete old, upload new)

        return response()->json($carSalesAd);
    }

    // حذف إعلان
    public function destroy(Request $request, CarSalesAd $carSalesAd)
    {
        // Authorization Check: Only the owner can delete
        if ($request->user()->id !== $carSalesAd->user_id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Delete associated images from storage
        Storage::disk('public')->delete($carSalesAd->main_image);
        if (is_array($carSalesAd->thumbnail_images)) {
            Storage::disk('public')->delete($carSalesAd->thumbnail_images);
        }

        $carSalesAd->delete();

        return response()->json(null, 204); // 204 No Content
    }

        /**
     * [Admin] جلب كل الإعلانات المعلقة للمراجعة.
     */
    public function getPendingAds()
    {
        $pendingAds = CarSalesAd::where('add_status', 'Pending')
                               ->latest()
                               ->paginate(15);
        return response()->json($pendingAds);
    }

    /**
     * [Admin] الموافقة على إعلان.
     */
    public function approveAd(CarSalesAd $carSalesAd)
    {
        $carSalesAd->update([
            'add_status' => 'Valid',
            'admin_approved' => true,
            'plan_expires_at' => now()->addDays(30) // مثال: تفعيل خطة 30 يوم عند الموافقة
        ]);

        return response()->json([
            'message' => 'Ad approved successfully.',
            'ad' => $carSalesAd
        ]);
    }

    /**
     * [Admin] رفض إعلان.
     */
    public function rejectAd(CarSalesAd $carSalesAd)
    {
        $carSalesAd->update(['add_status' => 'Rejected']);
        
        // هنا يمكنك لاحقًا إرسال إشعار للمستخدم بسبب الرفض

        return response()->json([
            'message' => 'Ad rejected successfully.',
            'ad' => $carSalesAd
        ]);
    }

    /**
 * [Admin] جلب جميع الإعلانات بجميع حالاتها للمشرف.
 */
public function indexForAdmin()
{
    // ببساطة، نقوم بجلب كل الإعلانات بدون أي شروط (where)
    // with('user') يقوم بجلب بيانات صاحب الإعلان مع كل إعلان لتقليل استعلامات قاعدة البيانات (Eager Loading)
    // latest() لترتيبها من الأحدث للأقدم
    // paginate() لتقسيم النتائج على صفحات
    $allAds = CarSalesAd::with('user')->latest()->paginate(15);

    return response()->json($allAds);
}
}