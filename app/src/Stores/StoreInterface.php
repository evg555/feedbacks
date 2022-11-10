<?php

namespace src\Stores;

/**
 *
 */
interface StoreInterface
{
    /**
     * @param string $table
     * @param array $params
     *
     * @return array
     */
    public function get(string $table, array $params): array;

    /**
     * @param string $table
     * @param array $data
     */
    public function insert(string $table, array $data): void;

    /**
     * @param string $table
     * @param array $data
     */
    public function update(string $table, array $data): void;

    /**
     * @param string $table
     * @param string $uniqueField
     * @param array $fields
     */
    public function insertOrUpdate(string $table, string $uniqueField, array $fields): void;

    public function transactionBegin(): void;

    public function transactionCommit(): void;

    /**
     * @return bool
     */
    public function isSuccess() : bool;

    /**
     * @param string $table
     *
     * @return int
     */
    public function getLastId(string $table): int;
}