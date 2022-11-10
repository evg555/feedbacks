<?php

namespace src\Models;

/**
 * Class User
 * @package src\Models
 */
class User
{
    /**
     * @var int
     */
    private int $id;
    /**
     * @var string
     */
    private string $login;
    /**
     * @var string
     */
    private string $password;

    /**
     * @return int
     */
    public function getId() : int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id) : void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getLogin() : string
    {
        return $this->login;
    }

    /**
     * @param string $login
     */
    public function setLogin(string $login) : void
    {
        $this->login = $login;
    }

    /**
     * @return string
     */
    public function getPassword() : string
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password) : void
    {
        $this->password = $password;
    }

}