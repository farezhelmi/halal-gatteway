<?php

namespace App\Providers;

use App\Models\Usr\Users;
use App\Models\Sys\RoleUsers;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
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
        // Force HTTPS in production
        // if ($this->app->environment('production')) {
        //     URL::forceScheme('https');
        // }
        //compose all the views....
        view()->composer('*', function ($view) 
        {
            $roleUser = RoleUsers::where('user_id', '=', Auth::id())->get();
            $view->with('roleUser', $roleUser );    
        }); 
    }
}
