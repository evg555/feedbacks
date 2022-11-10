<?php
use vendor\My\Core\Loader;
use vendor\My\Core\Application;

require "./vendor/My/Core/Loader.php";
require "./config/app.php";

$loader = new Loader();
spl_autoload_register([$loader, 'autoLoad']);

Application::getInstance()->run();