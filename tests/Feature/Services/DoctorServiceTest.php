<?php

namespace Tests\Feature\Services;

use App\Models\Doctor;
use App\Repositories\IDoctorRepository;
use App\Services\DoctorService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Tests\TestCase;

class DoctorServiceTest extends TestCase
{
    use RefreshDatabase;

    private DoctorService $service;

    /** @var IDoctorRepository|\Mockery\Mock */
    private $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = Mockery::mock(IDoctorRepository::class);
        $this->service = new DoctorService($this->repository);
    }

    public function test_it_lists_doctors()
    {
        Doctor::factory()->count(5)->create();

        $shouldReturn = Doctor::query()
            ->orderBy('name')
            ->paginate(20);

        $this->repository->shouldReceive('list')->andReturn($shouldReturn);

        $doctors = $this->service->list([]);

        $this->assertInstanceOf(LengthAwarePaginator::class, $doctors);

        $this->assertCount(5, $doctors->items());
    }

    public function test_it_lists_doctors_with_search()
    {
        Doctor::factory()->count(5)->create();

        $Doctor = Doctor::factory()->create(['name' => 'Test Doctor']);

        $shouldReturn = Doctor::query()
            ->search('Test Doctor')
            ->orderBy('name')
            ->paginate(20);

        $this->repository->shouldReceive('list')->andReturn($shouldReturn);

        $doctors = $this->service->list(['nome' => 'Test Doctor']);

        $this->assertInstanceOf(LengthAwarePaginator::class, $doctors);

        $this->assertCount(1, $doctors->items());
        $this->assertEquals($Doctor->id, $doctors->items()[0]->id);
    }

    public function test_it_should_ignore_doctor_prefix_in_search()
    {
        $doctorA = Doctor::factory()->create(['name' => 'Dr. A Test Doctor']);
        $doctorB = Doctor::factory()->create(['name' => 'Dr. B Test Doctor']);

        $shouldReturn = Doctor::query()
            ->search('A Test Doctor')
            ->orderBy('name')
            ->paginate(20);

        $this->repository->shouldReceive('list')->andReturn($shouldReturn);

        $doctors = $this->service->list(['nome' => 'Dr. A Test Doctor']);

        $this->assertInstanceOf(LengthAwarePaginator::class, $doctors);
        $this->assertCount(1, $doctors->items());
        $this->assertEquals($doctorA->id, $doctors->items()[0]->id);
    }

    public function test_it_should_not_return_a_list_with_search_that_does_not_exist()
    {
        $impossibleDoctorName = 'AAaaaaaaAAAaaaaaaAAAaaaaaAAA';

        Doctor::factory()->count(5)->create();

        $shouldReturn = $shouldReturn = Doctor::query()
            ->search($impossibleDoctorName)
            ->orderBy('name')
            ->paginate(20);

        $this->repository->shouldReceive('list')->andReturn($shouldReturn);

        $doctors = $this->service->list(['nome' => $impossibleDoctorName]);

        $this->assertInstanceOf(LengthAwarePaginator::class, $doctors);

        $this->assertCount(0, $doctors->items());
    }
}
