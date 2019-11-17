<?php

require __DIR__.'/vendor/autoload.php';

$usersData = new \App\Datasource\UsersData();
$rolesData = new \App\Datasource\RolesData();

$users = new \App\Domains\Users($usersData, $rolesData);

var_dump($users->getSubordinates($argv[1]));
