<?php

namespace Html\Model;

use Exception;
use PDO;

class PostManager extends BaseManager
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @throws Exception
     */
    public function getPosts(int $number = 5): array
    {
        $query = $this->db->prepare("SELECT * FROM `" . Posts::db_table . "` LIMIT " . $number);

        if (!$a = $query->execute()) {
            throw new Exception("Failed to query the database " . DB_NAME);
        }

        if (!$res = $query->fetchAll(PDO::FETCH_ASSOC)) {
            throw new Exception("No posts found in table " . Posts::db_table);
        }

        foreach ($res as &$post) {
            $post = new Posts($post[Posts::prefix.'_ID']);
        }

        return $res;
    }

    /**
     * @throws Exception
     */
    public function getPostById(int $id)
    {
        return new Posts($id);
    }

}