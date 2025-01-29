<?php

namespace App\Repositories;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface IDoctorRepository
{
    public function list(?string $searchByName = null): LengthAwarePaginator;
}
