<?php
use vendor\My\Core\Loader;
use vendor\My\Core\Router;

require "./vendor/My/Core/Router.php";
require "./vendor/My/Core/Loader.php";
require "./config/app.php";

$loader = new Loader();
spl_autoload_register([$loader, 'autoLoad']);

$router = new Router();
$router->start();