<?php

namespace Tests\Feature\Services;

use App\Models\Appointment;
use App\Repositories\IAppointmentRepository;
use App\Services\AppointmentService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Tests\TestCase;

class AppointmentServiceTest extends TestCase
{
    use RefreshDatabase;

    private AppointmentService $service;

    /** @var IAppointmentRepository|\Mockery\Mock */
    private $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = Mockery::mock(IAppointmentRepository::class);
        $this->service = new AppointmentService($this->repository);
    }

    public function test_it_stores_a_new_appointment()
    {
        $appointmentData = Appointment::factory()->make();

        $this->repository->shouldReceive('store')->andReturn($appointmentData);

        $appointment = $this->service->store($appointmentData->toArray());

        $this->assertInstanceOf(Appointment::class, $appointment);
        $this->assertEquals($appointmentData->doctor->name, $appointment->doctor->name);
        $this->assertEquals($appointmentData->patient->name, $appointment->patient->name);
    }

    public function test_it_lists_appointments()
    {
        Appointment::factory()->count(5)->create();

        $shouldReturn = Appointment::query()->paginate(20);

        $this->repository->shouldReceive('list')->andReturn($shouldReturn);

        $appointments = $this->service->list();

        $this->assertInstanceOf(LengthAwarePaginator::class, $appointments);

        $this->assertCount(5, $appointments->items());
    }
}
