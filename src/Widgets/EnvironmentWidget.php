<?php

namespace PaperLeaf\MissionControl\Widgets;

use Filament\Widgets\Widget;
use Livewire\Attributes\Computed;

use PaperLeaf\MissionControl\Services\ServicesService;

class EnvironmentWidget extends Widget
{
    protected string $view = 'mission-control::widgets.environment-widget';
    protected int | string | array $columnSpan = [
        'default' => 'full',
    ];

    #[Computed]
    public function services()
    {
        return new ServicesService();
    }
}
