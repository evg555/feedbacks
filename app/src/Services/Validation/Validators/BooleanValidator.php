<?php /** @noinspection PhpUnused */

namespace src\Services\Validation\Validators;

/**
 * Class BooleanValidator
 * @package src\lib\Validators
 */
class BooleanValidator extends Validator
{
    protected array $errors = [
        'accept' => 'Некорректный формат галочки подтверждения',
    ];

    public function validate(string $field): void
    {
        $this->isValid = in_array($_POST[$field], [0, 1]);
    }
}