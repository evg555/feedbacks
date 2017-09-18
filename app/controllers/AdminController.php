<?php

namespace app\controllers;


class AdminController
{
    protected function render($data){
        include TEMPLATE_DIR . "/admin.php";
    }
}