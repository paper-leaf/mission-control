<?php

namespace PaperLeaf\MissionControl\Pages;

use Exception;
use Filament\Pages\Page;
// use Filament\Infolists\Infolist;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Livewire;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Components\Grid;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Mail;
use Illuminate\Mail\Message;

use Filament\Actions\Action;

use PaperLeaf\MissionControl\Widgets\EnvironmentWidget;
use PaperLeaf\MissionControl\Widgets\EmailsWidget;
use PaperLeaf\MissionControl\Widgets\NotificationsWidget;
use PaperLeaf\MissionControl\Widgets\QueuesWidget;
use PaperLeaf\MissionControl\Widgets\CacheWidget;

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
                    ->persistTabInQueryString()
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
                        Grid::make(2)
                            ->schema([
                                Livewire::make(QueuesWidget::class),
                                Livewire::make(CacheWidget::class),
                            ])
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
                        Grid::make(2)
                            ->schema([
                                Livewire::make(EmailsWidget::class),
                                Livewire::make(NotificationsWidget::class),
                            ])
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
}
