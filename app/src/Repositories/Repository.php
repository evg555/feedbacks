<?php /** @noinspection PhpPropertyNamingConventionInspection */

namespace src\Repositories;

use src\Stores\StoreInterface;

/**
 * Class Repository
 * @package src\Repositories
 */
class Repository
{
    /**
     * @var StoreInterface
     */
    protected StoreInterface $db;

    public function __construct(StoreInterface $db)
    {
        $this->db = $db;
    }
}