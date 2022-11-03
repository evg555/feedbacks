<?php

namespace src\controllers;

/**
 * Class BaseControler
 * @package src\controllers
 */
abstract class BaseControler
{
    /*
     * Данные передаваемые в View
     */
    protected $data = [];

    /**
     * Экшен по умолчанию
     */
    public function index()
    {
        $this->render();
    }

    /**
     * Передаем переменные и рендерим страницу
     */
    abstract protected function render();
}