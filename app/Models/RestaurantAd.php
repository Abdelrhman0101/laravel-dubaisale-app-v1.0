<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Storage;

class RestaurantAd extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'thumbnail_images' => 'array',
        'admin_approved' => 'boolean',
        'active_offers_box_status' => 'boolean',
        'active_offers_box_expires_at' => 'datetime',
        'views' => 'integer',
        'rank' => 'integer',
        'plan_days' => 'integer',
        'plan_expires_at' => 'datetime',
        'active_offers_box_days' => 'integer',
    ];

    protected $hidden = [
        'updated_at',
        // 'add_status',
        // 'add_category',
    ];

    protected $appends = [
        'main_image_url',
        'thumbnail_images_urls',
        'status',
        'section',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getMainImageUrlAttribute()
    {
        return $this->main_image ? Storage::url($this->main_image) : null;
    }

    public function getThumbnailImagesUrlsAttribute()
    {
        if ($this->thumbnail_images && is_array($this->thumbnail_images)) {
            return array_map(fn($img) => Storage::url($img), $this->thumbnail_images);
        }
        return [];
    }

    public function getStatusAttribute()
    {
        return $this->add_status;
    }

    public function getSectionAttribute()
    {
        return $this->add_category;
    }

    // Scopes
    public function scopeValid(Builder $query): void
    {
        $query->where('add_status', 'Valid');
    }

    public function scopeApproved(Builder $query): void
    {
        $query->where('admin_approved', true);
    }

    public function scopeActive(Builder $query): void
    {
        $query->valid()->approved();
    }

    public function scopeInOffersBox(Builder $query): void
    {
        $query->where('active_offers_box_status', true)
            ->where(function ($q) {
                $q->whereNull('active_offers_box_expires_at')
                    ->orWhere('active_offers_box_expires_at', '>', now());
            });
    }

    // Smart Filtering Scopes - Support multiple values
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

    public function scopeFilterByCategory(Builder $query, $category): void
    {
        if (is_string($category) && str_contains($category, ',')) {
            $categories = array_map('trim', explode(',', $category));
            $query->whereIn('category', $categories);
        } elseif (is_array($category)) {
            $query->whereIn('category', $category);
        } else {
            $query->where('category', $category);
        }
    }

    public function scopeFilterByPriceRange(Builder $query, $priceRange): void
    {
        if (is_string($priceRange) && str_contains($priceRange, ',')) {
            $priceRanges = array_map('trim', explode(',', $priceRange));
            $query->whereIn('price_range', $priceRanges);
        } elseif (is_array($priceRange)) {
            $query->whereIn('price_range', $priceRange);
        } else {
            $query->where('price_range', $priceRange);
        }
    }

    public function scopeOfferBoxOnly(Builder $query): void
    {
        $query->inOffersBox();
    }

    // Legacy Scopes (kept for backward compatibility)
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

    public function scopeByPriceRange(Builder $query, string $priceRange): void
    {
        $query->where('price_range', $priceRange);
    }

    public function scopeByCategory(Builder $query, string $category): void
    {
        $query->where('category', $category);
    }

    public function scopeLatest(Builder $query): void
    {
        $query->orderBy('created_at', 'desc');
    }

    public function scopeMostViewed(Builder $query): void
    {
        $query->orderBy('views', 'desc');
    }

    public function scopeByRank(Builder $query): void
    {
        $query->orderBy('rank', 'desc');
    }

    public function incrementViews(): void
    {
        $this->increment('views');
    }
    public function scopeOrderedByRank($query)
    {
        return $query->orderBy('rank', 'asc');
    }

    public function isInActiveOffersBox(): bool
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
