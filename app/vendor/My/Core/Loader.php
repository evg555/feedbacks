<?php

namespace vendor\My\Core;

/**
 * Class Loader
 * @package vendor\My\Core
 */
class Loader
{
    /**
     * @param string $class
     */
    public static function autoLoad(string $class)
    {
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