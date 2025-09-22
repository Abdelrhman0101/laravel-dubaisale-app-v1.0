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
