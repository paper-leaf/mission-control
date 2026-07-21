<?php

namespace PaperLeaf\MissionControl\Widgets;

use Filament\Widgets\Widget;
use Livewire\Attributes\Computed;
use Illuminate\Support\Str;
use Filament\Facades\Filament;

use Filament\Notifications\Notification;

class NotificationsWidget extends Widget
{
    protected string $view = 'mission-control::widgets.base-widget';
    protected int | string | array $columnSpan = [
        'default' => '1',
    ];

    private string $icon = 'heroicon-o-bell-alert';
    private string $heading = 'Filament Notifications';

    private bool $has_primary_action = true;
    private string $primary_action_label = 'Send Test';


    private function data(): array
    {
        return [
            'Database Notifications Enabled' => (Filament::getCurrentPanel()?->hasDatabaseNotifications()) ? 'Yes' : 'No',
            'Notifications Polling Time' => Filament::getDatabaseNotificationsPollingInterval(),
            'Notifications Sent Via' => Str::title(config('queue.default', 'not set')),
        ];
    }

    /**
     * Send a test notification to the current user
     */
    public function primaryAction()
    {        
        try {
            $current_user = Filament::auth()->user();   

            if(!isset($current_user)) {
                Notification::make()
                    ->title('No current user was found to receive the notification.')
                    ->icon('heroicon-o-x-circle')
                    ->iconColor('danger')
                    ->send();
            }

            $current_user->notify(
                Notification::make()
                    ->title('If you can read this then your test notification was sent successfully!')
                    ->success()
                    ->icon('heroicon-o-face-smile')
                ->toDatabase(),
            );

            $this->dispatch('updateDatabaseNotificationsSent'); 

        } catch(\Exception $e) {
            Notification::make()
                ->title('The test notification could not be sent. Please check the error log for next steps.')
                ->icon('heroicon-o-x-circle')
                ->iconColor('danger')
                ->send();
        }
    }
}
