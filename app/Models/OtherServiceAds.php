<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Storage;

class OtherServiceAds extends Model
{
    //
    protected $table = "other_service_ads";
    protected $guarded = [];

    protected $casts = [
        'admin_approved' => 'boolean',
        'active_offers_box_status' => 'boolean',
        'plan_expires_at' => 'datetime',
        'active_offers_box_expires_at' => 'datetime',
    ];

    protected $hidden = [
        'updated_at',
        'status',
        'category',
    ];

    protected $appends = ['main_image_url', 'status', 'category'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * === Accessors ===
     */
    public function getMainImageUrlAttribute()
    {
        return $this->main_image ? Storage::url($this->main_image) : null;
    }

    public function getStatusAttribute()
    {
        return $this->add_status;
    }

    public function getCategoryAttribute()
    {
        return $this->add_category;
    }

    /**
     * === Scopes ===
     */
    public function scopeActive(Builder $query)
    {
        return $query->where('add_status', 'Valid')->where('admin_approved', true);
    }

    public function scopeFilterByEmirate(Builder $query, $emirate)
    {
        if (is_string($emirate) && str_contains($emirate, ',')) {
            $emirates = array_map('trim', explode(',', $emirate));
            return $query->whereIn('emirate', $emirates);
        } elseif (is_array($emirate)) {
            return $query->whereIn('emirate', $emirate);
        } else {
            return $query->where('emirate', $emirate);
        }
    }

    public function scopeFilterByDistrict(Builder $query, $district)
    {
        if (is_string($district) && str_contains($district, ',')) {
            $districts = array_map('trim', explode(',', $district));
            return $query->whereIn('district', $districts);
        } elseif (is_array($district)) {
            return $query->whereIn('district', $district);
        } else {
            return $query->where('district', $district);
        }
    }

    public function scopeFilterByArea(Builder $query, $area)
    {
        if (is_string($area) && str_contains($area, ',')) {
            $areas = array_map('trim', explode(',', $area));
            return $query->whereIn('area', $areas);
        } elseif (is_array($area)) {
            return $query->whereIn('area', $area);
        } else {
            return $query->where('area', $area);
        }
    }

    public function scopeFilterBySectionType(Builder $query, $sectionType)
    {
        if (is_string($sectionType) && str_contains($sectionType, ',')) {
            $types = array_map('trim', explode(',', $sectionType));
            return $query->whereIn('section_type', $types);
        } elseif (is_array($sectionType)) {
            return $query->whereIn('section_type', $sectionType);
        } else {
            return $query->where('section_type', $sectionType);
        }
    }

    public function scopeFilterByServiceName(Builder $query, $serviceName)
    {
        if (is_string($serviceName) && str_contains($serviceName, ',')) {
            $names = array_map('trim', explode(',', $serviceName));
            return $query->whereIn('service_name', $names);
        } elseif (is_array($serviceName)) {
            return $query->whereIn('service_name', $serviceName);
        } else {
            return $query->where('service_name', $serviceName);
        }
    }
    public function scopeFilterByPriceRange(Builder $query, $min = null, $max = null)
    {
        if (!is_null($min))
            $query->where('price', '>=', $min);
        if (!is_null($max))
            $query->where('price', '<=', $max);
        return $query;
    }

    public function scopeOfferBoxOnly(Builder $query)
    {
        return $query->inOffersBox();
    }

    public function scopeLatest(Builder $query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    public function scopeMostViewed(Builder $query)
    {
        return $query->orderBy('views', 'desc');
    }

    public function incrementViews(): void
    {
        $this->increment('views');
    }

    public function scopeByRank(Builder $query)
    {
        return $query->orderBy('rank', 'desc');
    }

    public function scopeInOffersBox($query)
    {
        return $query->where('active_offers_box_status', true)
            ->where(function ($q) {
                $q->whereNull('active_offers_box_expires_at')
                    ->orWhere('active_offers_box_expires_at', '>', now());
            });
    }

    public function isInActiveOffersBox()
    {
        return $this->active_offers_box_status &&
            (is_null($this->active_offers_box_expires_at) || $this->active_offers_box_expires_at->isFuture());
    }

    public static function getOffersBoxAds($limit = 10)
    {
        return self::active()
            ->inOffersBox()
            ->inRandomOrder()
            ->limit($limit)
            ->get();
    }
}
