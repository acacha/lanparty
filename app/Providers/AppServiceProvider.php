<?php

namespace App\Providers;

use Acacha\User\GuestUser;
use App\InvitationCodeGenerator;
use App\InvitationCodeGeneratorComplex;
use App\InvitationCodeGeneratorSimple;
use App\Member;
use App\Observers\MemberObserver;
use Auth;
use Carbon\Carbon;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\Resources\Json\Resource;
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
        Resource::withoutWrapping();
        Member::observe(MemberObserver::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(InvitationCodeGenerator::class, function() {
            if (config('codes.type') == 'simple') {
                return new InvitationCodeGeneratorSimple();
            } elseif (config('codes.type') == 'complex')  {
                return new InvitationCodeGeneratorComplex();
            } else {
                throw new BindingResolutionException();
            }
        });
    }
}
