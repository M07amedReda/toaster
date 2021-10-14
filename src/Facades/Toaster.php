<?php

namespace MohamedReda\Toaster\Facades;

use Illuminate\Support\Facades\Facade;

class Toaster extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'toaster';
    }
}
