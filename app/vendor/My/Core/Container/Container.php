<?php

namespace vendor\My\Core\Container;

use ReflectionClass;
use ReflectionException;
use src\Exceptions\NotFoundException;

/**
 * Class Container
 * @package vendor\My\Core\Container
 */
class Container implements ContainerInterface
{
    /**
     * @throws ReflectionException
     * @throws NotFoundException
     */
    public function get(string $id)
    {
        return $this->prepareObject($id);
    }

    /**
     * @param string $id
     *
     * @return bool
     */
    public function has(string $id): bool
    {
        return class_exists($id);
    }

    /**
     * @param string $class
     *
     * @throws ReflectionException
     * @throws NotFoundException
     */
    private function prepareObject(string $class)
    {
        $classReflection = new ReflectionClass($class);

        if ($classReflection->isInterface()) {
            if (!array_key_exists($class, BINDINGS)) {
                throw new NotFoundException("Ошибка: Для интерфейса $class не сконфигурирован класс");
            }

            $class = BINDINGS[$class];

            if (!$this->has($class)) {
                throw new NotFoundException("Ошибка: Класс $class не cуществует");
            }

            $classReflection = new ReflectionClass($class);
        }

        $constructReflector = $classReflection->getConstructor();

        if (empty($constructReflector)) {
            return new $class;
        }

        $constructParams = $constructReflector->getParameters();

        if (empty($constructParams)) {
            return new $class;
        }

        $params = [];
        foreach ($constructParams as $param) {
            $paramtType = $param->getType()->getName();
            $params[] = $this->get($paramtType);
        }

        return new $class(...$params);
    }
}