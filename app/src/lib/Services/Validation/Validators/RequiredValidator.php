<?php

namespace src\lib\Services\Validation\Validators;

/**
 * Class RequiredValidator
 * @package src\lib\Validators
 */
class RequiredValidator extends Validator
{
    protected array $errors = [
        'name' => 'Не задано имя',
        'email' => 'Не задан e-mail',
        'text' => 'Не задан текст отзыва',
        'login' => 'Не введен логин',
        'pass' => 'Не введен пароль',
        'id' => 'Отсутствует id отзыва',
        'accept' => 'Нет галочки подтверждения',
    ];

    public function validate(string $field): void
    {
        $this->isValid = strlen($_POST[$field]) > 0;
    }
}