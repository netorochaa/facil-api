<?php

use App\Http\Controllers\Api\CityController;
use App\Http\Controllers\Api\DoctorController;
use App\Http\Controllers\Api\PatientController;
use App\Http\Controllers\Auth\Api\JWTAuthController;
use App\Http\Middleware\JwtMiddleware;
use Illuminate\Support\Facades\Route;

Route::post('register', [JWTAuthController::class, 'register'])->name('register');
Route::post('login', [JWTAuthController::class, 'login'])->name('login');

Route::get('cidades', [CityController::class, 'index'])->name('cities.index');
Route::get('medicos', [DoctorController::class, 'index'])->name('doctors.index');

Route::middleware([JwtMiddleware::class])->group(function () {
    Route::get('user', [JWTAuthController::class, 'getUser']);
    Route::post('logout', [JWTAuthController::class, 'logout']);

    Route::post('medicos', [DoctorController::class, 'store'])->name('doctors.store');

    Route::get('pacientes', [PatientController::class, 'index'])->name('patients.index');
    Route::post('pacientes', [PatientController::class, 'store'])->name('patients.store');
    Route::put('pacientes/{id}', [PatientController::class, 'update'])->name('patients.update');
});
