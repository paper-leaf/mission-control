<?php

namespace PaperLeaf\MissionControl\Widgets;

use Filament\Widgets\Widget;
use Livewire\Attributes\Computed;
use Illuminate\Support\Str;

use Filament\Notifications\Notification;
use PaperLeaf\MissionControl\Notifications\TestEmail;

class EmailsWidget extends Widget
{
    protected string $view = 'mission-control::widgets.base-widget';
    protected int | string | array $columnSpan = [
        'default' => '1',
    ];

    private string $icon = 'heroicon-o-envelope';
    private string $heading = 'Emails';

    private bool $has_primary_action = true;
    private string $primary_action_label = 'Send Test';

    private function data(): array
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
