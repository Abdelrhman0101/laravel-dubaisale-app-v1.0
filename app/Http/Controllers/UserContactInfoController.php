<?php

namespace App\Http\Controllers;

use App\Models\UserContactInfo;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;

class UserContactInfoController extends Controller
{
    /**
     * Get user's contact information
     */
    public function getContactInfo(): JsonResponse
    {
        try {
            $user = Auth::user();
            
            // Get or initialize contact info
            $contactInfo = UserContactInfo::where('user_id', $user->id)->first();
            
            if (!$contactInfo) {
                $contactInfo = UserContactInfo::initializeFromUser($user);
            }
            
            return response()->json([
                'success' => true,
                'data' => $contactInfo->getFormattedData()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve contact information',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Add item to a specific contact field
     */
    public function addContactItem(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'field' => 'required|string|in:advertiser_names,phone_numbers,whatsapp_numbers',
                'value' => 'required|string|max:255'
            ]);

            $user = Auth::user();
            
            // Get or create contact info
            $contactInfo = UserContactInfo::firstOrCreate(
                ['user_id' => $user->id],
                [
                    'advertiser_names' => [],
                    'phone_numbers' => [],
                    'whatsapp_numbers' => []
                ]
            );

            // Validate phone numbers format if needed
            if (in_array($validated['field'], ['phone_numbers', 'whatsapp_numbers'])) {
                if (!$this->isValidPhoneNumber($validated['value'])) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Invalid phone number format'
                    ], 422);
                }
            }

            $added = $contactInfo->addToField($validated['field'], $validated['value']);
            
            if ($added) {
                return response()->json([
                    'success' => true,
                    'message' => 'Item added successfully',
                    'data' => $contactInfo->fresh()->getFormattedData()
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Item already exists or could not be added'
                ], 422);
            }
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to add contact item',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove item from a specific contact field
     */
    public function removeContactItem(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'field' => 'required|string|in:advertiser_names,phone_numbers,whatsapp_numbers',
                'value' => 'required|string'
            ]);

            $user = Auth::user();
            $contactInfo = UserContactInfo::where('user_id', $user->id)->first();
            
            if (!$contactInfo) {
                return response()->json([
                    'success' => false,
                    'message' => 'Contact information not found'
                ], 404);
            }

            $removed = $contactInfo->removeFromField($validated['field'], $validated['value']);
            
            if ($removed) {
                return response()->json([
                    'success' => true,
                    'message' => 'Item removed successfully',
                    'data' => $contactInfo->fresh()->getFormattedData()
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Item not found or could not be removed'
                ], 422);
            }
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to remove contact item',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Bulk update contact information
     */
    public function bulkUpdateContactInfo(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'advertiser_names' => 'array',
                'advertiser_names.*' => 'string|max:255',
                'phone_numbers' => 'array',
                'phone_numbers.*' => 'string|max:20',
                'whatsapp_numbers' => 'array',
                'whatsapp_numbers.*' => 'string|max:20'
            ]);

            $user = Auth::user();
            
            // Validate phone numbers if provided
            if (isset($validated['phone_numbers'])) {
                foreach ($validated['phone_numbers'] as $phone) {
                    if (!$this->isValidPhoneNumber($phone)) {
                        return response()->json([
                            'success' => false,
                            'message' => 'Invalid phone number format: ' . $phone
                        ], 422);
                    }
                }
            }

            if (isset($validated['whatsapp_numbers'])) {
                foreach ($validated['whatsapp_numbers'] as $whatsapp) {
                    if (!$this->isValidPhoneNumber($whatsapp)) {
                        return response()->json([
                            'success' => false,
                            'message' => 'Invalid WhatsApp number format: ' . $whatsapp
                        ], 422);
                    }
                }
            }
            
            // Get or create contact info
            $contactInfo = UserContactInfo::firstOrCreate(
                ['user_id' => $user->id],
                [
                    'advertiser_names' => [],
                    'phone_numbers' => [],
                    'whatsapp_numbers' => []
                ]
            );

            // Update only provided fields
            if (isset($validated['advertiser_names'])) {
                $contactInfo->advertiser_names = array_unique($validated['advertiser_names']);
            }
            
            if (isset($validated['phone_numbers'])) {
                $contactInfo->phone_numbers = array_unique($validated['phone_numbers']);
            }
            
            if (isset($validated['whatsapp_numbers'])) {
                $contactInfo->whatsapp_numbers = array_unique($validated['whatsapp_numbers']);
            }

            $contactInfo->save();

            return response()->json([
                'success' => true,
                'message' => 'Contact information updated successfully',
                'data' => $contactInfo->getFormattedData()
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update contact information',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Initialize contact info from user data
     */
    public function initializeFromUserData(): JsonResponse
    {
        try {
            $user = Auth::user();
            $contactInfo = UserContactInfo::initializeFromUser($user);
            
            return response()->json([
                'success' => true,
                'message' => 'Contact information initialized successfully',
                'data' => $contactInfo->getFormattedData()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to initialize contact information',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Validate phone number format (basic validation)
     */
    private function isValidPhoneNumber(string $phone): bool
    {
        // Remove spaces, dashes, and plus signs for validation
        $cleanPhone = preg_replace('/[\s\-\+]/', '', $phone);
        
        // Check if it contains only digits and is between 7-15 characters
        return preg_match('/^\d{7,15}$/', $cleanPhone);
    }
}