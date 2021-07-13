<?php

namespace IvaoSocialite;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class IvaoSocialiteServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(ClientInterface::class, Client::class);
    }

    public function boot()
    {
        $socialite = $this->app->make('Laravel\Socialite\Contracts\Factory');
        $socialite->extend(
            'ivao',
            function ($app) {
                $config = $app['config']['services.ivao'];
                $redirect = Str::startsWith($config["redirect"], '/') ? $this->app->make('url')->to($config["redirect"]) : $config["redirect"];

                return new IvaoProvider($this->app->make(Request::class), $this->app->make(UserDataHttpClient::class), $redirect);
            }
        );
    }
}