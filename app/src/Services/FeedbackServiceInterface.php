<?php

namespace src\Services;

use src\DTO\FeedbackDTO;

interface FeedbackServiceInterface
{
    public function create(FeedbackDTO $dto);
    public function saveChangedText(int $id, string $text);
    public function approve(int $id, bool $accept);
    public function get(string $mode): array;
}