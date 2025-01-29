<?php

namespace Tests\Feature\Services;

use App\Models\User;
use App\Repositories\IUserRepository;
use App\Services\UserService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Tests\TestCase;

class UserServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_creates_a_new_user()
    {
        /** @var IUserRepository|Mockery\Mock */
        $userRepositoryMock = Mockery::mock(IUserRepository::class);
        $userRepositoryMock->shouldReceive('create')->andReturn(new User);

        $userService = new UserService($userRepositoryMock);

        $user = $userService->create([
            'name' => 'User Test',
            'email' => 'user@test.com',
            'password' => bcrypt('password'),
        ]);

        $this->assertInstanceOf(User::class, $user);
    }
}
