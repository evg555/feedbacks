<?php

namespace src\Helpers;

use src\Exceptions\DatabaseException;
use src\Services\Connection;

/**
 * Class UUID
 * @package src\Helpers
 */
class UUID
{
    /**
     * @param string $table
     *
     * @return int|null
     * @throws DatabaseException
     */
    public static function create(string $table) : ?int
    {
        $db = Connection::getInstance();
        $lastId = $db->getLastId($table);

        return $lastId + 1;
    }
}