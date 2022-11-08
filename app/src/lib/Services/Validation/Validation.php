<?php

namespace src\lib\Services\Validation;

use Exception;
use src\lib\Services\Validation\Validators\EmailValidator;
use src\lib\Services\Validation\Validators\FileValidator;
use src\lib\Services\Validation\Validators\BooleanValidator;
use src\lib\Services\Validation\Validators\NumberValidator;
use src\lib\Services\Validation\Validators\RequiredValidator;
use src\lib\Services\Validation\Validators\Validator;

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
     * @throws Exception
     */
    public static function validate(): array
    {
        $result = [
            'status' => 'error',
            'message' => ''
        ];

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
                    $result['message'] = static::$messagePrefix . $validator->getError($field);
                    return $result;
                }

                unset($validator);
            }

            $data[$field] = addslashes(trim($_POST[$field]));

            if (is_numeric($_POST[$field])) {
                $data[$field] = (int) $_POST[$field];
            }
        }

        return [
            'status' => 'success',
            'data' => $data
        ];
    }
}