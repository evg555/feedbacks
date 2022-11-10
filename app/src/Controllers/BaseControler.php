<?php

namespace src\Controllers;

/**
 * Class BaseControler
 * @package src\Controllers
 */
class BaseControler
{
    protected array $data = [];

    public function index()
    {
        $this->render();
    }

    protected function render()
    {
    }
}