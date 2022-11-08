<?php

namespace src\lib\Services\Validation\Validators;

/**
 * Class Validator
 * @package src\lib\Validators
 */
abstract class Validator
{
    protected static Validator $instance;
    /**
     * @var bool
     */
    protected bool $isValid = true;
    protected array $errors = [];


    abstract public function validate(string $field): void;

    /**
     * @return string
     */
    public function getError(string $field): string
    {
        if (array_key_exists($field, $this->errors)) {
            return $this->errors[$field];
        }

        return 'Ошибка валидации';
    }

    /**
     * @return bool
     */
    public function getIsValid(): bool
    {
        return $this->isValid;
    }
}