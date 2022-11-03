<?php

namespace src\controllers;
use Exception;
use src\models\Database ;

/**
 * Class AdminController
 * @package src\controllers
 */
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
            $this->data['feedbacks'] = $db->getFeedbacksForPanel();
            $this->data['user'] = $_SESSION['user'];

            parent::index();
        } catch (Exception $e){
            echo $e->getMessage();
        }
    }

    /**
     * Передаем переменные и рендерим страницу
     */
    protected function render()
    {
        include TEMPLATE_DIR . "/admin.php";
    }
}