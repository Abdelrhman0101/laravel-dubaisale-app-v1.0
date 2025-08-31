<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class AdApprovalService
{
    protected $baseUrl;
    protected $adminToken; // سنحتاج لتمرير توكن الـ Admin

    public function __construct(string $adminToken)
    {
        $this->baseUrl = config('app.url'); // يأخذ الرابط من ملف .env
        $this->adminToken = $adminToken;
    }

    /**
     * جلب إعداد "وضع الموافقة اليدوية".
     */
    public function getManualApprovalStatus(): bool
    {
        // نستخدم الـ Cache لتسريع الأداء
        return Cache::remember('manual_approval_status', now()->addMinutes(5), function () {
            $response = Http::withToken($this->adminToken)
                ->get("{$this->baseUrl}/api/admin/system-settings");

            if ($response->successful()) {
                $settings = $response->json();
                $status = $settings['manual_approval_mode']['value'] ?? 'true';
                return filter_var($status, FILTER_VALIDATE_BOOLEAN);
            }
            return true; // القيمة الافتراضية الآمنة هي تفعيل الموافقة
        });
    }

    /**
     * جلب الإعلانات المعلقة لكل الأقسام (حالياً قسم السيارات فقط).
     */
    public function getPendingAds(): array
    {
        // مستقبلاً، سنقوم بتكرار هذه العملية لكل قسم
        $categories = [
            'cars_sales' => 'إعلانات بيع السيارات',
            // 'real_estate' => 'عقارات', ...
        ];

        $pendingAds = [];

        foreach (array_keys($categories) as $categorySlug) {
             // بما أن القسم الوحيد الجاهز هو Cars Sales، سنجلب بياناته فقط
            if ($categorySlug === 'car_sales') {
                 $response = Http::withToken($this->adminToken)
                               ->get("{$this->baseUrl}/api/admin/ads/pending");

                if ($response->successful()) {
                    $pendingAds[$categorySlug] = $response->json()['data'] ?? [];
                } else {
                    $pendingAds[$categorySlug] = [];
                }
            } else {
                // للأقسام الأخرى، سنرجع مصفوفة فارغة مؤقتًا
                $pendingAds[$categorySlug] = [];
            }
        }
        
        return $pendingAds;
    }
}