<?php

namespace PaperLeaf\MissionControl\Commands;

use Illuminate\Console\Command;

class MissionControlCommand extends Command
{
    public $signature = 'mission-control';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
