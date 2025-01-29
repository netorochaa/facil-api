<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\IUserRepository;

class UserService
{
    public function __construct(
        protected IUserRepository $userRepository
    ) {}

    public function create(array $data): User
    {
        return $this->userRepository->create($data);
    }
}
