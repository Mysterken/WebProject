<?php

namespace Html\Model;

use Exception;
use PDO;

abstract class BaseEntity
{
    protected PDO $db;
    protected string $db_table;
    protected string $prefix;

    private array $schema;
    private $id;

    /**
     * @throws Exception
     */
    protected function __construct($id=null)
    {
        $this->id = $id;

        $this->db = new PDO(DSN, DB_USER, DB_PASS);
        $this->schema = $this->getSchema();

        if (!is_null($this->getId())) {

            $query = $this->db->prepare("SELECT * FROM " . $this->db_table . " WHERE " . $this->getPrefix() . "_ID = :id");

            if (!$query->execute(array(':id' => $this->getId()))) {
                throw new Exception("Failed to query the database " . DB_NAME);
            }

            if (!$res = $query->fetch(PDO::FETCH_ASSOC)) {
                throw new Exception("Row not found for table " . $this->db_table . " with ID = " . $this->getId());
            }

            // Set values to class by looking into the db and using setters
            foreach ($res as $col_name => $col_value) {
                $method = strtolower(substr($col_name, 2));
                $method = array_map(function ($str) {
                    return ucfirst($str);
                }, explode("_", $method));
                $method = 'set' . implode('', $method);
                $this->$method($col_value);
            }
        }

    }


    /**
     * @throws Exception
     */
    public function flush()
    {
        if (!is_null($this->getId())) {
            $this->updateValues();
        } else {
            $this->insert();
        }
    }

    /**
     * @throws Exception
     */
    private function updateValues()
    {
        $update_sql = "UPDATE `" . $this->db_table ."` SET ";

        foreach ($this->schema as $col_value) {
            if (substr($col_value['COLUMN_NAME'], 0, 2) === $this->getPrefix() . '_') {
                $method = strtolower(substr($col_value['COLUMN_NAME'], 2));
                $method = array_map(function ($str) {
                    return ucfirst($str);
                }, explode("_", $method));
                $method = 'get' . implode('', $method);

                $update_sql .= "`" . $col_value['COLUMN_NAME'] . "` = " .
                    ($this->$method() !== null ? "'" . $this->$method() . "'" : "NULL") . ", ";
            }
        }
        $update_sql = substr($update_sql, 0, -2);
        $update_sql .= " WHERE `" . $this->db_table . "`.`" . $this->getPrefix() . "_ID` = " . $this->getId();

        if (!$this->db->prepare($update_sql)->execute()) {
            throw new Exception("Update failed for table " . $this->db_table . $update_sql);
        }
        echo "Row successfully updated for table " . $this->db_table . " with ID = " . $this->getId();
    }

    /**
     * @throws Exception
     */
    private function insert()
    {
        $insert_sql = "INSERT INTO `" . $this->db_table ."` (";
        $col_values = "";

        foreach ($this->schema as $col_value) {
            if (substr($col_value['COLUMN_NAME'], 0, 2) === $this->getPrefix() . '_') {
                $method = strtolower(substr($col_value['COLUMN_NAME'], 2));
                $method = array_map(function ($str) {
                    return ucfirst($str);
                }, explode("_", $method));
                $method = 'get' . implode('', $method);

                $insert_sql .= "`" . $col_value['COLUMN_NAME'] . "`, ";
                $col_values .= ($this->$method() !== null ? "'" . $this->$method() . "'" : "NULL") . ", ";
            }
        }
        $insert_sql = substr($insert_sql, 0, -2) . ") VALUES (";
        $insert_sql .= substr($col_values, 0, -2) . ")";

        if (!$this->db->prepare($insert_sql)->execute()) {
            throw new Exception("Insertion failed for table " . $this->db_table);
        }

        $this->setId($this->db->lastInsertId());

        echo "Row successfully inserted for table " . $this->db_table . " with ID = " . $this->db->lastInsertId();
    }

    /**
     * @throws Exception
     */
    private function getSchema(): array
    {
        $sql = "
        SELECT COLUMN_NAME
        FROM INFORMATION_SCHEMA.COLUMNS
        WHERE TABLE_NAME = '" . $this->db_table . "'";

        if (!$schema = $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC)) {
            throw new Exception("Could not fetch schema for table " . $this->db_table);
        }

        return $schema;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return void
     */
    private function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getPrefix(): string
    {
        return $this->prefix;
    }
}