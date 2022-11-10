<?php
namespace src\Controllers;

/**
 * Class LoginController
 * @package src\Controllers
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