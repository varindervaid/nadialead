<?php

namespace App\CallRailService\Facades;
use Illuminate\Support\Facades\Facade;

class CallRail extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'callrail';
    }
}
