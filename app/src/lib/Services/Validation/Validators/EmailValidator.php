<?php

namespace src\lib\Services\Validation\Validators;

/**
 * Class EmailValidator
 * @package src\lib\Validators
 */
class EmailValidator extends Validator
{
    protected array $errors = [
        'email' => 'Неправильный e-mail',
    ];

    public function validate(string $field): void
    {
        $this->isValid = filter_var($_POST[$field], FILTER_VALIDATE_EMAIL);
    }
}