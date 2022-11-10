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

    abstract protected function render();
}