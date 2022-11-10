<?php

namespace src\Services\Validation;

/**
 * Class FeedbackValidation
 * @package src\lib\Services\Validation
 */
class AcceptValidation extends Validation
{
    protected static array $rules = [
        'id' => ['required', 'number'],
        'accept' => ['required', 'boolean'],
    ];

    protected static string $messagePrefix = 'Ошибка одобрения отзыва: ';
}