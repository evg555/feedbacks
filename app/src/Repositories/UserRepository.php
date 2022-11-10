<?php

namespace src\Repositories;

use src\Models\User;

/**
 * Class UserRepository
 * @package src\Repositories
 */
class UserRepository extends Repository implements UserRepositoryInterface
{
    public function authorize(User $user): bool
    {
        $result = $this->db->get('users', [
            'filter' => [
                'login' => $user->getLogin(),
                'password' => md5($user->getPassword())
            ]
        ]);

        if (!empty($result)) {
            session_start();
            $_SESSION['user'] = $user->getLogin();
            $_SESSION['authorized'] = true;

            return true;
        }

        return false;
    }
}