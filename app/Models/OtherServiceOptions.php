<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OtherServiceOptions extends Model
{
    //
    protected $table = 'other_service_options';

    protected $fillable = [
        'field_name',
        'display_name',
        'options',
        'is_active',
        'sort_order'
    ];

    protected $casts = [
        'options'   => 'array',
        'is_active' => 'boolean'
    ];

    /**
     * Scope to get only active records
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope to order records by sort_order
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
     * Get all options formatted for client use
     */
    public static function getClientOptions()
    {
        return self::active()
            ->ordered()
            ->get()
            ->map(function ($option) {
                $option->ensureOtherOption();
                return [
                    'field_name'   => $option->field_name,
                    'display_name' => $option->display_name,
                    'options'      => $option->options
                ];
            });
    }
}
