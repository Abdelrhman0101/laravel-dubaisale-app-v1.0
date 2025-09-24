<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder; // استدعاء Builder

class CarSalesAd extends Model
{
    use HasFactory;

    /**
     * The attributes that aren't mass assignable.
     * Using guarded instead of fillable for simplicity.
     */
    protected $guarded = [];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'thumbnail_images' => 'array',
        'warranty' => 'boolean',
        'admin_approved' => 'boolean',
        'active_offers_box_status' => 'boolean',
        'plan_expires_at' => 'datetime',
        'active_offers_box_expires_at' => 'datetime',
    ];

    /**
     * Get the user that owns the ad.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // =========================================================
    // ====          Local Scopes for Filtering           ====
    // =========================================================

    /**
     * Smart Filter by Make - supports multiple values.
     * @param Builder $query
     * @param string|array $make
     * @return Builder
     */
    public function scopeFilterByMake(Builder $query, $make): Builder
    {
        if (is_string($make)) {
            $make = explode(',', $make);
        }
        return $query->whereIn('make', array_map('trim', $make));
    }

    /**
     * Smart Filter by Model - supports multiple values.
     * @param Builder $query
     * @param string|array $model
     * @return Builder
     */
    public function scopeFilterByModel(Builder $query, $model): Builder
    {
        if (is_string($model)) {
            $model = explode(',', $model);
        }
        return $query->whereIn('model', array_map('trim', $model));
    }

    /**
     * Smart Filter by Trim - supports multiple values.
     * @param Builder $query
     * @param string|array $trim
     * @return Builder
     */
    public function scopeFilterByTrim(Builder $query, $trim): Builder
    {
        if (is_string($trim)) {
            $trim = explode(',', $trim);
        }
        return $query->whereIn('trim', array_map('trim', $trim));
    }
    
    /**
     * Smart Filter by Year - supports multiple values.
     * @param Builder $query
     * @param string|array $year
     * @return Builder
     */
    public function scopeFilterByYear(Builder $query, $year): Builder
    {
        if (is_string($year)) {
            $year = explode(',', $year);
        }
        return $query->whereIn('year', array_map('trim', $year));
    }

    /**
     * Smart Filter by Emirate - supports multiple values.
     * @param Builder $query
     * @param string|array $emirate
     * @return Builder
     */
    public function scopeFilterByEmirate(Builder $query, $emirate): Builder
    {
        if (is_string($emirate)) {
            $emirate = explode(',', $emirate);
        }
        return $query->whereIn('emirate', array_map('trim', $emirate));
    }

    /**
     * Smart Filter by District - supports multiple values.
     * @param Builder $query
     * @param string|array $district
     * @return Builder
     */
    public function scopeFilterByDistrict(Builder $query, $district): Builder
    {
        if (is_string($district)) {
            $district = explode(',', $district);
        }
        return $query->whereIn('district', array_map('trim', $district));
    }

    /**
     * Smart Filter by Area - supports multiple values.
     * @param Builder $query
     * @param string|array $area
     * @return Builder
     */
    public function scopeFilterByArea(Builder $query, $area): Builder
    {
        if (is_string($area)) {
            $area = explode(',', $area);
        }
        return $query->whereIn('area', array_map('trim', $area));
    }

    /**
     * Filter by Price Range.
     * @param Builder $query
     * @param float|null $min
     * @param float|null $max
     * @return Builder
     */
    public function scopeFilterByPriceRange(Builder $query, $min = null, $max = null): Builder
    {
        if (!is_null($min)) {
            $query->where('price', '>=', $min);
        }
        if (!is_null($max)) {
            $query->where('price', '<=', $max);
        }
        return $query;
    }

    /**
     * Filter by Transmission Type - supports multiple values.
     * @param Builder $query
     * @param string|array $transType
     * @return Builder
     */
    public function scopeFilterByTransType(Builder $query, $transType): Builder
    {
        if (is_string($transType)) {
            $transType = explode(',', $transType);
        }
        return $query->whereIn('trans_type', array_map('trim', $transType));
    }

    /**
     * Filter by Offer Box Status.
     * @param Builder $query
     * @return Builder
     */
    public function scopeOfferBoxOnly(Builder $query): Builder
    {
        return $query->where('active_offers_box_status', true)
                    ->where('active_offers_box_expires_at', '>', now());
    }

    /**
     * Increment the views count for this ad.
     * @return bool
     */
    public function incrementViews(): bool
    {
        return $this->increment('views');
    }
}