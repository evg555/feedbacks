<?php

namespace vendor\My\Core;

use vendor\My\Core\Container\Container;

/**
 * Class Application
 * @package vendor\My\Core
 */
class Application
{
    private static ?Application $instance = null;

    private Container $container;

    /**
     * @return Container
     */
    public function getContainer() : Container
    {
        return $this->container;
    }

    private Router $router;

    /**
     * @return static
     */
    public static function getInstance(): self
    {
        if (!self::$instance instanceof Application) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    private function __construct()
    {
    }

    private function clone()
    {
    }

    public function run()
    {
        $this->container = new Container();
        $this->router = new Router();

        $this->router->start();
    }
}