<?php

namespace Html\Model;

class Users extends BaseEntity
{
    const db_table = 'users';
    const prefix = 'U';

    private string $first_name;
    private string $last_name;
    private string $email;
    private string $password;
    private int $is_admin;

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