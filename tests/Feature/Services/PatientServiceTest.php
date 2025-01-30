<?php

namespace Tests\Feature\Services;

use App\Models\Patient;
use App\Repositories\IPatientRepository;
use App\Services\PatientService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Tests\TestCase;

class PatientServiceTest extends TestCase
{
    use RefreshDatabase;

    private PatientService $service;

    /** @var IPatientRepository|\Mockery\Mock */
    private $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = Mockery::mock(IPatientRepository::class);
        $this->service = new PatientService($this->repository);
    }

    public function test_it_stores_a_new_patient()
    {
        $patientData = Patient::factory()->make();

        $this->repository->shouldReceive('store')->andReturn($patientData);

        $patient = $this->service->store($patientData->toArray());

        $this->assertInstanceOf(Patient::class, $patient);
        $this->assertEquals($patientData['name'], $patient->name);
        $this->assertEquals($patientData['spacialty'], $patient->spacialty);
        $this->assertEquals($patientData['city_id'], $patient->city_id);
    }

    public function test_it_updates_a_patient()
    {
        $patient = Patient::factory()->create();
        $newPatientData = Patient::factory()->make(['id' => $patient->id]);

        $this->repository->shouldReceive('update');
        $this->repository->shouldReceive('find')->andReturn($newPatientData);

        $updatedPatient = $this->service->update($newPatientData->toArray(), $patient->id);

        $this->assertInstanceOf(Patient::class, $updatedPatient);
        $this->assertEquals($newPatientData['name'], $updatedPatient->name);
        $this->assertEquals($newPatientData['spacialty'], $updatedPatient->spacialty);
        $this->assertEquals($newPatientData['city_id'], $updatedPatient->city_id);
    }

    public function test_it_lists_patients()
    {
        Patient::factory()->count(5)->create();

        $shouldReturn = Patient::query()
            ->orderBy('name')
            ->paginate(20);

        $this->repository->shouldReceive('list')->andReturn($shouldReturn);

        $patients = $this->service->list([]);

        $this->assertInstanceOf(LengthAwarePaginator::class, $patients);

        $this->assertCount(5, $patients->items());
    }

    public function test_it_lists_patients_with_search()
    {
        Patient::factory()->count(5)->create();

        $patient = Patient::factory()->create(['name' => 'Test patient']);

        $shouldReturn = Patient::query()
            ->search('Test patient')
            ->orderBy('name')
            ->paginate(20);

        $this->repository->shouldReceive('list')->andReturn($shouldReturn);

        $patients = $this->service->list(['nome' => 'Test patient']);

        $this->assertInstanceOf(LengthAwarePaginator::class, $patients);

        $this->assertCount(1, $patients->items());
        $this->assertEquals($patient->id, $patients->items()[0]->id);
    }

    public function test_it_should_ignore_patient_prefix_in_search()
    {
        $patientA = Patient::factory()->create(['name' => 'Dr. A Test patient']);
        $patientB = Patient::factory()->create(['name' => 'Dr. B Test patient']);

        $shouldReturn = Patient::query()
            ->search('A Test patient')
            ->orderBy('name')
            ->paginate(20);

        $this->repository->shouldReceive('list')->andReturn($shouldReturn);

        $patients = $this->service->list(['nome' => 'Dr. A Test patient']);

        $this->assertInstanceOf(LengthAwarePaginator::class, $patients);
        $this->assertCount(1, $patients->items());
        $this->assertEquals($patientA->id, $patients->items()[0]->id);
    }

    public function test_it_should_not_return_a_list_with_search_that_does_not_exist()
    {
        $impossiblepatientName = 'AAaaaaaaAAAaaaaaaAAAaaaaaAAA';

        Patient::factory()->count(5)->create();

        $shouldReturn = $shouldReturn = Patient::query()
            ->search($impossiblepatientName)
            ->orderBy('name')
            ->paginate(20);

        $this->repository->shouldReceive('list')->andReturn($shouldReturn);

        $patients = $this->service->list(['nome' => $impossiblepatientName]);

        $this->assertInstanceOf(LengthAwarePaginator::class, $patients);

        $this->assertCount(0, $patients->items());
    }
}
