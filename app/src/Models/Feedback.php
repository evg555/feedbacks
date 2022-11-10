<?php

namespace src\Models;

/**
 * Class Feedback
 * @package src\Models
 */
class Feedback
{
    /**
     * @var int
     */
    private int $id;
    /**
     * @var string
     */
    private string $text;
    /**
     * @var string
     */
    private string $image;
    /**
     * @var string
     */
    private string $thumb;
    /**
     * @var bool
     */
    private bool $accept;
    /**
     * @var Author
     */
    private Author $author;

    /**
     * @return int
     */
    public function getId() : int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id) : void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getText() : string
    {
        return $this->text;
    }

    /**
     * @param string $text
     */
    public function setText(string $text) : void
    {
        $this->text = $text;
    }

    /**
     * @return string
     */
    public function getImage() : string
    {
        return $this->image;
    }

    /**
     * @param string $image
     */
    public function setImage(string $image) : void
    {
        $this->image = $image;
    }

    /**
     * @return string
     */
    public function getThumb() : string
    {
        return $this->thumb;
    }

    /**
     * @param string $thumb
     */
    public function setThumb(string $thumb) : void
    {
        $this->thumb = $thumb;
    }

    /**
     * @return bool
     */
    public function isAccept() : bool
    {
        return $this->accept;
    }

    /**
     * @param bool $accept
     */
    public function setAccept(bool $accept) : void
    {
        $this->accept = $accept;
    }

    /**
     * @return bool
     */
    public function getAccept() : bool
    {
        return $this->accept;
    }

    /**
     * @return Author
     */
    public function getAuthor() : Author
    {
        return $this->author;
    }

    /**
     * @param Author $author
     */
    public function setAuthor(Author $author) : void
    {
        $this->author = $author;
    }
}