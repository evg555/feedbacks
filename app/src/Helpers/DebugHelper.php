<?php

namespace src\Helpers;

/**
 * Class DebugHelper
 * @package src\Helpers
 */
class DebugHelper
{
    /**
     * @var int
     */
    private static int $startTime = 0;
    /**
     * @var int
     */
    private static int $startMemory = 0;

    public static function startTime()
    {
        self::$startTime = microtime(true);
    }

    /**
     * @return string
     */
    public static function calculateTime(): string
    {
        $time = microtime(true) - self::$startTime;

        $i = 0;
        while (floor($time / 60) > 0) {
            $i++;
            $time /= 60;
        }

        $name = ['сек', 'мин', 'час'];

        return round($time, 2) . ' ' . $name[$i] . '<br>';
    }

    public static function startMemory()
    {
        self::$startMemory = memory_get_usage();
    }

    /**
     * @return string
     */
    public static function calculateMemory(): string
    {
        $memory = memory_get_usage() - self::$startMemory;

        $i = 0;
        while (floor($memory / 1024) > 0) {
            $i++;
            $memory /= 1024;
        }

        $name = ['байт', 'КБ', 'МБ'];

        return round($memory, 2) . ' ' . $name[$i] . '<br>';
    }

    public static function print()
    {
        echo self::calculateTime();
        echo self::calculateMemory();
    }
}