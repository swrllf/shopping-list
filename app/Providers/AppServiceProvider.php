<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password; // <-- Добавлен импорт

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Устанавливаем минимальную длину пароля - 10 символов
        Password::defaults(function () {
            return Password::min(10);
        });
    }
}