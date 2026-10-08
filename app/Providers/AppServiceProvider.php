<?php

namespace App\Providers;

use App\Models\SportsSchool;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

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
        RateLimiter::for('mobile-login', function (Request $request) {
            $email = $request->input('email');
            $email = is_string($email) ? Str::lower(trim($email)) : '';

            return [
                Limit::perMinute(20)->by('mobile-login-ip:'.$request->ip()),
                Limit::perMinute(5)->by('mobile-login-email:'.hash('sha256', $email.'|'.$request->ip())),
            ];
        });

        RateLimiter::for('mobile-register', function (Request $request) {
            return [
                Limit::perMinute(5)->by('mobile-register-minute:'.$request->ip()),
                Limit::perHour(20)->by('mobile-register-hour:'.$request->ip()),
            ];
        });

        RateLimiter::for('mobile-auth', function (Request $request) {
            return Limit::perMinute(60)->by('mobile-auth:'.$request->user()->id);
        });

        // Share sports schools with login view
        View::composer('auth.login', function ($view) {
            $schools = SportsSchool::where('is_active', true)
                ->whereNotNull('logo')
                ->select('id', 'name', 'logo')
                ->get();
            $view->with('schools', $schools);
        });
    }
}
