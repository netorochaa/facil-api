<?php

namespace Tests\Feature\Services;

use App\Models\City;
use App\Repositories\ICityRepository;
use App\Services\CityService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Tests\TestCase;

class CityServiceTest extends TestCase
{
    use RefreshDatabase;

    private CityService $service;

    /** @var ICityRepository|\Mockery\Mock */
    private $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = Mockery::mock(ICityRepository::class);
        $this->service = new CityService($this->repository);
    }

    public function test_it_lists_cities()
    {
        City::factory()->count(5)->create();

        $shouldReturn = City::query()
            ->orderBy('name')
            ->paginate(20);

        $this->repository->shouldReceive('list')->andReturn($shouldReturn);

        $cities = $this->service->list([]);

        $this->assertInstanceOf(LengthAwarePaginator::class, $cities);

        $this->assertCount(5, $cities->items());
    }

    public function test_it_lists_cities_with_search()
    {
        City::factory()->count(5)->create();

        $city = City::factory()->create(['name' => 'Test City']);

        $shouldReturn = City::query()
            ->search('Test City')
            ->orderBy('name')
            ->paginate(20);

        $this->repository->shouldReceive('list')->andReturn($shouldReturn);

        $cities = $this->service->list(['nome' => 'Test City']);

        $this->assertInstanceOf(LengthAwarePaginator::class, $cities);

        $this->assertCount(1, $cities->items());
        $this->assertEquals($city->id, $cities->items()[0]->id);
    }

    public function test_it_should_not_return_a_list_with_search_that_does_not_exist()
    {
        $impossibleCityName = 'AAaaaaaaAAAaaaaaaAAAaaaaaAAA';

        City::factory()->count(5)->create();

        $shouldReturn = $shouldReturn = City::query()
            ->search($impossibleCityName)
            ->orderBy('name')
            ->paginate(20);

        $this->repository->shouldReceive('list')->andReturn($shouldReturn);

        $cities = $this->service->list(['nome' => $impossibleCityName]);

        $this->assertInstanceOf(LengthAwarePaginator::class, $cities);

        $this->assertCount(0, $cities->items());
    }
}
