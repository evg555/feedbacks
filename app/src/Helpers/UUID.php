<?php

namespace src\Helpers;

use src\Stores\MySqlStore;

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
     */
    public static function create(string $table) : ?int
    {
        //TODO: переписать на синглтон
        $db = new MySqlStore();
        $lastId = $db->getLastId($table);

        return $lastId + 1;
    }
}