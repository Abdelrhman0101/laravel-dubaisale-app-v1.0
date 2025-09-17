<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class CarRentAd extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'thumbnail_images' => 'array',
        'active_offers_box_status' => 'boolean',
        'active_offers_box_expires_at' => 'datetime',
        'plan_expires_at' => 'datetime',
        'admin_approved' => 'boolean',
    ];

    protected $hidden = ['main_image', 'thumbnail_images'];

    protected $appends = ['main_image_url', 'thumbnail_images_urls', 'status', 'category'];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Accessors
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
        return 'Car Rent';
    }

    // Scopes
    public function scopeValid($query)
    {
        return $query->where('add_status', 'Valid');
    }

    public function scopeApproved($query)
    {
        return $query->where('admin_approved', true);
    }

    public function scopeActive($query)
    {
        return $query->valid()->approved();
    }

    public function scopeByMake($query, $make)
    {
        return $query->where('make', $make);
    }

    public function scopeByModel($query, $model)
    {
        return $query->where('model', $model);
    }

    public function scopeByTrim($query, $trim)
    {
        return $query->where('trim', $trim);
    }

    public function scopeByYear($query, $year)
    {
        return $query->where('year', $year);
    }

    public function scopeByEmirate($query, $emirate)
    {
        return $query->where('emirate', $emirate);
    }

    public function scopeByDistrict($query, $district)
    {
        return $query->where('district', $district);
    }

    public function scopeByArea($query, $area)
    {
        return $query->where('area', $area);
    }

    public function scopeByPriceRange($query, $min = null, $max = null)
    {
        if (!is_null($min)) $query->where('price', '>=', $min);
        if (!is_null($max)) $query->where('price', '<=', $max);
        return $query;
    }

    public function scopeByDayRentRange($query, $min = null, $max = null)
    {
        if (!is_null($min)) $query->where('day_rent', '>=', $min);
        if (!is_null($max)) $query->where('day_rent', '<=', $max);
        return $query;
    }

    public function scopeByMonthRentRange($query, $min = null, $max = null)
    {
        if (!is_null($min)) $query->where('month_rent', '>=', $min);
        if (!is_null($max)) $query->where('month_rent', '<=', $max);
        return $query;
    }

    public function scopeInOffersBox($query)
    {
        return $query->where('active_offers_box_status', true)
                     ->where(function($q){
                         $q->whereNull('active_offers_box_expires_at')
                           ->orWhere('active_offers_box_expires_at', '>', now());
                     });
    }

    public function scopeLatest($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    public function scopeMostViewed($query)
    {
        return $query->orderBy('views', 'desc');
    }

    public function scopeByRank($query)
    {
        return $query->orderBy('rank', 'desc');
    }

    public function incrementViews()
    {
        $this->increment('views');
    }

    public function isInActiveOffersBox()
    {
        return $this->active_offers_box_status && (is_null($this->active_offers_box_expires_at) || $this->active_offers_box_expires_at->isFuture());
    }

    public function isPlanExpired()
    {
        return $this->plan_expires_at && $this->plan_expires_at->isPast();
    }

    public static function getOffersBoxAds($limit = 10)
    {
        return self::active()->inOffersBox()->inRandomOrder()->limit($limit)->get();
    }
}