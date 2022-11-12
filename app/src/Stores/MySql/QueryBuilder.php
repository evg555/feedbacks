<?php

namespace src\Stores\MySql;

/**
 * Class QueryBuilder
 * @package src\Stores\MySql
 */
class QueryBuilder
{
    private string $query;
    private string $table;

    public function __construct(string $table)
    {
        $this->table = $table;
        $this->query = 'SELECT ';
    }

    public function setSelect(array $fields = []): QueryBuilder
    {
        if (!empty($fields)) {
            foreach ($fields as &$field) {
                if (stripos($field, '.') === false) {
                    $field = $this->table . '.' . $field;
                }
            }

            $select = implode(', ', $fields);
            $this->query .=  " $select ";
        } else {
            $this->query .=  " * ";
        }

        $this->query .= "FROM $this->table ";
        return $this;
    }

    public function setJoin(array $join = []): QueryBuilder
    {
        if (empty($join)) {
            return $this;
        }

        $this->query .= "LEFT JOIN {$join['table']} ON $this->table.{$join['id']} = {$join['table']}.id";
        return $this;
    }

    public function setFilter(array $filter = []): QueryBuilder
    {
        if (empty($filter)) {
            return $this;
        }

        $this->query .= ' WHERE ';

            $conditions = [];
            foreach ($filter as $field => $value) {
                if (stripos($field, '.')  === false) {
                    $field = $this->table . '.' . $field;
                }

                if (is_string($value)) {
                    $value = "'$value'";
                }

                $conditions[] = $field . ' = ' . $value;
            }

        $this->query .= implode(' AND ', $conditions);
        return $this;
    }

    public function setSort(string $sort = ''): QueryBuilder
    {
        if (!$sort) {
            return $this;
        }

        if (strpos($sort, '.')  === false) {
            $sort = $this->table . '.' . $sort;
        }

        $this->query .= " ORDER BY $sort DESC";
        return $this;
    }

    public function getQuery(): string
    {
        return $this->query;
    }
}