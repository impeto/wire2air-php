<?php

namespace Impeto\Wire2Air\Laravel;

use Illuminate\Support\Facades\Facade;

class Wire2AirFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'w2a';
    }
}