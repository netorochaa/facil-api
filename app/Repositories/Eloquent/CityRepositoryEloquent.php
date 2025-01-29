<?php

namespace App\Repositories\Eloquent;

use App\Models\City;
use App\Repositories\ICityRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class CityRepositoryEloquent implements ICityRepository
{
    public function list(?string $searchByName = null): LengthAwarePaginator
    {
        return City::query()
            ->search($searchByName)
            ->orderBy('name')
            ->paginate(20);
    }
}
