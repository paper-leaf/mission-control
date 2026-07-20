<?php

namespace PaperLeaf\MissionControl\Pages;

use Exception;
use Filament\Pages\Page;
// use Filament\Infolists\Infolist;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Livewire;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;

use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Mail;
use Illuminate\Mail\Message;

use Filament\Actions\Action;

use PaperLeaf\MissionControl\Widgets\EnvironmentWidget;

class ControlDashboard extends Page
{
    // use InteractsWithSchemas;
    // use RestrictsFileUploadsToSchemaComponents;

    // protected static ?int $navigationSort = 1;
    // protected static ?string $cluster = SystemTools::class;
    
    protected static ?string $title = 'Mission Control';
    protected ?string $subheading = "Mission Control is the command center for your Laravel application, giving you a clear view of your site's systems, integrations, and environment.";
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rocket-launch';

    protected string $view = 'mission-control::pages.control-dashboard';

    public function dashboardinfolist(): Schema
    {
        return Schema::make($this)
            ->state([]) 
            ->schema([
                Livewire::make(EnvironmentWidget::class)
                    ->columnSpanFull(),

                Tabs::make('Dashboard Tabs')
                    ->columnSpanFull()
                    ->tabs([
                        $this->systemsTab(),
                        $this->connectionsTab(),
                        $this->monitoringTab(),
                        $this->infrastructureTab(),
                        $this->packagesTab(),
                    ]),
            ]);
    }

    /***************************************
     * TABS
     ***************************************/

    /**
     * Infrastructure Tab
     * 
     * @return Tab
     */
    private function infrastructureTab()
    {
        return Tab::make('Infrastructure')
                            ->schema([

                        ]);
    }

    /**
     * Packages Tab
     * 
     * @return Tab
     */
    private function packagesTab()
    {
        return Tab::make('Packages')
                            ->schema([

                        ]);
    }

    /**
     * Monitoring Tab
     * 
     * @return Tab
     */
    private function monitoringTab()
    {
        return Tab::make('Monitoring')
                            ->schema([

                        ]);
    }

    /**
     * Systems Tab
     * 
     * @return Tab
     */
    private function systemsTab()
    {
        return Tab::make('Systems')
                            ->schema([

                        ]);
    }

    /**
     * Connections Tab
     * 
     * @return Tab
     */
    private function connectionsTab()
    {
        return Tab::make('Connections')
                            ->schema([

                        ]);
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
