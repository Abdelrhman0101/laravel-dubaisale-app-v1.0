<?php

namespace App\Observers;

use App\Models\User;
use App\Models\UserContactInfo;

class UserObserver
{
    /**
     * Handle the User "created" event.
     * Automatically initialize contact info when a new user is created.
     */
    public function created(User $user): void
    {
        // Only initialize if user has contact data
        if ($user->advertiser_name || $user->phone || $user->whatsapp) {
            UserContactInfo::initializeFromUser($user);
        }
    }

    /**
     * Handle the User "updated" event.
     * Automatically sync contact info when user profile is updated.
     */
    public function updated(User $user): void
    {
        // Check if any contact-related fields were changed
        $contactFields = ['advertiser_name', 'phone', 'whatsapp'];
        $hasContactChanges = false;
        
        foreach ($contactFields as $field) {
            if ($user->isDirty($field)) {
                $hasContactChanges = true;
                break;
            }
        }
        
        if (!$hasContactChanges) {
            return;
        }
        
        // Get or create contact info
        $contactInfo = $user->contactInfo;
        
        if (!$contactInfo) {
            // If no contact info exists, create it
            UserContactInfo::initializeFromUser($user);
            return;
        }
        
        // Sync the changes
        $this->syncContactChanges($user, $contactInfo);
    }
    
    /**
     * Sync contact field changes from user to contact info.
     */
    private function syncContactChanges(User $user, UserContactInfo $contactInfo): void
    {
        $updated = false;
        
        // Sync advertiser name
        if ($user->isDirty('advertiser_name')) {
            $oldValue = $user->getOriginal('advertiser_name');
            $newValue = $user->advertiser_name;
            
            if ($contactInfo->syncFieldValue('advertiser_names', $oldValue, $newValue)) {
                $updated = true;
            }
        }
        
        // Sync phone number
        if ($user->isDirty('phone')) {
            $oldValue = $user->getOriginal('phone');
            $newValue = $user->phone;
            
            if ($contactInfo->syncFieldValue('phone_numbers', $oldValue, $newValue)) {
                $updated = true;
            }
        }
        
        // Sync WhatsApp number
        if ($user->isDirty('whatsapp')) {
            $oldValue = $user->getOriginal('whatsapp');
            $newValue = $user->whatsapp;
            
            if ($contactInfo->syncFieldValue('whatsapp_numbers', $oldValue, $newValue)) {
                $updated = true;
            }
        }
        
        // Save changes if any updates were made
        if ($updated) {
            $contactInfo->save();
        }
    }
}