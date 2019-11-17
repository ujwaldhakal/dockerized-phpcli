<?php

namespace App\Datasource;

use App\Datasource\Interfaces\UsersDataInterface;
use App\Exceptions\DataNotLoaded;

class UsersData implements UsersDataInterface
{
    const FILENAME = 'app/Datasource/users.json';

    private function getFileName(): string
    {
        return self::FILENAME;
    }

    public function get(): array
    {
        try {

            return json_decode(file_get_contents($this->getFileName()), 1);
        } catch (\Exception $exception) {
            throw new DataNotLoaded();
        }
    }
}
