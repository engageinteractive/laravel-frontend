<?php

namespace Engage\LaravelFrontend\Data;

class DataFile
{
    const EXT = 'data.php';

    public function use($key)
    {
        $repository = DataService::repository();
        return $repository->get($key);
    }
}
