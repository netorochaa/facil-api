<?php

namespace Tests\Feature\Repositories;

use App\Models\City;
use App\Repositories\Eloquent\CityRepositoryEloquent;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CityRepositoryEloquentTest extends TestCase
{
    use RefreshDatabase;

    private CityRepositoryEloquent $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = new CityRepositoryEloquent;
    }

    public function test_it_lists_cities()
    {
        City::factory()->count(5)->create();

        $cities = $this->repository->list(null);

        $this->assertInstanceOf(LengthAwarePaginator::class, $cities);

        $this->assertCount(5, $cities->items());
    }

    public function test_it_lists_cities_with_search()
    {
        City::factory()->count(5)->create();

        $city = City::factory()->create(['name' => 'Test City']);

        $cities = $this->repository->list('Test City');

        $this->assertInstanceOf(LengthAwarePaginator::class, $cities);

        $this->assertCount(1, $cities->items());
        $this->assertEquals($city->id, $cities->items()[0]->id);
    }

    public function test_it_should_not_list_with_search_that_does_not_exist()
    {
        City::factory()->count(5)->create();

        $cities = $this->repository->list('AAaaaaaaAAAaaaaaaAAAaaaaaAAA');

        $this->assertInstanceOf(LengthAwarePaginator::class, $cities);

        $this->assertCount(0, $cities->items());
    }
}
