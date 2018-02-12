<?php

namespace App\Providers;

use Acacha\User\GuestUser;
use Auth;
use Illuminate\Support\ServiceProvider;
use View;

/**
 * Class AppServiceProvider
 *
 * @package App\Providers
 */
class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('*', function($view) {
            if (Auth::user()) {
                $view->with('user',Auth::user());
            } else {
                $view->with('user',new GuestUser);
            }
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
