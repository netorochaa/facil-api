<?php

namespace App\Traits\Tests;

use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;

trait ActingJwt
{
    public ?User $user = null;

    public ?string $token = null;

    public function actingJwt(): void
    {
        $this->user = User::factory()->create();
        $this->token = JWTAuth::fromUser($this->user);
    }
}
