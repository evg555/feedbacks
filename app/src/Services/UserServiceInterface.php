<?php /** @noinspection PhpUnused */

namespace src\Services;

/**
 * Interface UserServiceInterface
 * @package src\Services\UserServiceInterface
 */
interface UserServiceInterface
{
    public function sendCredentials(string $login, string $password);
}