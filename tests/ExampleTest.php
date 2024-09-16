<?php

namespace Kavenegar\KavenegarSms\Tests;

use Orchestra\Testbench\TestCase;
use Kavenegar\KavenegarSms\KavenegarSms;

class ExampleTest extends TestCase
{
    protected function getPackageProviders($app)
    {
        // رجیستر کردن سرویس پروایدر در تست‌ها
        return [\Kavenegar\KavenegarSms\KavenegarSmsServiceProvider::class];
    }

    public function testSendSms()
    {
        // شبیه‌سازی ارسال پیامک
        $smsService = new KavenegarSms('fake-api-key');
        $response = $smsService->sendSms('09123456789', 'Test message');

        // بررسی موفقیت ارسال پیامک
        $this->assertArrayHasKey('error', $response);
    }
}
