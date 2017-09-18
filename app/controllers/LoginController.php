<?php
namespace app\controllers;

class LoginController extends BaseControler
{
    protected function render($data){
        include TEMPLATE_DIR . "/login.php";
    }
}