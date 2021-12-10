<?php

namespace Html\Model;

use DateTime;
use Exception;

class Posts extends BaseEntity
{
    protected string $db_table = 'posts';
    protected string $prefix = 'PO';

    private string $title;
    private int $author_id;
    private string $content;
    private DateTime $publish_date;

    /**
     * @param $id
     * @throws Exception
     */
    public function __construct($id=null)
    {
        parent::__construct($id);
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return Posts
     */
    public function setTitle(string $title): Posts
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return int
     */
    public function getAuthorId(): int
    {
        return $this->author_id;
    }

    /**
     * @param string $author_id
     * @return Posts
     */
    public function setAuthorId(string $author_id): Posts
    {
        $this->author_id = $author_id;
        return $this;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @param string $content
     * @return Posts
     */
    public function setContent(string $content): Posts
    {
        $this->content = $content;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getPublishDate(): DateTime
    {
        return $this->publish_date;
    }

    /**
     * @param mixed $publish_date
     * @return Posts
     */
    public function setPublishDate($publish_date): Posts
    {
        $this->publish_date = $publish_date;
        return $this;
    }


}