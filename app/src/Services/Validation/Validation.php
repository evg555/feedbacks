<?php

namespace src\Services\Validation;

use Exception;
use src\Exceptions\ValidationException;
use src\Services\Validation\Validators\EmailValidator;
use src\Services\Validation\Validators\FileValidator;
use src\Services\Validation\Validators\BooleanValidator;
use src\Services\Validation\Validators\NumberValidator;
use src\Services\Validation\Validators\RequiredValidator;
use src\Services\Validation\Validators\Validator;

/**
 * Class Validation
 * @package src\lib\Services\Validation
 */
abstract class Validation
{
    /**
     * @var array
     */
    protected static array $rules = [];

    /**
     * @var array
     */
    protected static array $validators = [
        'required' => RequiredValidator::class,
        'email' => EmailValidator::class,
        'file' => FileValidator::class,
        'number' => NumberValidator::class,
        'boolean' => BooleanValidator::class,
    ];
    /**
     * @var string
     */
    protected static string $messagePrefix = '';

    /**
     * @return array
     * @throws ValidationException
     */
    public static function validate(): array
    {
        $data = [];

        foreach (static::$rules as $field => $validators) {
            /* @var Validator $validator */
            foreach ($validators as $validatorName) {
                $validatorClass = static::$validators[$validatorName];
                $validator = new $validatorClass();

                if (!$validator instanceof Validator) {
                    throw new Exception('Invalid validator');
                }

                $validator->validate($field);

                if (!$validator->getIsValid()) {
                    $message = static::$messagePrefix . $validator->getError($field);
                    throw new ValidationException($message);
                }

                unset($validator);
            }

            $data[$field] = addslashes(trim($_POST[$field]));

            if (is_numeric($_POST[$field])) {
                $data[$field] = (int) $_POST[$field];
            }
        }

        return $data;
    }
}