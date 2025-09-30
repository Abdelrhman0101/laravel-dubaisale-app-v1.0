<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Storage;


class electronicAd extends Model
{
    //
    protected $table = "electronic_ads";
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
        'thumbnail_images_urls',
        'add_status',
        'add_category',
    ];

    protected $appends = ['main_image_url', 'thumbnail_images_urls', 'status', 'category'];

    // == Relations ==
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // == Accessors ==
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

    // == Base Scopes ==
    public function scopeActive(Builder $query)
    {
        return $query->where('add_status', 'Valid')->where('admin_approved', true);
    }

    // == Smart Filtering (multi-values) ==
    public function scopeFilterBySectionType(Builder $query, $section)
    {
        if (is_string($section) && str_contains($section, ',')) {
            $sections = array_map('trim', explode(',', $section));
            return $query->whereIn('section_type', $sections);
        } elseif (is_array($section)) {
            return $query->whereIn('section_type', $section);
        } else {
            return $query->where('section_type', $section);
        }
    }

    public function scopeFilterByProductName(Builder $query, $name)
    {
        return $query->where('product_name', 'like', "%{$name}%");
    }

    public function scopeFilterByBrand(Builder $query, $brand)
    {
        if (is_string($brand) && str_contains($brand, ',')) {
            $brands = array_map('trim', explode(',', $brand));
            return $query->whereIn('brand', $brands);
        } elseif (is_array($brand)) {
            return $query->whereIn('brand', $brand);
        } else {
            return $query->where('brand', $brand);
        }
    }

    // public function scopeFilterByWarranty(Builder $query, $warranty)
    // {
    //     return $query->where('warranty', (bool) $warranty);
    // 

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

    public function scopeFilterByPriceRange(Builder $query, $min = null, $max = null)
    {
        if (!is_null($min))
            $query->where('price', '>=', $min);
        if (!is_null($max))
            $query->where('price', '<=', $max);
        return $query;
    }

    // == Offers Box ==
    public function scopeOfferBoxOnly(Builder $query)
    {
        return $query->inOffersBox();
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

    // == Ordering ==
    public function scopeLatest(Builder $query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    public function scopeMostViewed(Builder $query)
    {
        return $query->orderBy('views', 'desc');
    }

    public function scopeByRank(Builder $query)
    {
        return $query->orderBy('rank', 'desc');
    }

    // == Utils ==
    public function incrementViews(): void
    {
        $this->increment('views');
    }
}
