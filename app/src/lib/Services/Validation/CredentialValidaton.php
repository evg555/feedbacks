<?php

namespace src\lib\Services\Validation;

/**
 * Class CredentialValidaton
 * @package src\controllers\lib\Services\Validation
 */
class CredentialValidaton extends Validation
{
    protected static array $rules = [
        'login' => ['required'],
        'pass' => ['required'],
    ];

    protected static string $messagePrefix = 'Ошибка отправки формы: ';
}