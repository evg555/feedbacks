<?php

namespace app\models;

class Database
{
    protected static $_instance;
    protected static $_link;
    protected $_tableFeadbacks = 'feedbacks';
    protected $_tableAuthors= 'authors';
    protected $_tableUsers = 'users';

    static public function getInstance(){
        if (self::$_instance instanceof self){
            return self::$_instance;
        } else {
            if (@self::$_link = mysqli_connect(MYSQL_HOST,MYSQL_LOGIN,MYSQL_PASS,MYSQL_DB)) {
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
     * @return array
     */
    public function getAllFeedbacks(){
        $query = "SELECT a.email,a.name,f.text,DATE_FORMAT(f.created,'%d.%m.%Y') as 'created',f.changed FROM ".$this->_tableFeadbacks. " f
                    LEFT JOIN ".$this->_tableAuthors." a USING (author_id)
                    WHERE f.accept = 1 
                    ORDER BY created DESC ";

        if ($result = mysqli_query(self::$_link, $query)){
            while ($row = mysqli_fetch_assoc($result)){
                $feeds[] = $row;
            }
            return $feeds;
        } else {
            return false;
        }
    }
}