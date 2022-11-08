<?php

namespace src\lib\Services\Validation\Validators;

/**
 * Class NumberValidator
 * @package src\lib\Validators
 */
class NumberValidator extends Validator
{
    protected array $errors = [
        'id' => 'Некорректный формат идентификатора',
    ];

    public function validate(string $field): void
    {
        $this->isValid = is_numeric($_POST[$field]);
    }
}