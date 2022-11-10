<?php /** @noinspection PhpUnused */

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
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
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

        $result = $this->userRepository->authorize($user);

        if (!$result) {
            throw new ServiceException('Неверное имя пользователя или пароль!');
        }
    }
}