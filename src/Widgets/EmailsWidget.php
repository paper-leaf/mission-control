<?php

namespace PaperLeaf\MissionControl\Widgets;

use Livewire\Attributes\Computed;
use Illuminate\Support\Str;

use Filament\Notifications\Notification;
use PaperLeaf\MissionControl\Notifications\TestEmail;

use PaperLeaf\MissionControl\Extends\BaseWidget;

class EmailsWidget extends BaseWidget
{
    public string $icon = 'heroicon-o-envelope';
    public string $heading = 'Emails';
    
    public bool $has_primary_action = true;
    public string $primary_action_label = 'Send Test';

    #[Computed]
    private function data()
    {
        return [
            'Mailer' => Str::upper(config('mail.default', 'mail')),
            'Host' => Str::upper(config('mail.host', 'not set')),
            'From Address' => config('mail.from.address', 'not set'),
            'From Name' => config('mail.from.name', 'not set'),
        ];
    }

    /**
     * Send a test email to the current user
     */
    public function primaryAction()
    {
        try {
            $user = auth()->user();

            $user->notify(new TestEmail());

            Notification::make()
                ->title(sprintf('The test email was succesfully sent to %s', $user->email))
                ->icon('heroicon-o-check-circle')
                ->iconColor('success')
                ->send();
        } catch (Exception $e) {
            Notification::make()
                ->title('The test email could not be sent. Please check the error log for next steps.')
                ->icon('heroicon-o-x-circle')
                ->iconColor('danger')
                ->send();
        }
    }
}
