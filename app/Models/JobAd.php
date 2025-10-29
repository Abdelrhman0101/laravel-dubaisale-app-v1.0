<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Storage;
use App\Traits\HandlesSearchIndex;


class JobAd extends Model
{
    //
    use HasFactory,HandlesSearchIndex;
    protected $table = 'job_ads';
    protected $guarded = [];
    protected static $searchType = 'Job';
    protected $casts = [
        'warranty' => 'boolean',
        'admin_approved' => 'boolean',
        'active_offers_box_status' => 'boolean',
        'plan_expires_at' => 'datetime',
        'active_offers_box_expires_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getMainImageUrlAttribute()
    {
        return $this->main_image ? Storage::url($this->main_image) : null;
    }

    public function getStatusAttribute()
    {
        return $this->add_status;
    }

    public function getSectionAttribute()
    {
        return $this->add_category;
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */
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

    public function scopeByCategoryType(Builder $query, string $type): void
    {
        $query->where('category_type', $type);
    }

    public function scopeBySectionType(Builder $query, string $type): void
    {
        $query->where('section_type', $type);
    }

    public function scopeLatest(Builder $query): void
    {
        $query->orderBy('created_at', 'desc');
    }
    public function scopeOrderedByRank($query)
    {
        return $query->orderBy('rank', 'asc');
    }

    public function scopeMostViewed(Builder $query): void
    {
        $query->orderBy('views', 'desc');
    }

    public function scopeByRank(Builder $query): void
    {
        $query->orderBy('rank', 'desc');
    }

    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */
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

    /*
    |--------------------------------------------------------------------------
    | Smart Filtering Scopes (Support Multiple Values)
    |--------------------------------------------------------------------------
    */

    public function scopeFilterByEmirate(Builder $query, $emirates): void
    {
        if (empty($emirates))
            return;

        $emiratesArray = is_array($emirates) ? $emirates : explode(',', $emirates);
        $emiratesArray = array_filter(array_map('trim', $emiratesArray));

        if (!empty($emiratesArray)) {
            $query->whereIn('emirate', $emiratesArray);
        }
    }

    public function scopeFilterByDistrict(Builder $query, $districts): void
    {
        if (empty($districts))
            return;

        $districtsArray = is_array($districts) ? $districts : explode(',', $districts);
        $districtsArray = array_filter(array_map('trim', $districtsArray));

        if (!empty($districtsArray)) {
            $query->whereIn('district', $districtsArray);
        }
    }

    public function scopeFilterByCategoryType(Builder $query, $categoryTypes): void
    {
        if (empty($categoryTypes))
            return;

        $categoryTypesArray = is_array($categoryTypes) ? $categoryTypes : explode(',', $categoryTypes);
        $categoryTypesArray = array_filter(array_map('trim', $categoryTypesArray));

        if (!empty($categoryTypesArray)) {
            $query->whereIn('category_type', $categoryTypesArray);
        }
    }

    public function scopeFilterBySectionType(Builder $query, $sectionTypes): void
    {
        if (empty($sectionTypes))
            return;

        $sectionTypesArray = is_array($sectionTypes) ? $sectionTypes : explode(',', $sectionTypes);
        $sectionTypesArray = array_filter(array_map('trim', $sectionTypesArray));

        if (!empty($sectionTypesArray)) {
            $query->whereIn('section_type', $sectionTypesArray);
        }
    }

    public function scopeOfferBoxOnly(Builder $query): void
    {
        $query->where('active_offers_box_status', true)
            ->where(function ($q) {
                $q->whereNull('active_offers_box_expires_at')
                    ->orWhere('active_offers_box_expires_at', '>', now());
            });
    }

    public function scopeKeywordSearch(Builder $query, $keyword): void
    {
        if (empty($keyword))
            return;

        $keyword = trim($keyword);
        if (!empty($keyword)) {
            $query->where(function ($q) use ($keyword) {
                $q->where('title', 'LIKE', "%{$keyword}%")
                    ->orWhere('description', 'LIKE', "%{$keyword}%")
                    ->orWhere('company_name', 'LIKE', "%{$keyword}%")
                    ->orWhere('emirate', 'LIKE', "%{$keyword}%")
                    ->orWhere('district', 'LIKE', "%{$keyword}%");
            });
        }
    }
}
