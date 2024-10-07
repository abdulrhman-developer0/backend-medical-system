<?php

namespace App\Facades;

use App\TDO\TDO;
use Illuminate\Support\Facades\Facade;

class TDOFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return TDO::class;
    }

}
