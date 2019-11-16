<?php

namespace App\Domains;

use App\Datasource\Interfaces\RolesDataInterface;
use App\Datasource\Interfaces\UsersDataInterface;

class Users
{
    private $usersData;
    private $rolesData;

    public function __construct(UsersDataInterface $usersData, RolesDataInterface $rolesData)
    {
        $this->usersData = $usersData;
        $this->rolesData = $rolesData;
    }

    public function getSubordinates()
    {

    }
}
