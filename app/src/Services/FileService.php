<?php

namespace src\Services;

use src\Helpers\FileHelper;

/**
 * Class FileService
 * @package src\Services
 */
class FileService
{
    /**
     * @return array
     */
    public static function resizeImage(): array
    {
        if (!is_uploaded_file($_FILES['file']['tmp_name'])) {
            return [];
        }

        $image = FileHelper::resize($_FILES['file']);

        $_FILES['file']['name'] = str_replace(".", "_thumb.", $_FILES['file']['name']);
        $thumb = FileHelper::resize($_FILES['file'], true);

        return compact('image', 'thumb');
    }
}