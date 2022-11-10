<?php /** @noinspection PhpAssignmentInConditionInspection */

namespace src\Services;

use mysqli;
use mysqli_result;
use src\Exceptions\DatabaseException;

/**
 * Class Connection
 * @package src\Services
 */
class Connection
{
    private static ?Connection $instance = null;
    /**
     * @var mysqli|false|null
     */
    private static $connection;
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
     * @return Connection
     * @throws DatabaseException
     */
    static public function getInstance(): Connection
    {
        if (self::$instance instanceof self) {
            return self::$instance;
        } else {
            self::$connection = mysqli_connect(
                MYSQL_HOST,
                MYSQL_LOGIN,
                MYSQL_PASS,
                MYSQL_DB,
                MYSQL_PORT
            );

            if (self::$connection) {
                mysqli_set_charset(self::$connection, 'utf8');

                self::$instance = new self;

                return self::$instance;
            } else {
                throw new DatabaseException('Невозможно уcтановить соединение с БД: ' . mysqli_connect_error());
            }
        }
    }


    private function __construct()
    {
    }

    public function insertOrUpdate(string $table, string $uniqueField, array $fields)
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

        $result = $this->query($query)->fetch_row();

        if (!is_null($result)) {
            $fields['id'] = (int) reset($result);
            $this->update($table, $fields);
            $this->insertId = $fields['id'];
        } else {
            $this->insert($table, $fields);
        }
    }

    /**
     * @param string $table
     *
     * @return int
     */
    public function getLastId(string $table): int
    {
        $query = "SELECT id from $table ORDER BY id DESC LIMIT 1";
        $result = $this->query($query)->fetch_row();

        return (int) reset($result);
    }

    /** @noinspection PhpUnused */
    private function __clone()
    {
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
    public function insert(string $table, array $data)
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

        if (!$this->query($query)) {
            $this->success = false;
        } else {
            $this->insertId = mysqli_insert_id(static::$connection);
        }
    }

    /**
     * @param string $table
     * @param array $params
     *
     * @return array
     */
    //TODO: вынести сложную логику в QueryBuilder
    public function get(string $table, array $params = []): array
    {
        $query =  "SELECT ";

        if (isset($params['select'])) {
            foreach ($params['select'] as &$field) {
                if (stripos($field, '.') === false) {
                    $field = $table . '.' . $field;
                }
            }
            $select = implode(', ', $params['select']);
            $query .=  " $select ";
        } else {
            $query .=  " * ";
        }

        unset($field);

        $query .= "FROM $table ";

        if (isset($params['join'])) {
            $query .= "LEFT JOIN {$params['join']['table']} ON $table.{$params['join']['id']} = 
                {$params['join']['table']}.id";
        }

        if (isset($params['filter'])) {
            $query .= ' WHERE ';

            $conditions = [];
            foreach ($params['filter'] as $field => $value) {
                if (stripos($field, '.')  === false) {
                    $field = $table . '.' . $field;
                }

                if (is_string($value)) {
                    $value = "'$value'";
                }

                $conditions[] = $field . ' = ' . $value;
            }

            $query .= implode(' AND ', $conditions);
        }

        if (isset($params['sort'])) {
            if (strpos($params['sort'], '.')  === false) {
                $params['sort'] = $table . '.' . $params['sort'];
            }

            $query .= " ORDER BY {$params['sort']} DESC";
        }

        $result = $this->query($query);
        $data = [];

        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $data[] = $row;
            }

            return $data;
        }

        return [];
    }

    /**
     * @param string $table
     * @param array $data
     *
     * @return bool|mysqli_result
     */
    public function update(string $table, array $data)
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

        return $this->query($query);
    }

    public function transactionBegin(): void
    {
        static::$connection->begin_transaction();
    }

    public function transactionCommit(): void
    {
        static::$connection->commit();
    }

    /**
     * @param $query
     *
     * @return bool|mysqli_result
     */
    private function query($query)
    {
        $this->success = true;
        $this->insertId = 0;

        $result = mysqli_query(static::$connection, $query);

        if ($result === false) {
            $this->success = false;
        }

        return $result;
    }
}