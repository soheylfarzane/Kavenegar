<?php

namespace Kavenegar\KavenegarSms;

use Illuminate\Support\ServiceProvider;

class KavenegarSmsServiceProvider extends ServiceProvider
{
    /**
     * ثبت سرویس در Container لاراول
     */
    public function register()
    {
        // رجیستر کردن سرویس با استفاده از Singleton
        $this->app->singleton(KavenegarSms::class, function ($app) {
            return new KavenegarSms(config('kavenegar.api_key'));
        });
    }

    /**
     * بارگذاری تنظیمات و پیکربندی‌ها
     */
    public function boot()
    {
        // انتشار فایل‌های تنظیمات برای لاراول
        $this->publishes([
            __DIR__.'/../config/kavenegar.php' => config_path('kavenegar.php'),
        ]);
        $this->loadMigrationsFrom(__DIR__ . '/migrations');
    }
}
