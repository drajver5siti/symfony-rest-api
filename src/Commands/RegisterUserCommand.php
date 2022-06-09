<?php

namespace App\Commands;


class RegisterUserCommand
{

    private string $username;
    private string $password;
    private int $age;

    public function __construct(string $username, string $password, int $age)
    {
        $this->username = $username;
        $this->password = $password;
        $this->age = $age;
    }


    /**
     * Get the value of username
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Get the value of password
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Get the value of age
     */
    public function getAge()
    {
        return $this->age;
    }
}
