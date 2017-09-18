<?php

namespace app\controllers;


abstract class BaseControler
{
    /*
     * Данные передаваемые в View
     */
    protected $_data = '';

    /**
     * Экшен по умолчанию
     */
    public function index(){
        $this->render($this->_data);
    }

    /**
     * Передаем переменные и рендерим страницу
     */
    abstract protected function render($data);
}