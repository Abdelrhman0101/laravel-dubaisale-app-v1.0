<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\CarSalesAd;

class DeactivateExpiredOffers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:deactivate-expired-offers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
{
    $this->info('Starting daily offers box maintenance...');
    
    // --- المهمة 1: إلغاء تفعيل العروض المنتهية ---
    $this->info('Deactivating expired offers...');
    // جلب وتحديث إعلانات السيارات المنتهية
    $deactivatedCount = CarSalesAd::where('active_offers_box_status', true)
                            ->where('active_offers_box_expires_at', '<', now())
                            ->update(['active_offers_box_status' => false]);

    $this->info("Deactivated {$deactivatedCount} car sale offers.");
    
    // --- المهمة 2: إنقاص عدد الأيام المتبقية للعروض النشطة ---
    $this->info('Updating remaining days for active offers...');
    
    // في قاعدة بيانات MySQL، يمكنك استخدام decrement()
    $updatedCount = CarSalesAd::where('active_offers_box_status', true)
                           ->where('active_offers_box_days', '>', 0) // لضمان عدم نزول الرقم تحت الصفر
                           ->decrement('active_offers_box_days');

    // في المستقبل، أضف الأقسام الأخرى هنا بنفس الطريقة
    // ...

    $this->info("Updated remaining days for {$updatedCount} active car sale offers.");
    
    $this->info('Offers box maintenance finished successfully.');
    return 0;
}

}
