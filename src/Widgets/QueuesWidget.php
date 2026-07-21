<?php

namespace PaperLeaf\MissionControl\Widgets;

use Filament\Widgets\Widget;
use Livewire\Attributes\Computed;
use Illuminate\Support\Str;

use PaperLeaf\MissionControl\Services\ServicesService;

class QueuesWidget extends Widget
{
    protected string $view = 'mission-control::widgets.base-widget';
    protected int | string | array $columnSpan = [
        'default' => '1',
    ];

    private string $icon = 'heroicon-o-queue-list';
    private string $heading = 'Jobs Queue';

    #[Computed]
    public function services()
    {
        return new ServicesService();
    }

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
