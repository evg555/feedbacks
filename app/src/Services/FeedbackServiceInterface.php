<?php
/** @noinspection PhpUnused */

namespace src\Services;

use src\DTO\FeedbackDTO;

/**
 * Interface FeedbackServiceInterface
 * @package src\Services\FeedbackServiceInterface
 */
interface FeedbackServiceInterface
{
    public function create(FeedbackDTO $dto);
    public function saveChangedText(int $id, string $text);
    public function approve(int $id, bool $accept);
    public function get(string $mode): array;
}