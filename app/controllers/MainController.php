<?php
namespace app\controllers;

class MainController extends BaseControler
{
    public function index(){


        $this->render($this->_data);
    }

    protected function render($data){
        include $_SERVER['DOCUMENT_ROOT'] . "/templates/feedbacks.php";
    }
}