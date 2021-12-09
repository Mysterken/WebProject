<?php

namespace Model;

use PDO;

abstract class BaseEntity
{
    protected PDO $db;
    protected string $prefix;

    protected function __construct($id=null)
    {
        $dsn = "mysql:host=" . DB_HOST . ";port=3306;dbname=" . DB_NAME . ";charset=UTF8";

        $this->db = new PDO($dsn, DB_USER, DB_PASS);
    }


    protected function getPrefix(): string
    {
        return $this->prefix;
    }

    protected function stats()
    {
        return get_class_vars(self::class);
    }
}