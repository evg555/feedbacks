<?php

namespace vendor\my\core;

use src\controllers\MainController;
use Exception;

/**
 * Class Router
 * @package vendor\my\core
 */
class Router
{
    /**
     * Определяем маршрут и подгружаем нужный контроллер
     */
    public function start()
    {
        $url = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

        $routes = [
            '/' => ['controller' => 'Main', 'action' => 'index'],
            '/login' => ['controller' => 'Login', 'action' => 'index'],
            '/admin' => ['controller' => 'Admin', 'action' => 'index'],
            '/send' => ['controller' => 'Ajax', 'action' => 'index']
        ];

        try {
            if ($routes[$url]) {
                $controllerName = "\\src\\controllers\\" . $routes[$url]['controller'] . "Controller";
                $controller = new $controllerName();
                $controller->{$routes[$url]['action']}();
            } else {
                $controller = new MainController();
                $controller->index();
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}