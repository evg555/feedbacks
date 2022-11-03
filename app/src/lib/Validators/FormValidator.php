<?php

namespace src\lib\Validators;

use Exception;
use src\lib\Helpers\FileHelper;

/**
 * Class FormValidator
 * @package src\lib\Validators
 */
class FormValidator
{
    const ERRORS = [
        'name' => 'не задано имя',
        'email' => 'не задан e-mail',
        'text' => 'не задан текст отзыва'
    ];

    public static function validate(): array
    {
        $result = [
            'status' => 'error',
            'message' => ''
        ];

        $data = [];

        foreach (static::ERRORS as $field => $textError) {
            if (!array_key_exists($field, $_POST) || empty($_POST[$field])) {
                $result['message'] = 'Ошибка отправки формы: ' . $textError;
                return $result;
            }

            $data[$field] = addslashes(trim($_POST[$field]));
        }

        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $result['message'] = 'Ошибка отправки формы: неправильный e-mail';
            return $result;
        }

        if (is_uploaded_file($_FILES['file']['tmp_name'])) {
            if ($_FILES['file']['error']){
                $result['message'] = "Ошибка загрузки файла";
                return $result;
            }

            $formats = [
                "image/jpeg",
                "image/png",
                "image/gif"];

            if (!in_array($_FILES['file']['type'], $formats)) {
                $result['message'] = "Ошибка отправки формы: некорректный формат изображения";
                return $result;
            }
        }

        return [
            'status' => 'success',
            'data' => $data
        ];
    }


}