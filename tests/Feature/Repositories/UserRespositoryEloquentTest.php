<?php

namespace Tests\Feature\Repositories;

use App\Models\User;
use App\Repositories\Eloquent\UserRespositoryEloquent;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserRespositoryEloquentTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_creates_a_new_user()
    {
        $repository = new UserRespositoryEloquent;

        $user = $repository->create([
            'name' => 'User Test',
            'email' => 'user@test.com',
            'password' => bcrypt('password'),
        ]);

        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals('User Test', $user->name);
        $this->assertEquals('user@test.com', $user->email);
    }
}
