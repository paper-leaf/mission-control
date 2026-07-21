<?php

namespace PaperLeaf\MissionControl\Extends;

use Filament\Widgets\Widget;
use Livewire\Attributes\Computed;
use Illuminate\Support\Str;

use Filament\Notifications\Notification;

use PaperLeaf\MissionControl\Services\ServicesService;

class BaseWidget extends Widget
{
    protected string $view = 'mission-control::widgets.base-widget';
    protected int | string | array $columnSpan = [
        'default' => '1',
    ];

    public string $icon = 'heroicon-o-rocket-launch';
    public string $heading = 'Widget';

    public bool $has_primary_action = false;
    public string $primary_action_label = 'Test';

    #[Computed]
    public function services()
    {
        return new ServicesService();
    }

    #[Computed]
    private function links()
    {
        return [];
    }

    #[Computed]
    private function data()
    {
        return [];
    }

    /**
     * Action
     */
    public function primaryAction()
    {
        dd('you should write logic here.');
    }
}
