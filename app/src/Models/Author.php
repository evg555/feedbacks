<?php

namespace src\Models;

/**
 * Class Author
 * @package src\Models
 */
class Author
{
    /**
     * @var string
     */
    private string $name;
    /**
     * @var string
     */
    private string $email;

    /**
     * @return string
     */
    public function getName() : string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name) : void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getEmail() : string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email) : void
    {
        $this->email = $email;
    }
}