<?php

namespace vendor\My\Core\Container;

/**
 * Describes the interface of a container that exposes methods to read its entries.
 */
interface ContainerInterface
{
    /**
     * @param string $id
     *
     * @return mixed
     */
    public function get(string $id);

    /**
     * @param string $id
     *
     * @return bool
     */
    public function has(string $id): bool;
}