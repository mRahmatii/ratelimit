<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
//        RateLimiter::for('api', function (Request $request) {
//            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
//        });



        RateLimiter::for('RateLimitIp', function (Request $request) {
            return config(['RateLimit.IP_ACTIVATION'] )
                ?
                Limit::none() :
                 [
                    Limit::perMinute(100)->by($request->ip()),
                    Limit::perMinutes(5,300)->by($request->ip()),
                    Limit::perMinutes(120,1000)->by($request->ip()),
                 ];
        });

        RateLimiter::for('RateLimitPhoneSMs', function (Request $request) {
            return config(['RateLimit.PHONE_SMS_ACTIVATION'] )
                ?
                Limit::none() :
                [
                    Limit::perMinute(3)->by($request->user()->phone),
                    Limit::perMinutes(5,30)->by($request->user()->phone),
                    Limit::perMinutes(360,300)->by($request->user()->phone),
                ];
        });

        RateLimiter::for('RateLimitPhoneVerify', function (Request $request) {
            return config(['RateLimit.PHONE_VERIFY_ACTIVATION'] )
                ?
                Limit::none() :
                [
                    Limit::perMinutes(1440,10)->by($request->user()->phone),
                ];
        });

        RateLimiter::for('RateLimitHome', function (Request $request) {
            return config(['RateLimit.HOME_ACTIVATION'] )
                ?
                Limit::none() :
                [
                    Limit::perMinutes(1440,1000)->by($request->ip()),
                ];
        });



    }
}
