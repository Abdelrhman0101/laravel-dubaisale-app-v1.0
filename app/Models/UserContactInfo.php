<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserContactInfo extends Model
{
    use HasFactory;

    protected $table = 'user_contact_info';

    protected $fillable = [
        'user_id',
        'advertiser_names',
        'phone_numbers',
        'whatsapp_numbers'
    ];

    protected $casts = [
        'advertiser_names' => 'array',
        'phone_numbers' => 'array',
        'whatsapp_numbers' => 'array'
    ];

    /**
     * Get the user that owns the contact info
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Initialize contact info from user data
     */
    public static function initializeFromUser(User $user): self
    {
        $contactInfo = self::firstOrNew(['user_id' => $user->id]);
        
        // Initialize with user data if fields are empty
        if (empty($contactInfo->advertiser_names)) {
            $contactInfo->advertiser_names = $user->advertiser_name ? [$user->advertiser_name] : [];
        }
        
        if (empty($contactInfo->phone_numbers)) {
            $contactInfo->phone_numbers = $user->phone ? [$user->phone] : [];
        }
        
        if (empty($contactInfo->whatsapp_numbers)) {
            $contactInfo->whatsapp_numbers = $user->whatsapp ? [$user->whatsapp] : [];
        }
        
        $contactInfo->save();
        
        return $contactInfo;
    }

    /**
     * Add item to a specific field
     */
    public function addToField(string $field, string $value): bool
    {
        if (!in_array($field, ['advertiser_names', 'phone_numbers', 'whatsapp_numbers'])) {
            return false;
        }
        
        $currentValues = $this->{$field} ?? [];
        
        // Check if value already exists
        if (!in_array($value, $currentValues)) {
            $currentValues[] = $value;
            $this->{$field} = $currentValues;
            return $this->save();
        }
        
        return false; // Value already exists
    }

    /**
     * Remove item from a specific field
     */
    public function removeFromField(string $field, string $value): bool
    {
        if (!in_array($field, ['advertiser_names', 'phone_numbers', 'whatsapp_numbers'])) {
            return false;
        }
        
        $currentValues = $this->{$field} ?? [];
        $key = array_search($value, $currentValues);
        
        if ($key !== false) {
            unset($currentValues[$key]);
            $this->{$field} = array_values($currentValues); // Re-index array
            return $this->save();
        }
        
        return false; // Value not found
    }

    /**
     * Get formatted contact info for API response
     */
    public function getFormattedData(): array
    {
        return [
            'advertiser_names' => $this->advertiser_names ?? [],
            'phone_numbers' => $this->phone_numbers ?? [],
            'whatsapp_numbers' => $this->whatsapp_numbers ?? []
        ];
    }
}