<?php

namespace App\Providers;

use App\Repositories\CamEloquentORM;
use App\Repositories\Contracts\CamRepositoryInterface;
use Illuminate\Support\ServiceProvider;
use App\Repositories\IntegrationEloquentORM;
use App\Repositories\Contracts\IntegrationRepositoryInterface;

class AppServiceProvider extends ServiceProvider {
    /**
     * Register any application services.
     */
    public function register(): void {
        $this->app->bind(
            IntegrationRepositoryInterface::class,
            IntegrationEloquentORM::class
        );
        $this->app->bind(
            CamRepositoryInterface::class,
            CamEloquentORM::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void {
        //
    }
}
