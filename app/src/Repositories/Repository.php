<?php /** @noinspection PhpPropertyNamingConventionInspection */

namespace src\Repositories;

use src\Exceptions\DatabaseException;
use src\Services\Connection;

/**
 * Class Repository
 * @package src\Repositories
 */
class Repository
{
    /**
     * @var Connection
     */
    protected Connection $db;

    /**
     * @throws DatabaseException
     */
    public function __construct()
    {
        $this->db = Connection::getInstance();
    }
}