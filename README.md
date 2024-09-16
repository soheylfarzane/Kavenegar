# Kavenegar SMS Laravel Package

This package allows you to send SMS messages using the Kaveh Negar API in Laravel.

## Installation

1. Run `composer require kavenegar/kavenegar-sms`.
2. Publish the config file: `php artisan vendor:publish --provider="Kavenegar\KavenegarSms\KavenegarSmsServiceProvider"`.

## Usage

To send an SMS:

```php
use Kavenegar\KavenegarSms\KavenegarSms;

$smsService = new KavenegarSms();
$response = $smsService->sendSms('09123456789', 'Your message here');
