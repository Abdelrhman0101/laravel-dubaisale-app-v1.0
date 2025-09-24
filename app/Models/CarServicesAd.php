<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Storage;

class CarServicesAd extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'thumbnail_images' => 'array',
        'admin_approved' => 'boolean',
        'active_offers_box_status' => 'boolean',
        'price' => 'decimal:2',
        'views' => 'integer',
        'rank' => 'integer',
        'plan_days' => 'integer',
        'plan_expires_at' => 'datetime',
        'active_offers_box_expires_at' => 'datetime',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'updated_at',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */

    protected $appends = [
        'main_image_url',
        'thumbnail_images_urls',
        'status',
        'category',
    ];

    /**
     * Get the user that owns the car services ad.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the service type relationship.
     */
    public function serviceType()
    {
        return $this->belongsTo(CarServiceType::class, 'service_type', 'name');
    }

    /**
     * Get the main image URL.
     */
    public function getMainImageUrlAttribute()
    {
        if ($this->main_image) {
            return Storage::url($this->main_image);
        }
        return null;
    }

    /**
     * Get the thumbnail images URLs.
     */
    public function getThumbnailImagesUrlsAttribute()
    {
        if ($this->thumbnail_images && is_array($this->thumbnail_images)) {
            return array_map(function ($image) {
                return Storage::url($image);
            }, $this->thumbnail_images);
        }
        return [];
    }

    /**
     * Get the status attribute.
     */
    public function getStatusAttribute()
    {
        return $this->add_status;
    }

    /**
     * Get the category attribute.
     */
    public function getCategoryAttribute()
    {
        return $this->add_category;
    }

    /**
     * Scope a query to only include valid ads.
     */
    public function scopeValid(Builder $query): void
    {
        $query->where('add_status', 'Valid');
    }

    /**
     * Scope a query to only include admin approved ads.
     */
    public function scopeApproved(Builder $query): void
    {
        $query->where('admin_approved', true);
    }

    /**
     * Scope a query to only include active ads (valid and approved).
     */
    public function scopeActive(Builder $query): void
    {
        $query->valid()->approved();
    }

    // Smart Filtering Scopes - Support multiple values
    public function scopeFilterByServiceType(Builder $query, $serviceType): void
    {
        if (is_string($serviceType) && str_contains($serviceType, ',')) {
            $serviceTypes = array_map('trim', explode(',', $serviceType));
            $query->whereIn('service_type', $serviceTypes);
        } elseif (is_array($serviceType)) {
            $query->whereIn('service_type', $serviceType);
        } else {
            $query->where('service_type', $serviceType);
        }
    }

    public function scopeFilterByEmirate(Builder $query, $emirate): void
    {
        if (is_string($emirate) && str_contains($emirate, ',')) {
            $emirates = array_map('trim', explode(',', $emirate));
            $query->whereIn('emirate', $emirates);
        } elseif (is_array($emirate)) {
            $query->whereIn('emirate', $emirate);
        } else {
            $query->where('emirate', $emirate);
        }
    }

    public function scopeFilterByDistrict(Builder $query, $district): void
    {
        if (is_string($district) && str_contains($district, ',')) {
            $districts = array_map('trim', explode(',', $district));
            $query->whereIn('district', $districts);
        } elseif (is_array($district)) {
            $query->whereIn('district', $district);
        } else {
            $query->where('district', $district);
        }
    }

    public function scopeFilterByArea(Builder $query, $area): void
    {
        if (is_string($area) && str_contains($area, ',')) {
            $areas = array_map('trim', explode(',', $area));
            $query->whereIn('area', $areas);
        } elseif (is_array($area)) {
            $query->whereIn('area', $area);
        } else {
            $query->where('area', $area);
        }
    }

    public function scopeFilterByPriceRange(Builder $query, $minPrice = null, $maxPrice = null): void
    {
        if ($minPrice !== null) {
            $query->where('price', '>=', $minPrice);
        }
        if ($maxPrice !== null) {
            $query->where('price', '<=', $maxPrice);
        }
    }

    public function scopeOfferBoxOnly(Builder $query): void
    {
        $query->inOffersBox();
    }

    // Legacy Scopes (kept for backward compatibility)
    public function scopeByServiceType(Builder $query, string $serviceType): void
    {
        $query->where('service_type', $serviceType);
    }

    public function scopeByEmirate(Builder $query, string $emirate): void
    {
        $query->where('emirate', $emirate);
    }

    public function scopeByDistrict(Builder $query, string $district): void
    {
        $query->where('district', $district);
    }

    public function scopeByArea(Builder $query, string $area): void
    {
        $query->where('area', $area);
    }

    public function scopeByPriceRange(Builder $query, $minPrice = null, $maxPrice = null): void
    {
        if ($minPrice !== null) {
            $query->where('price', '>=', $minPrice);
        }
        if ($maxPrice !== null) {
            $query->where('price', '<=', $maxPrice);
        }
    }

    /**
     * Scope a query to only include ads in offers box.
     */
    public function scopeInOffersBox(Builder $query): void
    {
        $query->where('active_offers_box_status', true)
              ->where(function ($q) {
                  $q->whereNull('active_offers_box_expires_at')
                    ->orWhere('active_offers_box_expires_at', '>', now());
              });
    }

    /**
     * Scope a query to order by most recent.
     */
    public function scopeLatest(Builder $query): void
    {
        $query->orderBy('created_at', 'desc');
    }

    /**
     * Scope a query to order by most viewed.
     */
    public function scopeMostViewed(Builder $query): void
    {
        $query->orderBy('views', 'desc');
    }

    /**
     * Scope a query to order by rank.
     */
    public function scopeByRank(Builder $query): void
    {
        $query->orderBy('rank', 'desc');
    }

    /**
     * Increment the views count.
     */
    public function incrementViews()
    {
        $this->increment('views');
    }

    /**
     * Check if the ad is in offers box and not expired.
     */
    public function isInActiveOffersBox()
    {
        return $this->active_offers_box_status && 
               (is_null($this->active_offers_box_expires_at) || 
                $this->active_offers_box_expires_at->isFuture());
    }

    /**
     * Check if the ad plan is expired.
     */
    public function isPlanExpired()
    {
        return $this->plan_expires_at && $this->plan_expires_at->isPast();
    }

    /**
     * Get ads for offers box (active and randomly ordered).
     */
    public static function getOffersBoxAds($limit = 10)
    {
        return self::active()
                   ->inOffersBox()
                   ->inRandomOrder()
                   ->limit($limit)
                   ->get();
    }
}