<?php

namespace src\Services;

use src\Exceptions\ServiceException;
use src\Models\User;
use src\Repositories\UserRepositoryInterface;

/**
 * Class UserService
 * @package src\Services
 */
class UserService implements UserServiceInterface
{
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->repository = $userRepository;
    }

    /**
     * @param string $login
     * @param string $password
     *
     * @throws ServiceException
     */
    public function sendCredentials(string $login, string $password)
    {
        $user = new User();
        $user->setLogin($login);
        $user->setPassword($password);

        $result = $this->repository->authorize($user);

        if (!$result) {
            throw new ServiceException('Неверное имя пользователя или пароль!');
        }
    }
}