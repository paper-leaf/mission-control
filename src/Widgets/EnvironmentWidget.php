<?php

namespace PaperLeaf\MissionControl\Widgets;

use Filament\Widgets\Widget;
use Livewire\Attributes\Computed;

use PaperLeaf\MissionControl\Services\ServicesService;
use PaperLeaf\MissionControl\Models\ComposerPackage;
use PaperLeaf\MissionControl\MissionControlPlugin;

class EnvironmentWidget extends Widget
{
    protected string $view = 'mission-control::widgets.environment-widget';
    protected int | string | array $columnSpan = [
        'default' => 'full',
    ];

    #[Computed]
    public function icon()
    {
        $plugin = filament()->getPlugin(MissionControlPlugin::ID);
        return $plugin->getPageIcon() ?? 'heroicon-o-rocket-launch';
    }

    #[Computed]
    public function services()
    {
        return new ServicesService();
    }

    #[Computed]
    public function laravelVersion()
    {
        return optional(ComposerPackage::firstWhere('name', 'laravel/framework'))->version;
    }

    #[Computed]
    public function filamentVersion()
    {
        return optional(ComposerPackage::firstWhere('name', 'filament/filament'))->version;
    }

    #[Computed]
    public function livewireVersion()
    {
        return optional(ComposerPackage::firstWhere('name', 'livewire/livewire'))->version;
    }
}
