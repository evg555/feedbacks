<?php /** @noinspection PhpAssignmentInConditionInspection */

namespace src\Stores\MySql;

use PDO;
use PDOException;
use PDOStatement;
use src\Exceptions\DatabaseException;
use src\Stores\StoreInterface;

/**
 * Class MySqlStore
 * @package src\Services
 */
class MySqlStore implements StoreInterface
{
    /**
     * @var PDO
     */
    private PDO $connection;
    /**
     * @var bool
     */
    private bool $success = true;

    /**
     * @var int
     */
    private int $insertId = 0;

    /**
     * @return int
     */
    public function getInsertId(): int
    {
        return $this->insertId;
    }

    /**
     * @throws DatabaseException
     */
    public function __construct()
    {
        try {
            $this->connection = new PDO(
                'mysql:host=' . MYSQL_HOST . ';dbname=' . MYSQL_DB .';charset=utf8',
                MYSQL_LOGIN, MYSQL_PASS,
                [
                    PDO::ATTR_PERSISTENT => true,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                ]
            );
        } catch (PDOException $exception) {
            throw new DatabaseException('Невозможно уcтановить соединение с БД: ' . $exception->getMessage());
        }
    }

    public function insertOrUpdate(string $table, string $uniqueField, array $fields): void
    {
        $value = $fields[$uniqueField];

        if (is_bool($value)) {
            $value = (int) $value;
        }

        if (is_string($value)) {
            $value = "'$value'";
        }

        $query = "SELECT id from $table WHERE $uniqueField = $value 
                    ORDER BY $uniqueField LIMIT 1";

        $id = $this->query($query)->fetchColumn();

        if ($id) {
            $fields['id'] = (int) $id;
            $this->update($table, $fields);
            $this->insertId = $fields['id'];
        } else {
            $this->insert($table, $fields);
        }
    }

    /**
     * @return bool
     */
    public function isSuccess() : bool
    {
        return $this->success;
    }

    /**
     * @param string $table
     * @param array $data
     */
    public function insert(string $table, array $data): void
    {
        $query = "INSERT INTO $table SET ";

        $fields = [];
        foreach ($data as $field => $value) {
            if (is_bool($value)) {
                $value = (int) $value;
            }

            if (is_string($value)) {
                $value = "'$value'";
            }

            $fields[] = $field . ' = ' . $value;
        }

        $query .= implode(', ', $fields);

        $result = $this->query($query);

        if ($result instanceof PDOStatement) {
            $this->insertId = $this->connection->lastInsertId();
        }
    }

    /**
     * @param string $table
     * @param array|null $params
     *
     * @return array
     */
    public function get(string $table, array $params = []): array
    {
        $builder = new QueryBuilder($table);

        $query = $builder->setSelect((array) $params['select'])
            ->setJoin((array) $params['join'])
            ->setFilter((array) $params['filter'])
            ->setSort((string) $params['sort'])
            ->getQuery();

        $result = $this->query($query);
        $data = [];

        if ($result instanceof PDOStatement) {
            while ($row = $result->fetch()) {
                $data[] = $row;
            }

            return $data;
        }

        return [];
    }

    /**
     * @param string $table
     * @param array $data
     */
    public function update(string $table, array $data): void
    {
        $rowId = $data['id'];
        unset($data['id']);

        $query = "UPDATE $table SET ";

        $fields = [];
        foreach ($data as $field => $value) {
            if (is_bool($value)) {
                $value = (int) $value;
            }

            if (is_string($value)) {
                $value = "'$value'";
            }

            $fields[] = $field . ' = ' . $value;
        }

        $query .= implode(', ', $fields);

        $query .= " WHERE id = $rowId";

        $this->query($query);
    }

    public function transactionBegin(): void
    {
        $this->connection->beginTransaction();
    }

    /**
     * @return bool
     */
    public function transactionCommit(): bool
    {
        return $this->connection->commit();
    }

    /**
     * @param $query
     *
     * @return false|PDOStatement
     */
    private function query($query)
    {
        $this->success = true;
        $this->insertId = 0;

        $result = $this->connection->query($query);

        if (!$result) {
            $this->success = false;
        }

        return $result;
    }

    public function transactionRollback() : void
    {
        $this->connection->rollBack();
    }
}