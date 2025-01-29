<?php

namespace App\Repositories\Eloquent;

use App\Models\City;
use App\Repositories\ICityRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class CityRespositoryEloquent implements ICityRepository
{
    public function list(?string $searchByName = null): LengthAwarePaginator
    {
        return City::query()
            ->search($searchByName)
            ->orderBy('name')
            ->paginate(20);
    }
}
