<?php

namespace Entity;

use Model\BaseEntity;

class Users extends BaseEntity
{
    protected string $db_table = 'users';
    protected string $prefix = 'U';

    protected string $first_name;
    protected string $last_name;
    protected string $email;
    protected string $password;
    protected int $is_admin;

    /**
     * @param int|null $id
     */
    public function __construct($id=null)
    {
        parent::__construct($id);
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->first_name;
    }

    /**
     * @param string $first_name
     * @return Users
     */
    public function setFirstName(string $first_name): Users
    {
        $this->first_name = $first_name;
        return $this;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->last_name;
    }

    /**
     * @param string $last_name
     * @return Users
     */
    public function setLastName(string $last_name): Users
    {
        $this->last_name = $last_name;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return Users
     */
    public function setEmail(string $email): Users
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     * @return Users
     */
    public function setPassword(string $password): Users
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @return int
     */
    public function getIsAdmin(): int
    {
        return $this->is_admin;
    }

    /**
     * @param int $is_admin
     * @return Users
     */
    public function setIsAdmin(int $is_admin): Users
    {
        $this->is_admin = $is_admin;
        return $this;
    }



}