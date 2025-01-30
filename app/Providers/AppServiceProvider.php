<?php

namespace App\Providers;

use App\Repositories\Eloquent\AppointmentRepositoryEloquent;
use App\Repositories\Eloquent\CityRepositoryEloquent;
use App\Repositories\Eloquent\DoctorRepositoryEloquent;
use App\Repositories\Eloquent\PatientRepositoryEloquent;
use App\Repositories\Eloquent\UserRepositoryEloquent;
use App\Repositories\IAppointmentRepository;
use App\Repositories\ICityRepository;
use App\Repositories\IDoctorRepository;
use App\Repositories\IPatientRepository;
use App\Repositories\IUserRepository;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(IUserRepository::class, UserRepositoryEloquent::class);
        $this->app->bind(ICityRepository::class, CityRepositoryEloquent::class);
        $this->app->bind(IDoctorRepository::class, DoctorRepositoryEloquent::class);
        $this->app->bind(IPatientRepository::class, PatientRepositoryEloquent::class);
        $this->app->bind(IAppointmentRepository::class, AppointmentRepositoryEloquent::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Str::macro('removeDoctorPrefix', function (string $string) {
            return str_replace(['dr', 'dra', 'Dr', 'Dra', '.'], '', $string);
        });
    }
}
