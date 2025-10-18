<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Storage;

class RealEstateAd extends Model
{
    //
    protected $table = "real_estate_ads";
    protected $guarded = [];

    protected $casts = [
        'thumbnail_images' => 'array',
        'warranty' => 'boolean',
        'admin_approved' => 'boolean',
        'active_offers_box_status' => 'boolean',
        'plan_expires_at' => 'datetime',
        'active_offers_box_expires_at' => 'datetime',
    ];
    protected $hidden = [
        'updated_at',
        'main_image_url',
        'thumbnail_images_urls',
        'add_status',
        // 'add_category',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected $appends = ['main_image_url', 'thumbnail_images_urls', 'status', 'category'];

    public function getMainImageUrlAttribute()
    {
        return $this->main_image ? Storage::url($this->main_image) : null;
    }

    public function getThumbnailImagesUrlsAttribute()
    {
        $images = $this->thumbnail_images ?? [];
        return array_map(fn($path) => Storage::url($path), $images);
    }

    public function getStatusAttribute()
    {
        return $this->add_status;
    }

    public function getCategoryAttribute()
    {
        return $this->add_category;
    }


    public function scopeActive(Builder $query)
    {
        return $query->where('add_status', 'Valid')->where('admin_approved', true);
    }

    // Smart Filtering Scopes - Support multiple values
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

    public function scopeFilterByContractType(Builder $query, $contract)
    {
        if (is_string($contract) && str_contains($contract, ',')) {
            $contracts = array_map('trim', explode(',', $contract));
            return $query->whereIn('contract_type', $contracts);
        } elseif (is_array($contract)) {
            return $query->whereIn('contract_type', $contract);
        } else {
            return $query->where('contract_type', $contract);
        }
    }

    public function scopeFilterByPropertyType(Builder $query, $type)
    {
        if (is_string($type) && str_contains($type, ',')) {
            $types = array_map('trim', explode(',', $type));
            return $query->whereIn('property_type', $types);
        } elseif (is_array($type)) {
            return $query->whereIn('property_type', $type);
        } else {
            return $query->where('property_type', $type);
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

    // Legacy Scopes (kept for backward compatibility)
    public function scopeByEmirate(Builder $query, $emirate)
    {
        return $query->where('emirate', $emirate);
    }

    public function scopeByDistrict(Builder $query, $district)
    {
        return $query->where('district', $district);
    }

    public function scopeByArea(Builder $query, $area)
    {
        return $query->where('area', $area);
    }

    public function scopeByContractType(Builder $query, $contract)
    {
        return $query->where('contract_type', $contract);
    }

    public function scopeByPropertyType(Builder $query, $type)
    {
        return $query->where('property_type', $type);
    }

    public function scopeByPriceRange(Builder $query, $min = null, $max = null)
    {
        if (!is_null($min))
            $query->where('price', '>=', $min);
        if (!is_null($max))
            $query->where('price', '<=', $max);
        return $query;
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
