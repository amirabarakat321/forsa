<?php

namespace App\Providers;

use Illuminate\Http\Resources\Json\Resource;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
//        $ip = $_SERVER['REMOTE_ADDR'];  //$_SERVER['REMOTE_ADDR']
//        $ipInfo = file_get_contents('http://ip-api.com/json/' . $ip);
//        $ipInfo = json_decode($ipInfo);
//        $timezone = $ipInfo->timezone;
//        date_default_timezone_set($timezone);
//        Schema::defaultStringLength(191);
//        Schema::enableForeignKeyConstraints();
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
//        $this->app->bind(
//            AccessToken::class, function ($app) {
//                $TWILIO_ACCOUNT_SID = env('TWILIO_SID');
//                $TWILIO_API_KEY =  env('TWILIO_CHAT_API_KEY');
//                $TWILIO_API_SECRET = env('TWILIO_CHAT_API_SECRET');
//
//                $token = new AccessToken(
//                    $TWILIO_ACCOUNT_SID,
//                    $TWILIO_API_KEY,
//                    $TWILIO_API_SECRET,
//                    3600
//                );
//
//                return $token;
//            }
//        );
    }
}
