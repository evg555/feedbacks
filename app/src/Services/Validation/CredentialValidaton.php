<?php /** @noinspection PhpUnused */

namespace src\Services\Validation;

/**
 * Class CredentialValidaton
 * @package src\Controllers\lib\Services\Validation
 */
class CredentialValidaton extends Validation
{
    protected static array $rules = [
        'login' => ['required'],
        'pass' => ['required'],
    ];

    protected static string $messagePrefix = 'Ошибка отправки формы: ';
}