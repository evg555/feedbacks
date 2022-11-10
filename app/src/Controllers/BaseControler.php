<?php

namespace src\Controllers;

/**
 * Class BaseControler
 * @package src\Controllers
 */
abstract class BaseControler
{
    /*
     * Данные передаваемые в View
     */
    protected array $data = [];

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