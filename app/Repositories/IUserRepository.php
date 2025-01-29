<?php

namespace App\Repositories;

use App\Models\User;

interface IUserRepository
{
    public function create(array $data): User;
}
