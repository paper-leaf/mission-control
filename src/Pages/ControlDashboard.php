<?php

namespace PaperLeaf\MissionControl\Pages;

use Exception;
use Filament\Pages\Page;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Mail;
use Illuminate\Mail\Message;
// use App\Filament\Clusters\SystemTools;
// use App\Helpers\NotificationsHelper;
use Filament\Actions\Action;

class ControlDashboard extends Page
{
    protected static ?int $navigationSort = 1;
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-information-circle';
    // protected static ?string $cluster = SystemTools::class;

    protected ?string $subheading = 'View the details of the site\'s versions and configuration.';

    protected string $view = 'mission-control::pages.control-dashboard';

    protected static ?string $title = 'Site Details';

    public static function canAccess(): bool
    {
        return (auth()->user()->can('view_site_details'));
    }

    /**
     * Header actions for Site details
     */
    protected function getHeaderActions(): array
    {
        return [
            Action::make('help')
                ->label('Open help guide')
                ->link()
                ->icon('heroicon-s-question-mark-circle')
                ->url('#modal-SystemTools.site-details')
                ->openUrlInNewTab(false),
        ];
    }

    /***************************************
     * FUNCTIONS
     ***************************************/

    /**
     * Refresh the application caches
     */
    public function clearCache()
    {
        try {
            Artisan::call('cache:clear');
            Artisan::call('view:clear');
            Artisan::call('config:clear');
            Artisan::call('event:clear');
            Artisan::call('route:clear');

            Notification::make()
                ->title('The cache has been successfully cleared.')
                ->icon('heroicon-o-check-circle')
                ->iconColor('success')
                ->send();
        } catch (Exception $e) {
            Notification::make()
                ->title('The cache could not be cleared. Please check the error log for next steps.')
                ->icon('heroicon-o-x-circle')
                ->iconColor('danger')
                ->send();
        }
    }

    /**
     * Send a test email to the current user
     */
    public function sendTestEmail()
    {
        try {
            $user = auth()->user();
            NotificationsHelper::send(
                user: $user, 
                notification_name: 'test_email', 
                log_message: 'Test email sent to admin',
            );

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



    /**
     * Send a test notification to the current user
     */
    public function sendTestNotification() 
    {   
        $current_user = auth()->user();     

        // Send the in-system notification
        $current_user->notify(
            Notification::make()
                ->title('If you can read this then your test notification was sent successfully!')
                ->success()
                ->icon('heroicon-o-face-smile')
            ->toDatabase(),
        );

        // Send the email notification
        $notification_data = [
            'subject' => 'Test notification',
            'greeting' => "Hi {$current_user->name},",
            'lines' => ['If you can read this then your test notification was sent successfully!'],
        ];
        NotificationsHelper::send(
            user: $current_user, 
            notification_name: 'admin_system_notification', 
            notification_data: $notification_data,
            log_message: 'Test notification sent to admin',
        );

        // Immediately show a success notification
        Notification::make()
            ->title('The test notification was sent. Check your notifications + email to read it.')
            ->icon('heroicon-o-check-circle')
            ->iconColor('success')
            ->send();
    }
}
