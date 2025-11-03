<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SystemSetting;
use Illuminate\Http\JsonResponse;

class SupportController extends Controller
{
    /**
     * Get support phone number directly without authentication
     * 
     * @return JsonResponse
     */
    public function getSupportNumber(): JsonResponse
    {
        try {
            // الحصول على رقم الدعم الفني من إعدادات النظام
            $supportNumber = SystemSetting::getSetting('support_number', '+971508236561');
            
            return response()->json([
                'success' => true,
                'support_number' => $supportNumber,
                'message' => 'Support number retrieved successfully'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'support_number' => '+971508236561', // fallback number
                'message' => 'Error retrieving support number, using default',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Get support contact information (number + additional info)
     * 
     * @return JsonResponse
     */
    public function getSupportInfo(): JsonResponse
    {
        try {
            // الحصول على رقم الدعم الفني
            $supportNumber = SystemSetting::getSetting('support_number', '+971508236561');
            
            return response()->json([
                'success' => true,
                'data' => [
                    'support_number' => $supportNumber,
                    'whatsapp_number' => $supportNumber, // نفس الرقم للواتساب
                    'support_hours' => '24/7',
                    'support_languages' => ['Arabic', 'English'],
                    'contact_methods' => [
                        'phone' => $supportNumber,
                        'whatsapp' => $supportNumber,
                        'email' => 'support@dubaisale.com'
                    ]
                ],
                'message' => 'Support information retrieved successfully'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'data' => [
                    'support_number' => '+971508236561',
                    'whatsapp_number' => '+971508236561',
                    'support_hours' => '24/7',
                    'support_languages' => ['Arabic', 'English'],
                    'contact_methods' => [
                        'phone' => '+971508236561',
                        'whatsapp' => '+971508236561',
                        'email' => 'support@dubaisale.com'
                    ]
                ],
                'message' => 'Error retrieving support info, using defaults',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}