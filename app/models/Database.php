<?php

namespace app\models;

class Database
{
    protected static $_instance;
    protected static $_link;
    protected $_tableFeadbacks = 'feedbacks';
    protected $_tableAuthors= 'authors';
    protected $_tableUsers = 'users';

    /*
     * Получает или создает экземпляр объекта подключения к БД
     */
    static public function getInstance(){
        if (self::$_instance instanceof self){
            return self::$_instance;
        } else {
            if (@self::$_link = mysqli_connect(MYSQL_HOST,MYSQL_LOGIN,MYSQL_PASS,MYSQL_DB)) {
                mysqli_set_charset(self::$_link, "utf8");

                self::$_instance = new self;
                return self::$_instance;
            } else {
                throw new \Exception("Невохможно уcnановить соединение с БД: ".mysqli_connect_error());
            }
        }
    }

    private function __construct(){}

    private function __clone(){}

    /*
     * Получаем все одобренные отзывы
     * @param string $type
     * @return array
     */
    public function getAllFeedbacks($type = 'byDate'){
        //Типы сортировки
        $types = [
            'byDate' => 'f.created',
            'byAuthor' => 'a.name',
            'byEmail' => 'a.email'
        ];

        $query = "SELECT a.email,a.name,f.text,f.image,DATE_FORMAT(f.created,'%d.%m.%Y') as 'created',f.changed FROM ".$this->_tableFeadbacks. " f
                    LEFT JOIN ".$this->_tableAuthors." a USING (author_id)
                    WHERE f.accept = 1";

        if (array_key_exists($type,$types)) {
            $query .= " ORDER BY ".$types[$type];
            if ($type == 'byDate'){
                $query .= " DESC";
            }
        }

        if ($result = $this->query($query)){
            while ($row = mysqli_fetch_assoc($result)){
                $feeds[] = $row;
            }
            return $feeds;
        } else {
            return false;
        }
    }

    /*
     * Добавляем отзыв в БД
     * @param string $name,$email,$text,$file
     * return boolean
     */
    public function addFeedback($name,$email,$text,$image = null,$thumb = null){
        //Проверяем наличие e-mail
        $query = "SELECT * FROM ".$this->_tableAuthors."
                    WHERE email = '$email'";

        if ($result = $this->query($query)){
            if (!mysqli_fetch_row($result)){
                //Добавляем нового автора
                $query = "INSERT INTO ".$this->_tableAuthors."
                    SET email='$email',name='$name'";
                if (!$this->query($query)) return false;
            }

            $query = "UPDATE ".$this->_tableAuthors."
                    SET name='$name'
                    WHERE email='$email'";

            if (!$this->query($query)) return false;

            //Получаем id автора
            $query = "SELECT author_id FROM ".$this->_tableAuthors."
                WHERE email='$email'";

            if ($result = $this->query($query)){
                $author_id = mysqli_fetch_row($result)[0];

                //Добавляем отзыв
                $query = "INSERT INTO ".$this->_tableFeadbacks."
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
    public function authorize($login, $pass){

        $query = "SELECT login, password FROM ".$this->_tableUsers."
                    WHERE login = '$login'";

        if ($result = $this->query($query)){
            //Проверяем пароль
            if (mysqli_fetch_assoc($result)['password'] == md5($pass)){
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
    public function getFeedbacksForPanel(){
        $query = "SELECT f.id,a.email,a.name,f.text,f.thumb,DATE_FORMAT(f.created,'%d.%m.%Y') as 'created',f.accept FROM ".$this->_tableFeadbacks. " f
                    LEFT JOIN ".$this->_tableAuthors." a USING (author_id) ORDER BY f.created DESC";

        if ($result = $this->query($query)){
            while ($row = mysqli_fetch_assoc($result)){
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
    public function changeAccept($id, $accept){
        $query = "UPDATE ".$this->_tableFeadbacks. " 
                    SET accept=$accept WHERE id=$id";

        return $this->query($query);
    }

    /*
     * Сохраняет новый текст отзыва в БД
     * @param ште $id
     * @param string $text
     * return mixed|false
     */
    public function changeFeedback($id, $text){
        $query = "UPDATE ".$this->_tableFeadbacks. " 
                    SET text='$text',changed=1 WHERE id=$id";

        return $this->query($query);
    }

    /*
     * Выполняет запрос к БД
     * @param string $query
     * return mixed|false
     */
    private function query($query){
        $result = mysqli_query(self::$_link, $query);

        return $result;
    }
}