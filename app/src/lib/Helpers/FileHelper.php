<?php

namespace src\lib\Helpers;

/**
 * Class FileHelper
 * @package src\lib\Helpers
 */
class FileHelper
{
    private static int $width = 320;
    private static int $height = 240;
    private static int $thumbWidth = 60;
    private static int $thumbHeight = 60;

    /**
     * @param $file
     * @param bool $thumb
     *
     * @return string
     */
    public static function resize($file, bool $thumb = false): string
    {
        switch ($file['type']){
            case 'image/jpeg':
                $source = imagecreatefromjpeg($file['tmp_name']);
                break;
            case 'image/png':
                $source = imagecreatefrompng($file['tmp_name']);
                break;
            case 'image/gif':
                $source = imagecreatefromgif($file['tmp_name']);
                break;
            default:
        }

        //Проверяем ширину и высоту, нужно ли обрезание
        $srcWidth = imagesx($source);
        $srcHeight = imagesy($source);

        $width = $thumb ? static::$thumbWidth : static::$width;
        $height = $thumb ? static::$thumbHeight : static::$height;

        if ($srcWidth > $width || $srcHeight > $height) {
            //Уменьшаем пропорционально ширине или высоте
            if ($srcWidth > $srcHeight){
                $ratio = $srcWidth/$width;
                $outWidth = $width;
                $outHeight = round($srcHeight/$ratio);
            } else {
                $ratio = $srcHeight/$height;
                $outWidth = round($srcWidth/$ratio);
                $outHeight = $height;
            }

            $dest = imagecreatetruecolor($outWidth, $outHeight);

            imagecopyresampled($dest, $source, 0, 0, 0, 0, $outWidth, $outHeight, $srcWidth, $srcHeight);
            imagejpeg($dest, 'public/files/' . $file['name']);
            imagedestroy($dest);
            imagedestroy($source);
        } else {
            imagejpeg($source,  'public/files/' . $file['name']);
            imagedestroy($source);
        }

        return $file['name'];
    }
}