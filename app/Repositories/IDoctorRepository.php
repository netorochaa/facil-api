<?php

namespace App\Repositories;

use App\Models\Doctor;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface IDoctorRepository
{
    public function list(?string $searchByName = null): LengthAwarePaginator;

    public function store(array $data): Doctor;

    public function listByCity(int $cityId, ?string $searchByName = null): LengthAwarePaginator;
}
