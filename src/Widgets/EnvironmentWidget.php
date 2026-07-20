<?php

namespace PaperLeaf\MissionControl\Widgets;

use Filament\Widgets\Widget;
use Livewire\Attributes\Computed;

class EnvironmentWidget extends Widget
{
    // protected string $view = 'filament.widgets.admin.account-overview';
    protected string $view = 'mission-control::widgets.environment-overview';
    protected int | string | array $columnSpan = [
        'default' => 'full',
    ];

    #[Computed]
    public function user()
    {
        return auth()->user();
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
