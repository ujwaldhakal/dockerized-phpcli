<?php

namespace App\Datasource;

use App\Datasource\Interfaces\RolesDataInterface;
use App\Exceptions\DataNotLoaded;

class RolesData implements RolesDataInterface
{
    const FILENAME = 'app/Datasource/roles.json';

    public function get(): array
    {
        try {
            return json_decode(file_get_contents($this->getFileName()), 1);
        } catch (\Exception $exception) {
            throw new DataNotLoaded();
        }
    }

    private function getFileName(): string
    {
        return self::FILENAME;
    }
}
