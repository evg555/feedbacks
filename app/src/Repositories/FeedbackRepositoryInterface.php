<?php

namespace src\Repositories;

use src\Models\Feedback;

/**
 * Interface FeedbackRepositoryInterface
 * @package src\Repositories
 */
interface FeedbackRepositoryInterface
{
    public function getAll(string $type): array;
    public function getAllforPanel(): array;

    public function add(Feedback $feedback): bool;
    public function changeText(Feedback $feedback): bool;
    public function changeStatus(Feedback $feedback): bool;
}