<?php

namespace Html\Model;

use PDO;

abstract class BaseManager
{
    protected PDO $db;

    protected function __construct()
    {
        $this->db = new PDO(DSN, DB_USER, DB_PASS);
    }
}