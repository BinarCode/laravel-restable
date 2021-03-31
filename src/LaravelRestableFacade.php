<?php

namespace BinarCode\LaravelRestable;

use Illuminate\Support\Facades\Facade;

/**
 * @see \BinarCode\LaravelRestable\LaravelRestable
 */
class LaravelRestableFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'laravel_restable';
    }
}
