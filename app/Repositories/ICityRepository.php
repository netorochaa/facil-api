<?php

namespace App\Repositories;

use Illuminate\Pagination\LengthAwarePaginator;

interface ICityRepository
{
    public function list(?string $searchByName = null): LengthAwarePaginator;
}
