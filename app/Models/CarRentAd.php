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
    public function scopeFilterByMake($query, $make)
    {
        if (is_string($make) && str_contains($make, ',')) {
            $makes = array_map('trim', explode(',', $make));
            return $query->whereIn('make', $makes);
        } elseif (is_array($make)) {
            return $query->whereIn('make', $make);
        } else {
            return $query->where('make', $make);
        }
    }

    public function scopeFilterByModel($query, $model)
    {
        if (is_string($model) && str_contains($model, ',')) {
            $models = array_map('trim', explode(',', $model));
            return $query->whereIn('model', $models);
        } elseif (is_array($model)) {
            return $query->whereIn('model', $model);
        } else {
            return $query->where('model', $model);
        }
    }

    public function scopeFilterByTrim($query, $trim)
    {
        if (is_string($trim) && str_contains($trim, ',')) {
            $trims = array_map('trim', explode(',', $trim));
            return $query->whereIn('trim', $trims);
        } elseif (is_array($trim)) {
            return $query->whereIn('trim', $trim);
        } else {
            return $query->where('trim', $trim);
        }
    }

    public function scopeFilterByYear($query, $year)
    {
        if (is_string($year) && str_contains($year, ',')) {
            $years = array_map('trim', explode(',', $year));
            return $query->whereIn('year', $years);
        } elseif (is_array($year)) {
            return $query->whereIn('year', $year);
        } else {
            return $query->where('year', $year);
        }
    }

    public function scopeFilterByEmirate($query, $emirate)
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

    public function scopeFilterByDistrict($query, $district)
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

    public function scopeFilterByArea($query, $area)
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

    public function scopeFilterByPriceRange($query, $min = null, $max = null)
    {
        if (!is_null($min))
            $query->where('price', '>=', $min);
        if (!is_null($max))
            $query->where('price', '<=', $max);
        return $query;
    }

    public function scopeFilterByDayRentRange($query, $min = null, $max = null)
    {
        if (!is_null($min))
            $query->where('day_rent', '>=', $min);
        if (!is_null($max))
            $query->where('day_rent', '<=', $max);
        return $query;
    }

    public function scopeFilterByMonthRentRange($query, $min = null, $max = null)
    {
        if (!is_null($min))
            $query->where('month_rent', '>=', $min);
        if (!is_null($max))
            $query->where('month_rent', '<=', $max);
        return $query;
    }

    public function scopeOfferBoxOnly($query)
    {
        return $query->inOffersBox();
    }

    // Legacy Scopes (kept for backward compatibility)
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
        if (!is_null($min))
            $query->where('price', '>=', $min);
        if (!is_null($max))
            $query->where('price', '<=', $max);
        return $query;
    }

    public function scopeByDayRentRange($query, $min = null, $max = null)
    {
        if (!is_null($min))
            $query->where('day_rent', '>=', $min);
        if (!is_null($max))
            $query->where('day_rent', '<=', $max);
        return $query;
    }

    public function scopeByMonthRentRange($query, $min = null, $max = null)
    {
        if (!is_null($min))
            $query->where('month_rent', '>=', $min);
        if (!is_null($max))
            $query->where('month_rent', '<=', $max);
        return $query;
    }

    public function scopeInOffersBox($query)
    {
        return $query->where('active_offers_box_status', true)
            ->where(function ($q) {
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