<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\SportsSchool;

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
