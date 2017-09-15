<?php
use vendor\my\core\Loader;
use vendor\my\core\Route;

require "vendor/my/core/Loader.php";

$loader = new Loader();
spl_autoload_register([$loader,"autoLoad"]);

$router = new Route();
$router->start();