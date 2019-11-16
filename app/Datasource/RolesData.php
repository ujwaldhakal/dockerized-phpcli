<?php

namespace App\Datasource;

use App\Datasource\Interfaces\RolesDataInterface;
use App\Exceptions\DataNotLoaded;

class RolesData implements RolesDataInterface
{
    public function getAll(): array
    {
        try {
            return json_decode(file_get_contents($this->getFileName()), 1);
        } catch (\Exception $exception) {
            throw new DataNotLoaded();
        }
    }

    private function getFileName(): string
    {
        return 'app/Datasource/roles.json';
    }
}
