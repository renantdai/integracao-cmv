<?php

namespace App\Providers;

use App\Repositories\CamEloquentORM;
use App\Repositories\Contracts\CamRepositoryInterface;
use App\Repositories\Contracts\DirectoryRepositoryInterface;
use Illuminate\Support\ServiceProvider;
use App\Repositories\IntegrationEloquentORM;
use App\Repositories\Contracts\IntegrationRepositoryInterface;
use App\Repositories\DirectoryEloquentORM;

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
        $this->app->bind(
            DirectoryRepositoryInterface::class,
            DirectoryEloquentORM::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void {
        //
    }
}
