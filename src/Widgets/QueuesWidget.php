<?php

namespace PaperLeaf\MissionControl\Widgets;

use Livewire\Attributes\Computed;
use Illuminate\Support\Str;

use PaperLeaf\MissionControl\Extends\BaseWidget;

class QueuesWidget extends BaseWidget
{
    public string $icon = 'heroicon-o-queue-list';
    public string $heading = 'Jobs Queue';

    #[Computed]
    private function links()
    {
        $links = [];

        // Check if Horizon is installed
        $is_horizon = $this->services->isInstalled('composer', 'laravel/horizon');
        if($is_horizon) {
            $links['Horizon Dashboard'] = '/horizon';
        }

        return $links;
    }

    #[Computed]
    private function data()
    {
        return Str::title(config('queue.default', 'not set'));
    }
}
