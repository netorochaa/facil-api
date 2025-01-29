<?php

namespace Tests\Feature\Repositories;

use App\Models\Doctor;
use App\Repositories\Eloquent\DoctorRepositoryEloquent;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DoctorRepositoryEloquentTest extends TestCase
{
    use RefreshDatabase;

    private DoctorRepositoryEloquent $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = new DoctorRepositoryEloquent;
    }

    public function test_it_lists_doctors()
    {
        Doctor::factory()->count(5)->create();

        $doctors = $this->repository->list(null);

        $this->assertInstanceOf(LengthAwarePaginator::class, $doctors);

        $this->assertCount(5, $doctors->items());
    }

    public function test_it_lists_doctors_with_search()
    {
        Doctor::factory()->count(5)->create();

        $Doctor = Doctor::factory()->create(['name' => 'Test Doctor']);

        $doctors = $this->repository->list('Test Doctor');

        $this->assertInstanceOf(LengthAwarePaginator::class, $doctors);

        $this->assertCount(1, $doctors->items());
        $this->assertEquals($Doctor->id, $doctors->items()[0]->id);
    }

    public function test_it_should_not_list_with_search_that_does_not_exist()
    {
        Doctor::factory()->count(5)->create();

        $doctors = $this->repository->list('AAaaaaaaAAAaaaaaaAAAaaaaaAAA');

        $this->assertInstanceOf(LengthAwarePaginator::class, $doctors);

        $this->assertCount(0, $doctors->items());
    }
}
