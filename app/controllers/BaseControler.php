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
    abstract public function index();

    /**
     * Передаем переменные и рендерим страницу
     */
    abstract protected function render($data);
}