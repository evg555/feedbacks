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
    private array $objects;

    /**
     * @throws ReflectionException
     * @throws NotFoundException
     */
    public function get(string $id)
    {
        return $this->objects[$id] ?? $this->prepareObject($id);
    }

    /**
     * @param string $id
     *
     * @return bool
     */
    public function has(string $id): bool
    {
        return isset($this->objects[$id]) || class_exists($id);
    }

    /**
     * @param string $class
     *
     * @return mixed
     * @throws NotFoundException
     * @throws ReflectionException
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
            $this->set($class);
            return $this->objects[$class];
        }

        $constructParams = $constructReflector->getParameters();

        if (empty($constructParams)) {
            $this->set($class);
            return $this->objects[$class];
        }

        $params = [];
        foreach ($constructParams as $param) {
            $paramType = $param->getType()->getName();
            $params[] = $this->get($paramType);
        }

        $this->set($class, $params);

        return $this->objects[$class];
    }

    private function set(string $class, array $params = []): void
    {
        $object = !empty($params) ? new $class(...$params): new $class;
        $this->objects[$class] = $object;
    }
}