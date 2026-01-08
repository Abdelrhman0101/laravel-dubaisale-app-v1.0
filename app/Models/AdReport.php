<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AdReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'ad_type',
        'ad_id',
        'reason',
        'description',
        'status',
        'admin_note',
        'reviewed_by',
        'reviewed_at',
    ];

    protected $casts = [
        'reviewed_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * العلاقة مع المستخدم الذي قام بالإبلاغ
     */
    public function reporter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * العلاقة مع الأدمن الذي راجع البلاغ
     */
    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    /**
     * الحصول على الإعلان المُبلغ عنه (polymorphic)
     */
    public function getAdAttribute()
    {
        $modelClass = match($this->ad_type) {
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

        return $modelClass ? $modelClass::find($this->ad_id) : null;
    }

    /**
     * Scope للبلاغات المعلقة
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope للبلاغات التي تمت مراجعتها
     */
    public function scopeReviewed($query)
    {
        return $query->whereIn('status', ['reviewed', 'resolved', 'rejected']);
    }

    /**
     * الأسباب المتاحة للإبلاغ
     */
    public static function getAvailableReasons(): array
    {
        return [
            'inappropriate' => 'محتوى غير لائق',
            'spam' => 'إعلان مزعج أو تكراري',
            'misleading' => 'معلومات مضللة',
            'duplicate' => 'إعلان مكرر',
            'fraud' => 'احتيال أو نصب',
            'wrong_category' => 'قسم خاطئ',
            'other' => 'أخرى',
        ];
    }

    /**
     * أنواع الإعلانات المتاحة
     */
    public static function getAdTypes(): array
    {
        return [
            'car_sale',
            'car_rent',
            'car_service',
            'restaurant',
            'job',
            'real_estate',
            'electronic',
            'other_service',
        ];
    }
}
