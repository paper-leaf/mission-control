<?php

namespace PaperLeaf\MissionControl\Widgets;

use Livewire\Attributes\Computed;
use Illuminate\Support\Str;

use Filament\Notifications\Notification;

use PaperLeaf\MissionControl\Extends\BaseWidget;

class CacheWidget extends BaseWidget
{
    public string $icon = 'heroicon-o-bookmark';
    public string $heading = 'Caching';

    public bool $has_primary_action = true;
    public string $primary_action_label = 'Clear Cache';

    #[Computed]
    public function data()
    {
        return Str::upper(config('cache.default', 'not enabled'));
    }

    /**
     * Refresh the application caches
     */
    public function primaryAction()
    {
        try {
            $this->services->runArtisan('cache:clear');
            $this->services->runArtisan('view:clear');
            $this->services->runArtisan('config:clear');
            $this->services->runArtisan('event:clear');
            $this->services->runArtisan('route:clear');

            Notification::make()
                ->title('The cache has been successfully cleared.')
                ->icon('heroicon-o-check-circle')
                ->iconColor('success')
                ->send();

        } catch (\Exception $e) {
            Notification::make()
                ->title('The cache could not be cleared. Please check the error log for next steps.')
                ->icon('heroicon-o-x-circle')
                ->iconColor('danger')
                ->send();
        }
    }
}
