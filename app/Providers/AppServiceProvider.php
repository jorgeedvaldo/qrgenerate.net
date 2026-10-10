<?php

namespace App\Providers;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\ServiceProvider;

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
        // Send the reset link in the language the account was created in.
        ResetPassword::createUrlUsing(function ($user, string $token) {
            $route = ($user->locale ?? 'pt') === 'en' ? 'password.reset' : 'password.reset.pt';

            return route($route, ['token' => $token, 'email' => $user->getEmailForPasswordReset()]);
        });
    }
}
