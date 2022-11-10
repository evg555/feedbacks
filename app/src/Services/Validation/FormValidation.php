<?php

namespace src\Services\Validation;

/**
 * Class FormValidation
 * @package src\lib\Validators
 */
class FormValidation extends Validation
{
    protected static array $rules = [
        'name' => ['required'],
        'email' => ['required', 'email'],
        'text' => ['required'],
        'file' => ['file'],
    ];

    protected static string $messagePrefix = 'Ошибка отправки формы: ';
}