<?php

namespace App\Providers;

use App\Repositories\Eloquent\CityRespositoryEloquent;
use App\Repositories\Eloquent\UserRespositoryEloquent;
use App\Repositories\ICityRepository;
use App\Repositories\IUserRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(IUserRepository::class, UserRespositoryEloquent::class);
        $this->app->bind(ICityRepository::class, CityRespositoryEloquent::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
