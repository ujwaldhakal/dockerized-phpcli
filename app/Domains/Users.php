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
        $this->usersData = $usersData->get();
        $this->rolesData = $rolesData->get();
    }

    private function searchUserById($userId): ?array
    {
        foreach ($this->usersData as $user) {
            if ($user['id'] === $userId) {
                return $user;
            }
        }

        return null;
    }


    /**
     * Just to make sure we wont miss any childrens due to re ordering / large data sets
     * @param int $roleId
     * @return array
     */
    private function searchChildrenRoleByRoleId(int $roleId): array
    {
        $ids = [];

        $counter = 1;

        for ($i = 0; $i < $counter; $i++) {
            foreach ($this->rolesData as $role) {

                if ($role['parent'] === $roleId && !in_array($role['id'],$ids)) {
                    array_push($ids, $role['id']);
                    $counter++;
                    continue;
                }

                if (in_array($role['parent'], $ids) && !in_array($role['id'],$ids)) {
                    array_push($ids, $role['id']);
                    $counter++;
                    continue;
                }
            }
        }


        return $ids;
    }


    private function searchUserByRoleIds(array $roleIds): ?array
    {
        $results = [];
        foreach ($this->usersData as $user) {
            if (in_array($user['role'], $roleIds)) {
                array_push($results, $user);
            }
        }

        return $results;
    }


    public function getSubordinates(int $userId): ?array
    {

        $user = $this->searchUserById($userId);

        if ($user) {
            $roleIds = $this->searchChildrenRoleByRoleId($user["role"]);

            return $this->searchUserByRoleIds($roleIds);
        }

        return null;

    }


}
