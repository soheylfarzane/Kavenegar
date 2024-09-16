<?php

namespace Kavenegar\KavenegarSms\Services;

use Illuminate\Support\Facades\Http;
use Kavenegar\KavenegarSms\Repositoties\VerifyRepository;

class KavenegarSms
{



    public function __construct()
    {

    }

    /**
     * ارسال پیامک به یک گیرنده
     *
     * @param string $to شماره گیرنده
     * @param string $template عنوان الگو پیامکی
     * @return array پاسخ API یا خطا
     */
    public static function sendWithTemplate($to, $token,$template)
    {
        $query = http_build_query([
            'receptor' => $to,
            'token' => $token,
            'template' => $template,
        ]);
        $api = (new KavenegarSms)->apiKey();
        $url = "https://api.kavenegar.com/v1/".$api."/verify/lookup.json?{$query}";
        try {
            $response = Http::withoutVerifying()->get($url);

            if ($response->failed()) {
                // در صورت بروز خطا، پیغام خطا را ثبت کنید
                return ['error' => $response->body()];
            }
            return $response->json();
        } catch (\Exception $e) {
            // در صورت بروز استثنا، پیغام خطا را بازگردانید
            return ['error' => $e->getMessage()];
        }
    }
    public static function sendVerify($to,$template = "verfiy")
    {
        $verifyRepository = new VerifyRepository();
        if ($verifyRepository->isCodeSend($to))
        {
            if (!$verifyRepository->canSendNewCode($to))
            {
                return
                    [
                        "status" => false,
                        "message" => "برای ارسال مجدد کمی صبر کنید",
                    ];
            }
            $verifyRepository->deleteOldCode($to);
            (new KavenegarSms)->sendOtpCode($to,$template);
            return
                [
                    "status" => true,
                    "message" => "با موفقیت ارسال شد",
                ];

        }else
        {
            (new KavenegarSms)->sendOtpCode($to,$template);
            return
                [
                    "status" => true,
                    "message" => "با موفقیت ارسال شد",
                ];
        }

    }

    private function sendOtpCode($to,$template = "verfiy")
    {
        $verifyRepository = new VerifyRepository();
        $token = rand(1111,9999);
        $query = http_build_query([
            'receptor' => $to,
            'token' => $token,
            'template' => $template,
        ]);
        $api = (new KavenegarSms)->apiKey();
        $url = "https://api.kavenegar.com/v1/".$api."/verify/lookup.json?{$query}";
        try {
            $response = Http::withoutVerifying()->get($url);

            if ($response->failed()) {
                // در صورت بروز خطا، پیغام خطا را ثبت کنید
                return ['error' => $response->body()];
            }

            $verifyRepository->storeCode($to,$token);
            return
                [
                    "status" => true,
                    "message" => "با موفقیت ارسال شد",
                ];
//                return $response->json();
        } catch (\Exception $e) {
            // در صورت بروز استثنا، پیغام خطا را بازگردانید
            return ['error' => $e->getMessage()];
        }
    }

    public static function verify($phone,$code)
    {
        $verifyRepository = new VerifyRepository();
        if ($verifyRepository->verifyCode($phone,$code))
        {
            $verifyRepository->deleteOldCode($phone);
            return true;
        }else
        {
            return false;
        }
    }

    private function apiKey()
    {
        return config("kavenegar.api_key");
    }
}
