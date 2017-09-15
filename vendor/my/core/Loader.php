<?php

namespace vendor\my\core;


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

        if (is_file($file)){
            require_once $file;
        }
    }
}