<?php

namespace src\lib\Services\Validation\Validators;

/**
 * Class FileValidator
 * @package src\lib\Validators
 */
class FileValidator extends Validator
{
    const ALLOWED_FORMATS = [
        'image/jpeg',
        'image/png',
        'image/gif',
    ];

    protected array $errors = [
        'file' => 'Ошибка загрузки файла'
    ];

    public function validate(string $field): void
    {
        if (!is_uploaded_file($_FILES['file']['tmp_name'])) {
            return;
        }

        if ($_FILES['file']['error']) {
            $this->isValid = false;
            return;
        }

        if (!in_array($_FILES['file']['type'], static::ALLOWED_FORMATS)) {
            $this->isValid = false;
            $this->errors['file'] = "Некорректный формат изображения";
        }
    }
}