<?php

namespace src\Repositories;

use src\Models\User;

/**
 * Interface UserRepositoryInterface
 * @package src\Repositories
 */
interface UserRepositoryInterface
{
    public function authorize(User $user): bool;
}