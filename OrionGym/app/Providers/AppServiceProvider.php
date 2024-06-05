<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\CatracaService;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(CatracaService::class, function ($app) {
            return new CatracaService(env('CATRACA_HOST'), env('CATRACA_PORT'));
        });
    }

    public function boot()
    {
        //
    }
}
