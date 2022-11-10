<?php

namespace vendor\My\Core;

use src\Controllers\AdminController;
use src\Controllers\AjaxController;
use src\Controllers\BaseControler;
use src\Controllers\LoginController;
use src\Controllers\MainController;
use src\Exceptions\NotFoundException;
use Throwable;

/**
 * Class Router
 * @package vendor\My\Core
 */
class Router
{
    public function start()
    {
        $url = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

        $routes = [
            '/' => ['controller' => MainController::class],
            '/login' => ['controller' => LoginController::class],
            '/admin' => ['controller' => AdminController::class],
            '/send' => ['controller' => AjaxController::class]
        ];

        try {
            if (empty($routes[$url])) {
                throw new NotFoundException('Ошибка: Контроллер не найден');
            }

            $container = Application::getInstance()->getContainer();
            $controllerClass = $routes[$url]['controller'];

            if (!$container->has($controllerClass)) {
                throw new NotFoundException("Ошибка: Класс $controllerClass не cуществует");
            }

            /* @var BaseControler $controller */
            $controller = $container->get($controllerClass);
            $controller->index();
        } catch (Throwable $e) {
            echo $e->getMessage();
        }
    }
}