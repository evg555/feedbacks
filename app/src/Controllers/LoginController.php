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

    protected function render()
    {
        /** @noinspection PhpIncludeInspection */
        include TEMPLATE_DIR . "login.php";
    }
}