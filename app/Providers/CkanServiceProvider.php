<?php

namespace App\Providers;

use App\Services\CkanApi\CkanApiClient;
use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;

class CkanServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind('App\Services\CkanApi\CkanApiClient', function () {

            $config = [
                'base_uri' => config('ckan_api.url'),
                'headers' => ['Authorization' => config('ckan_api.api_key')],
            ];

            return new CkanApiClient(new Client($config));
        });

        $this->app->alias('App\Services\CkanApi\CkanApiClient', 'CkanApi');
    }
}
