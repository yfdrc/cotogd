<?php

namespace App\Services\Drc\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class Access.
 */
class DrcFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'drc';
    }
}
