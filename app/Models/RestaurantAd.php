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
        'views' => 'integer',
        'rank' => 'integer',
        'plan_days' => 'integer',
        'plan_expires_at' => 'datetime',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
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

    // Previously, getCategoryAttribute() returned add_category. We now expose this as 'section'
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
}