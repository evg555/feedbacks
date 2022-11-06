<?php

namespace src\models;

use Exception;

//TODO вынести вызовы в репозитории

/**
 * Class Database
 * @package models
 */
class Database
{
    protected static $instance;
    protected static $link;
    protected $tableFeedbacks = 'feedbacks';
    protected $tableAuthors = 'authors';
    protected $tableUsers = 'users';
    /*
     * Получает или создает экземпляр объекта подключения к БД
     */
    /**
     * @return Database
     * @throws Exception
     */
    static public function getInstance()
    {
        if (self::$instance instanceof self) {
            return self::$instance;
        } else {
            @self::$link = mysqli_connect(
                MYSQL_HOST,
                MYSQL_LOGIN,
                MYSQL_PASS,
                MYSQL_DB,
                MYSQL_PORT
            );

            if (self::$link) {
                mysqli_set_charset(self::$link, "utf8");

                self::$instance = new self;

                return self::$instance;
            } else {
                throw new Exception("Невозможно уcтановить соединение с БД: " . mysqli_connect_error());
            }
        }
    }

    private function __construct()
    {
    }

    private function __clone()
    {
    }

    /*
     * Получаем все одобренные отзывы
     * @param string $type
     * @return array
     */
    public function getAllFeedbacks(string $type = 'byDate'): array
    {
        //Типы сортировки
        $types = ['byDate' => 'f.created', 'byAuthor' => 'a.name', 'byEmail' => 'a.email'];

        $query = "SELECT a.email, a.name, f.text, f.image, DATE_FORMAT(f.created,'%d.%m.%Y') as 'created', f.changed FROM " . $this->tableFeedbacks . " f
                    LEFT JOIN " . $this->tableAuthors . " a USING (id)
                    WHERE f.accept = 1";

        if (array_key_exists($type, $types)) {
            $query .= " ORDER BY " . $types[$type];
            if ($type == 'byDate') {
                $query .= " DESC";
            }
        }

        $result = $this->query($query);
        $feeds = [];

        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $feeds[] = $row;
            }

            return $feeds;
        } else {
            return [];
        }
    }

    /*
     * Добавляем отзыв в БД
     * @param string $name,$email,$text,$file
     * return boolean
     */
    public function addFeedback($name, $email, $text, $image = null, $thumb = null)
    {
        //Проверяем наличие e-mail
        $query = "SELECT * FROM " . $this->tableAuthors . "
                    WHERE email = '$email'";

        $result = $this->query($query);

        if ($result) {
            if (!mysqli_fetch_row($result)) {
                //Добавляем нового автора
                $query = "INSERT INTO " . $this->tableAuthors . "
                    SET email='$email',name='$name'";
                if (!$this->query($query)) {
                    return false;
                }
            }

            $query = "UPDATE " . $this->tableAuthors . "
                    SET name='$name'
                    WHERE email='$email'";

            if (!$this->query($query)) {
                return false;
            }

            //Получаем id автора
            $query = "SELECT id FROM " . $this->tableAuthors . "
                WHERE email='$email'";

            $result = $this->query($query);
            
            if ($result) {
                $author_id = mysqli_fetch_row($result)[0];

                //Добавляем отзыв
                $query = "INSERT INTO " . $this->tableFeedbacks . "
                    SET author_id=$author_id, text='$text',created=now(),image='$image',thumb='$thumb'";

                return $this->query($query);
            }
        }

        return false;
    }

    /*
     * Авторизация пользоватля
     * @param string $login, $pass
     * return boolean
     */
    public function authorize($login, $pass)
    {
        $query = "SELECT login, password FROM " . $this->tableUsers . "
                    WHERE login = '$login'";

        $result = $this->query($query);

        if ($result) {
            //Проверяем пароль
            if (mysqli_fetch_assoc($result)['password'] == md5($pass)) {
                session_start();
                $_SESSION['user'] = $login;
                $_SESSION['authorized'] = true;

                return true;
            }
        }

        return false;
    }

    /*
     * Получаем все отзывы в админку
     * @return array
     */
    public function getFeedbacksForPanel()
    {
        $query = "SELECT f.id,a.email,a.name,f.text,f.thumb,DATE_FORMAT(f.created,'%d.%m.%Y') as 'created',f.accept FROM " . $this->tableFeedbacks . " f
                    LEFT JOIN " . $this->tableAuthors . " a USING (id) ORDER BY f.created DESC";

        $result = $this->query($query);

        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $feeds[] = $row;
            }

            return $feeds;
        } else {
            return false;
        }
    }

    /*
     * Меняет статус отзыва
     * @param int $id, $accept
     * return mixed|false
     */
    public function changeAccept($id, $accept)
    {
        $query = "UPDATE " . $this->tableFeedbacks . " 
                    SET accept=$accept WHERE id=$id";

        return $this->query($query);
    }

    /*
     * Сохраняет новый текст отзыва в БД
     * @param ште $id
     * @param string $text
     * return mixed|false
     */
    public function changeFeedback($id, $text)
    {
        $query = "UPDATE " . $this->tableFeedbacks . " 
                    SET text='$text',changed=now() WHERE id=$id";

        return $this->query($query);
    }

    /*
     * Выполняет запрос к БД
     * @param string $query
     * return mixed|false
     */
    private function query($query)
    {
        $result = mysqli_query(self::$link, $query);

        return $result;
    }
}