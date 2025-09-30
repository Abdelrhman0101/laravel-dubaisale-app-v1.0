<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class SystemSetting extends Model
{
    use HasFactory;

    /**
     * The attributes that aren't mass assignable.
     */
    protected $guarded = [];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'value' => 'string',
    ];

    /**
     * Helper method للحصول على قيمة إعداد معين مع cache.
     */
    public static function getSetting(string $key, $default = null)
    {
        return Cache::rememberForever("setting_{$key}", function () use ($key, $default) {
            $setting = self::where('key', $key)->first();
            return $setting ? $setting->value : $default;
        });
    }

    /**
     * Helper method لتحديث إعداد معين مع مسح cache.
     */
    public static function setSetting(string $key, string $value): bool
    {
        $updated = self::where('key', $key)->update(['value' => $value]);
        
        if ($updated) {
            Cache::forget("setting_{$key}");
        }
        
        return $updated > 0;
    }

    /**
     * Helper method للحصول على جميع إعدادات الباقات.
     */
    public static function getPlansSettings(): array
    {
        return Cache::rememberForever('plans_settings', function () {
            return self::where('key', 'like', 'plan_%')
                ->orWhere('key', 'like', 'free_%')
                ->orWhere('key', 'like', 'max_price_%')
                ->orWhere('key', 'like', 'offer_box_%')
                ->get()
                ->keyBy('key')
                ->toArray();
        });
    }

    /**
     * Helper method للحصول على قيمة مع تحويل النوع المناسب.
     */
    public function getTypedValue()
    {
        switch ($this->type) {
            case 'integer':
                return (int) $this->value;
            
            case 'price':
                return (float) $this->value;
            
            case 'boolean':
                return in_array(strtolower($this->value), ['true', '1']);
            
            case 'json':
                return json_decode($this->value, true);
            
            case 'string':
            default:
                return $this->value;
        }
    }

    /**
     * Boot method لمسح cache عند تحديث أو حذف الإعداد.
     */
    protected static function boot()
    {
        parent::boot();

        static::updated(function ($setting) {
            Cache::forget("setting_{$setting->key}");
            Cache::forget('plans_settings');
            Cache::forget('system_settings_all');
        });

        static::deleted(function ($setting) {
            Cache::forget("setting_{$setting->key}");
            Cache::forget('plans_settings');
            Cache::forget('system_settings_all');
        });

        static::created(function ($setting) {
            Cache::forget('plans_settings');
            Cache::forget('system_settings_all');
        });
    }
}