<?php /** @noinspection PhpUnused */

/** @noinspection PhpUnused */

namespace src\Services\Validation;

/**
 * Class ChangedTextValidation
 * @package src\lib\Services\Validation
 */
class ChangedTextValidation extends Validation
{
    protected static array $rules = [
        'text' => ['required'],
        'id' => ['required', 'number'],
    ];

    protected static string $messagePrefix = 'Ошибка отправки формы: ';
}