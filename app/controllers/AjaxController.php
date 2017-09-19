<?php

namespace app\controllers;


use app\models\Database;

class AjaxController
{
    /*
     * Проверяет существование метода в get-запросе и вызывает его
     */
    public function index(){
        $action = isset($_GET['action']) ? $_GET['action'] : false;
        if (method_exists($this, $action)){
            $this->$action();
        } else {
            echo "Параметра $action не существует!";
        }
    }

}