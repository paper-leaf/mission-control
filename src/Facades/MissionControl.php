<?php

namespace PaperLeaf\MissionControl\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \PaperLeaf\MissionControl\MissionControl
 */
class MissionControl extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \PaperLeaf\MissionControl\MissionControl::class;
    }
}
