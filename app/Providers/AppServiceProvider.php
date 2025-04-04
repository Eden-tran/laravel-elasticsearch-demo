<?php

namespace App\Providers;

use App\Services\ElasticsearchService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register()
    {
        $this->app->singleton(ElasticsearchService::class, function ($app) {
            return new ElasticsearchService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
