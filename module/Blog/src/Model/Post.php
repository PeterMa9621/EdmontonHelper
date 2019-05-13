<?php


namespace Blog\Model;


class Post
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $text;

    /**
     * @var string
     */
    private $title;

    /**
     * Post constructor.
     * @param string $title
     * @param string $text
     * @param int $id
     */
    public function __construct($title, $text, $id)
    {
        $this->title = $title;
        $this->id = $id;
        $this->text = $text;
    }

    /**
     * @return int|null
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }
}