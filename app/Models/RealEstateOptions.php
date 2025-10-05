<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RealEstateOptions extends Model
{
    //
    protected $table = 'real_estate_ads_options';
    use HasFactory;
    protected $fillable = [
        'field_name',
        'display_name',
        'options',
        'is_active',
        'sort_order'
    ];

    protected $casts = [
        'options' => 'array',
        'is_active' => 'boolean'
    ];


    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope to order by sort_order
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order', 'asc');
    }

    /**
     * Add 'other' option to the end of options array if not exists
     */
    public function ensureOtherOption()
    {
        $options = $this->options ?? [];

        // Check if 'other' already exists (case insensitive)
        $hasOther = collect($options)->contains(function ($option) {
            return strtolower($option) === 'other';
        });

        if (!$hasOther) {
            $options[] = 'other';
            $this->options = $options;
        }

        return $this;
    }

    /**
     * Get all specifications formatted for client use
     */
    public static function getClientSpecs()
    {
        return self::active()
            ->ordered()
            ->get()
            ->map(function ($spec) {
                $spec->ensureOtherOption();
                return [
                    'field_name' => $spec->field_name,
                    'display_name' => $spec->display_name,
                    'options' => $spec->options
                ];
            });
    }
}

