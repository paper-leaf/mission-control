<?php

namespace PaperLeaf\MissionControl\Widgets;

use Filament\Widgets\Widget;
use Livewire\Attributes\Computed;

use PaperLeaf\MissionControl\Services\PackagesService;

class EnvironmentWidget extends Widget
{
    protected string $view = 'mission-control::widgets.environment-widget';
    protected int | string | array $columnSpan = [
        'default' => 'full',
    ];

    #[Computed]
    public function packages()
    {
        return new PackagesService();
    }

    #[Computed]
    public function userGroup()
    {
        return $this->user->group;
    }

    #[Computed]
    public function viewingGroup()
    {
        return $this->user->currentGroup();
    }
}
