<?php

namespace src\DTO;

/**
 * Class FeedbackDTO
 * @package src\DTO
 */
class FeedbackDTO
{
    /**
     * @var string
     */
    public string $name;
    /**
     * @var string
     */
    public string $email;
    /**
     * @var string
     */
    public string $text;

    /**
     * @param array $data
     *
     * @return $this
     */
    public function load(array $data): FeedbackDTO
    {
        $this->name = $data['name'] ?: '';
        $this->email = $data['email'] ?: '';
        $this->text = $data['text'] ?: '';

        return $this;
    }

    /**
     * @param array $data
     *
     * @return self
     */
    public static function fromRequest(array $data): self
    {
        return (new self())->load($data);
    }
}