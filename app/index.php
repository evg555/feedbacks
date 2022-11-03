<?php
use vendor\my\core\Loader;
use vendor\my\core\Router;

require "./vendor/my/core/Router.php";
require "./vendor/my/core/Loader.php";
require "./src/config/app.php";

$loader = new Loader();
spl_autoload_register([$loader,"autoLoad"]);

$router = new Router();
$router->start();