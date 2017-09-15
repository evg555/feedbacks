<?php
namespace vendor\my\core;

class Route
{
    /**
     * Определяем марщрут и подгружаем нужный контроллер
     */
    public function start(){
        $url = urldecode(parse_url($_SERVER['REQUEST_URI'],PHP_URL_PATH));

        $routes = [
            '/' => ['controller' => 'Main','action' => 'index'],
            '/login' => ['controller' => 'Login','action' => 'index'],
            '/admin' => ['controller' => 'Admin','action' => 'index']
        ];

        if ($routes[$url]){
            $controllerName = "\\app\\controllers\\".$routes[$url]['controller']."Controller";
            $controller = new $controllerName();
            $controller->$routes[$url]['action']();
        } else {
            $controller = new \app\controllers\MainController();
            $controller->index();
        }

    }
}