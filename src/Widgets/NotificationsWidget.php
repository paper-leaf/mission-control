<?php

namespace PaperLeaf\MissionControl\Widgets;

use Livewire\Attributes\Computed;
use Illuminate\Support\Str;
use Filament\Facades\Filament;

use Filament\Notifications\Notification;

use PaperLeaf\MissionControl\Extends\BaseWidget;

class NotificationsWidget extends BaseWidget
{
    public string $icon = 'heroicon-o-bell-alert';
    public string $heading = 'Filament Notifications';
    
    public bool $has_primary_action = true;
    public string $primary_action_label = 'Send Test';

    #[Computed]
    private function data()
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
