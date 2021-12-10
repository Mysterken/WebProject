<?php

namespace Html\Model;

use Exception;

class PostComment extends BaseEntity
{
    const db_table = 'post_comment';
    const prefix = 'POC';

    private $author_id;
    private $comment;
    private $publish_date;

    /**
     * @param $id
     * @throws Exception
     */
    public function __construct($id=null)
    {
        parent::__construct($id);
    }

    /**
     * @return mixed
     */
    public function getAuthorId()
    {
        return $this->author_id;
    }

    /**
     * @param mixed $author_id
     * @return PostComment
     */
    public function setAuthorId($author_id): PostComment
    {
        $this->author_id = $author_id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * @param mixed $comment
     * @return PostComment
     */
    public function setComment($comment): PostComment
    {
        $this->comment = $comment;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPublishDate()
    {
        return $this->publish_date;
    }

    /**
     * @param mixed $publish_date
     * @return PostComment
     */
    public function setPublishDate($publish_date): PostComment
    {
        $this->publish_date = $publish_date;
        return $this;
    }


}