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
        'add_category',
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
