# Kavenegar SMS Laravel Package

این پکیج به شما امکان می‌دهد تا پیامک‌های متنی را با استفاده از API کاوه نگار در لاراول ارسال کنید.

## نصب

1. برای نصب پکیج، دستور زیر را اجرا کنید:
    ```bash
    composer require kavenegar/kavenegar-sms
    ```
2. فایل تنظیمات را با استفاده از دستور زیر منتشر کنید:
    ```bash
    php artisan vendor:publish --provider="Kavenegar\KavenegarSms\KavenegarSmsServiceProvider"
    ```

## استفاده

### ارسال پیامک

برای ارسال پیامک، از متد `sendSms` استفاده کنید:

```php
use Kavenegar\KavenegarSms\KavenegarSms;

$smsService = new KavenegarSms();
$response = $smsService->sendSms('09123456789', 'Your message here');
