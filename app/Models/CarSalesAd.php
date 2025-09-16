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
     * Filter by Make.
     * @param Builder $query
     * @param string $make
     * @return Builder
     */
    public function scopeFilterByMake(Builder $query, string $make): Builder
    {
        // استخدام where للمطابقة التامة، أو like للمطابقة الجزئية
        return $query->where('make', $make);
    }

    /**
     * Filter by Model.
     * @param Builder $query
     * @param string $model
     * @return Builder
     */
    public function scopeFilterByModel(Builder $query, string $model): Builder
    {
        return $query->where('model', $model);
    }

    /**
     * Filter by Trim.
     * @param Builder $query
     * @param string $trim
     * @return Builder
     */
    public function scopeFilterByTrim(Builder $query, string $trim): Builder
    {
        return $query->where('trim', $trim);
    }
    
    /**
     * Filter by Year.
     * @param Builder $query
     * @param int $year
     * @return Builder
     */
    public function scopeFilterByYear(Builder $query, int $year): Builder
    {
        return $query->where('year', $year);
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