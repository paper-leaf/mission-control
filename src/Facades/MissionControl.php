<?php

namespace Paper Leaf\MissionControl\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Paper Leaf\MissionControl\MissionControl
 */
class MissionControl extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Paper Leaf\MissionControl\MissionControl::class;
    }
}
