<?php

namespace vendor\My\Core;

/**
 * Class Loader
 * @package vendor\My\Core
 */
class Loader
{
    /**
     * Находим и загружаем классы
     * @param string $class
     */
    public function autoLoad($class){
        $arr = explode("\\",$class);
        $className = array_pop($arr);
        $prefix = implode("/",$arr);

        $file = $prefix."/".$className.".php";

        $isFile = is_file($file);

        if (is_file($file)){
            require_once $file;
        }
    }
}