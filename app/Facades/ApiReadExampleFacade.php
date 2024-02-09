<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class ApiReadExampleFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'read-api';
    }
}
