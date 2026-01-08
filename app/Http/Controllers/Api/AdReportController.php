<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AdReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class AdReportController extends Controller
{
    /**
     * إنشاء بلاغ جديد عن إعلان
     * POST /api/reports
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ad_type' => ['required', 'string', Rule::in(AdReport::getAdTypes())],
            'ad_id' => 'required|integer|min:1',
            'reason' => ['required', 'string', Rule::in(array_keys(AdReport::getAvailableReasons()))],
            'description' => 'nullable|string|max:1000',
        ], [
            'ad_type.required' => 'نوع الإعلان مطلوب',
            'ad_type.in' => 'نوع الإعلان غير صحيح',
            'ad_id.required' => 'معرف الإعلان مطلوب',
            'ad_id.integer' => 'معرف الإعلان يجب أن يكون رقم',
            'reason.required' => 'سبب البلاغ مطلوب',
            'reason.in' => 'سبب البلاغ غير صحيح',
            'description.max' => 'الوصف يجب ألا يتجاوز 1000 حرف',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'خطأ في البيانات المدخلة',
                'errors' => $validator->errors(),
            ], 422);
        }

        // التحقق من وجود الإعلان
        $adExists = $this->checkAdExists($request->ad_type, $request->ad_id);
        
        if (!$adExists) {
            return response()->json([
                'success' => false,
                'message' => 'الإعلان المحدد غير موجود',
            ], 404);
        }

        // إنشاء البلاغ
        $report = AdReport::create([
            'user_id' => auth()->id(), // يمكن أن يكون null للمستخدمين الغير مسجلين
            'ad_type' => $request->ad_type,
            'ad_id' => $request->ad_id,
            'reason' => $request->reason,
            'description' => $request->description,
            'status' => 'pending',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'تم إرسال البلاغ بنجاح. سيتم مراجعته في أقرب وقت.',
            'data' => [
                'report_id' => $report->id,
                'status' => $report->status,
                'created_at' => $report->created_at->format('Y-m-d H:i:s'),
            ],
        ], 201);
    }

    /**
     * الحصول على بلاغات المستخدم الحالي
     * GET /api/reports/my-reports
     */
    public function myReports(Request $request)
    {
        $perPage = $request->get('per_page', 15);
        $status = $request->get('status'); // pending, reviewed, resolved, rejected

        $query = AdReport::where('user_id', auth()->id())
            ->with(['reviewer:id,first_name,last_name'])
            ->orderBy('created_at', 'desc');

        if ($status && in_array($status, ['pending', 'reviewed', 'resolved', 'rejected'])) {
            $query->where('status', $status);
        }

        $reports = $query->paginate($perPage);

        $reports->getCollection()->transform(function ($report) {
            return [
                'id' => $report->id,
                'ad_type' => $report->ad_type,
                'ad_id' => $report->ad_id,
                'reason' => $report->reason,
                'reason_text' => AdReport::getAvailableReasons()[$report->reason] ?? $report->reason,
                'description' => $report->description,
                'status' => $report->status,
                'admin_note' => $report->admin_note,
                'reviewed_by' => $report->reviewer ? [
                    'id' => $report->reviewer->id,
                    'name' => $report->reviewer->first_name . ' ' . $report->reviewer->last_name,
                ] : null,
                'reviewed_at' => $report->reviewed_at?->format('Y-m-d H:i:s'),
                'created_at' => $report->created_at->format('Y-m-d H:i:s'),
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $reports,
        ]);
    }

    /**
     * الحصول على جميع الأسباب المتاحة للإبلاغ
     * GET /api/reports/reasons
     */
    public function getReasons()
    {
        return response()->json([
            'success' => true,
            'data' => AdReport::getAvailableReasons(),
        ]);
    }

    /**
     * الحصول على أنواع الإعلانات المتاحة
     * GET /api/reports/ad-types
     */
    public function getAdTypes()
    {
        return response()->json([
            'success' => true,
            'data' => AdReport::getAdTypes(),
        ]);
    }

    /**
     * التحقق من وجود الإعلان
     */
    private function checkAdExists(string $adType, int $adId): bool
    {
        $modelClass = match($adType) {
            'car_sale' => \App\Models\CarSalesAd::class,
            'car_rent' => \App\Models\CarRentAd::class,
            'car_service' => \App\Models\CarServicesAd::class,
            'restaurant' => \App\Models\RestaurantAd::class,
            'job' => \App\Models\JobAd::class,
            'real_estate' => \App\Models\RealEstateAd::class,
            'electronic' => \App\Models\ElectronicAd::class,
            'other_service' => \App\Models\OtherServiceAds::class,
            default => null,
        };

        if (!$modelClass) {
            return false;
        }

        return $modelClass::where('id', $adId)->exists();
    }

    // ==================== Admin Functions ====================

    /**
     * الحصول على جميع البلاغات (للأدمن فقط)
     * GET /api/admin/reports
     */
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 15);
        $status = $request->get('status');
        $adType = $request->get('ad_type');
        $reason = $request->get('reason');

        $query = AdReport::with(['reporter:id,first_name,last_name,phone', 'reviewer:id,first_name,last_name'])
            ->orderBy('created_at', 'desc');

        // تصفية حسب الحالة
        if ($status && in_array($status, ['pending', 'reviewed', 'resolved', 'rejected'])) {
            $query->where('status', $status);
        }

        // تصفية حسب نوع الإعلان
        if ($adType && in_array($adType, AdReport::getAdTypes())) {
            $query->where('ad_type', $adType);
        }

        // تصفية حسب السبب
        if ($reason && array_key_exists($reason, AdReport::getAvailableReasons())) {
            $query->where('reason', $reason);
        }

        $reports = $query->paginate($perPage);

        $reports->getCollection()->transform(function ($report) {
            return [
                'id' => $report->id,
                'reporter' => $report->reporter ? [
                    'id' => $report->reporter->id,
                    'name' => $report->reporter->first_name . ' ' . $report->reporter->last_name,
                    'phone' => $report->reporter->phone,
                ] : null,
                'ad_type' => $report->ad_type,
                'ad_id' => $report->ad_id,
                'reason' => $report->reason,
                'reason_text' => AdReport::getAvailableReasons()[$report->reason] ?? $report->reason,
                'description' => $report->description,
                'status' => $report->status,
                'admin_note' => $report->admin_note,
                'reviewed_by' => $report->reviewer ? [
                    'id' => $report->reviewer->id,
                    'name' => $report->reviewer->first_name . ' ' . $report->reviewer->last_name,
                ] : null,
                'reviewed_at' => $report->reviewed_at?->format('Y-m-d H:i:s'),
                'created_at' => $report->created_at->format('Y-m-d H:i:s'),
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $reports,
        ]);
    }

    /**
     * الحصول على تفاصيل بلاغ محدد (للأدمن فقط)
     * GET /api/admin/reports/{id}
     */
    public function show(AdReport $report)
    {
        $report->load(['reporter:id,first_name,last_name,phone,email', 'reviewer:id,first_name,last_name']);

        $adDetails = null;
        $ad = $report->ad;
        if ($ad) {
            $adDetails = [
                'id' => $ad->id,
                'title' => $ad->title ?? $ad->name ?? 'N/A',
                'description' => $ad->description ?? null,
                'status' => $ad->status ?? null,
                'created_at' => $ad->created_at?->format('Y-m-d H:i:s'),
            ];
        }

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $report->id,
                'reporter' => $report->reporter ? [
                    'id' => $report->reporter->id,
                    'name' => $report->reporter->first_name . ' ' . $report->reporter->last_name,
                    'phone' => $report->reporter->phone,
                    'email' => $report->reporter->email,
                ] : null,
                'ad_type' => $report->ad_type,
                'ad_id' => $report->ad_id,
                'ad_details' => $adDetails,
                'reason' => $report->reason,
                'reason_text' => AdReport::getAvailableReasons()[$report->reason] ?? $report->reason,
                'description' => $report->description,
                'status' => $report->status,
                'admin_note' => $report->admin_note,
                'reviewed_by' => $report->reviewer ? [
                    'id' => $report->reviewer->id,
                    'name' => $report->reviewer->first_name . ' ' . $report->reviewer->last_name,
                ] : null,
                'reviewed_at' => $report->reviewed_at?->format('Y-m-d H:i:s'),
                'created_at' => $report->created_at->format('Y-m-d H:i:s'),
                'updated_at' => $report->updated_at->format('Y-m-d H:i:s'),
            ],
        ]);
    }

    /**
     * تحديث حالة البلاغ (للأدمن فقط)
     * PUT /api/admin/reports/{id}
     */
    public function update(Request $request, AdReport $report)
    {
        $validator = Validator::make($request->all(), [
            'status' => ['required', 'string', Rule::in(['pending', 'reviewed', 'resolved', 'rejected'])],
            'admin_note' => 'nullable|string|max:1000',
        ], [
            'status.required' => 'الحالة مطلوبة',
            'status.in' => 'الحالة غير صحيحة',
            'admin_note.max' => 'ملاحظة الأدمن يجب ألا تتجاوز 1000 حرف',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'خطأ في البيانات المدخلة',
                'errors' => $validator->errors(),
            ], 422);
        }

        $report->update([
            'status' => $request->status,
            'admin_note' => $request->admin_note,
            'reviewed_by' => auth()->id(),
            'reviewed_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'تم تحديث البلاغ بنجاح',
            'data' => [
                'id' => $report->id,
                'status' => $report->status,
                'admin_note' => $report->admin_note,
                'reviewed_at' => $report->reviewed_at->format('Y-m-d H:i:s'),
            ],
        ]);
    }

    /**
     * حذف بلاغ (للأدمن فقط)
     * DELETE /api/admin/reports/{id}
     */
    public function destroy(AdReport $report)
    {
        $report->delete();

        return response()->json([
            'success' => true,
            'message' => 'تم حذف البلاغ بنجاح',
        ]);
    }

    /**
     * إحصائيات البلاغات (للأدمن فقط)
     * GET /api/admin/reports/stats
     */
    public function stats()
    {
        $stats = [
            'total' => AdReport::count(),
            'pending' => AdReport::where('status', 'pending')->count(),
            'reviewed' => AdReport::where('status', 'reviewed')->count(),
            'resolved' => AdReport::where('status', 'resolved')->count(),
            'rejected' => AdReport::where('status', 'rejected')->count(),
            'by_reason' => AdReport::select('reason', \DB::raw('count(*) as count'))
                ->groupBy('reason')
                ->pluck('count', 'reason')
                ->toArray(),
            'by_ad_type' => AdReport::select('ad_type', \DB::raw('count(*) as count'))
                ->groupBy('ad_type')
                ->pluck('count', 'ad_type')
                ->toArray(),
        ];

        return response()->json([
            'success' => true,
            'data' => $stats,
        ]);
    }
}
