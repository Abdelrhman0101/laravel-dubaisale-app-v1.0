<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppService
{
    protected $endpoint;
    protected $token;

    public function __construct()
    {
        // جلب الإعدادات من ملف .env
        $this->endpoint = config('services.whatsapp.endpoint');
        $this->token = config('services.whatsapp.token');
    }

    /**
     * إرسال رسالة واتساب
     *
     * @param string $to  - رقم المستلم
     * @param string $message - نص الرسالة
     * @return bool - true عند النجاح, false عند الفشل
     */
    public function sendMessage(string $to, string $message): bool
    {
        if (!$this->endpoint || !$this->token) {
            Log::error('WhatsApp service is not configured.');
            return false;
        }

        try {
            $response = Http::withToken($this->token)->post($this->endpoint, [
                // بنية الطلب تختلف من مزود لآخر، هذا مجرد مثال شائع
                'messaging_product' => 'whatsapp',
                'to' => $to,
                'type' => 'text',
                'text' => [
                    'body' => $message
                ]
            ]);

            if ($response->successful()) {
                return true;
            }

            // تسجيل الخطأ لمراجعته لاحقاً
            Log::error('Failed to send WhatsApp message.', [
                'status' => $response->status(),
                'response' => $response->body()
            ]);
            return false;

        } catch (\Exception $e) {
            Log::error('Exception in WhatsAppService: ' . $e->getMessage());
            return false;
        }
    }
}