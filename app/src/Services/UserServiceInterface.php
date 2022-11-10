<?php

namespace src\Services;

interface UserServiceInterface
{
    public function sendCredentials(string $login, string $password);
}