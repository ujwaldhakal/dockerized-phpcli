<?php

namespace App\Datasource;

use App\Datasource\Interfaces\UsersDataInterface;
use App\Exceptions\DataNotLoaded;

class UsersData implements UsersDataInterface
{
    private function getFileName(): string
    {
        return "app/Datasource/users.json";
    }

    public function getAll(): array
    {
        try {

            return json_decode(file_get_contents($this->getFileName()), 1);
        } catch (\Exception $exception) {
            throw new DataNotLoaded();
        }
    }
}
