<?php

namespace Kavenegar\KavenegarSms;

use GuzzleHttp\Client;

class KavenegarSms
{
    protected $apiKey;
    protected $client;

    public function __construct($apiKey)
    {
        $this->apiKey = $apiKey;
        // ایجاد یک کلاینت جدید Guzzle برای ارسال درخواست به API کاوه نگار
        $this->client = new Client([
            'base_uri' => 'https://api.kavenegar.com/v1/',
        ]);
    }

    /**
     * ارسال پیامک به یک گیرنده
     *
     * @param string $to شماره گیرنده
     * @param string $message متن پیامک
     * @return array پاسخ API یا خطا
     */
    public function sendSms($to, $message)
    {
        try {
            $response = $this->client->post("{$this->apiKey}/sms/send.json", [
                'form_params' => [
                    'receptor' => $to,
                    'message' => $message,
                ],
            ]);

            return json_decode($response->getBody()->getContents(), true);
        } catch (\Exception $e) {
            // در صورت بروز خطا، پیغام خطا را بازگردانید
            return ['error' => $e->getMessage()];
        }
    }
}
