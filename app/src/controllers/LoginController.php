<?php
namespace src\controllers;

/**
 * Class LoginController
 * @package src\controllers
 */
class LoginController extends BaseControler
{
    public function index()
    {
        session_start();
        if ($_SESSION['authorized']){
            header("Location: /admin");
        }

        parent::index();
    }

    /**
     * Передаем переменные и рендерим страницу
     */
    protected function render(){
        include TEMPLATE_DIR . "/login.php";
    }
}