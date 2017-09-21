<?php

namespace app\controllers;
use app\models\Database;


class AdminController extends BaseControler
{
    public function index()
    {
        //Проверяем, что пользователь залогинен
        session_start();
        if (empty($_SESSION['authorized'])){
            header("Location /login");
        }

        //Выход пользователя из панели
        if (isset($_GET['logout'])){
            unset($_SESSION['user']);
            unset($_SESSION['authorized']);
            session_destroy();

            header('Location: /login');
        }

        //Загружаем отзывы в админку
        try {
            $db = Database::getInstance();
            $this->_data['feedbacks'] = $db->getFeedbacksForPanel();
            $this->_data['user'] = $_SESSION['user'];

            parent::index();
        } catch (\Exception $e){
            echo $e->getMessage();
        }
    }

    protected function render($data){
        include TEMPLATE_DIR . "/admin.php";
    }
}