<?php

namespace PaperLeaf\MissionControl\Widgets;

use Livewire\Attributes\Computed;
use Illuminate\Support\Str;

use Filament\Actions\Action;
use Filament\Support\Enums\IconPosition;
use Filament\Support\Icons\Heroicon;

use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;

use PaperLeaf\MissionControl\Services\ServicesService;

class MonitoringTableWidget extends TableWidget
{
    private function getRecords()
    {
        // Get all the data from the config
        $rows = [];
        $monitoring_services = config('mission-control.monitoring', []);

        $package_service = new ServicesService();

        foreach($monitoring_services as $key => $service) {
            $service = collect($service);

            $row = [
                'label' => $service->get('label', $key),
                'description' => $service->get('description'),
                'link_label' => $service->get('link_label', 'View Dashboard'),
                'link' => $service->get('link'),
                'status' => 'N/A',
            ];

            // Check if the package is installed
            switch($service->get('package_type')) {
                case 'composer': 
                    $package_details = $package_service->checkPackage($service->get('package_name', $key));

                    $row['is_installed'] = $package_details['installed'];
                    $row['version'] = $package_details['version'];
                    $row['description'] = $package_service->composerDescription($service->get('package_name', $key));
                    break;

                default: 
                    $row['is_installed'] = $service->get('is_installed', false);
                    $row['version'] = $service->get('version', null);
                    break;
            }

            if($service->has('status_function')) {
                $param = $service->get('param');
                $row['status'] = $package_service->{$service->get('status_function')}($param);
            }

            $rows[] = $row;
        }

        return $rows;
    }

    public function table(Table $table): Table
    {
        return $table
            ->heading('')
            ->records(fn() => $this->getRecords())
            ->columns([
                TextColumn::make('label')
                    ->label('Service'),

                TextColumn::make('description')
                    ->formatStateUsing(fn($state) => ($state == 0) ? '' : "<i class=\"text-xs\">{$state}</i>")
                    ->html(),

                IconColumn::make('is_installed')
                    ->label('Installed')
                    ->trueIcon(Heroicon::CheckCircle)
                    ->boolean(),

                TextColumn::make('version')
                    ->label('Installed version')
                    ->formatStateUsing(fn($state) => Str::start($state, 'v')),

                TextColumn::make('status')
                    ->formatStateUsing(fn($record, $state) => ($record['is_installed']) ? $state : null)
                    ->badge(fn($record, $state) => $record['is_installed'] && $state != 'N/A')
                    ->color(function($record, $state) {
                        if(!$record['is_installed']) {
                            return 'gray';
                        }

                        return match($state) {
                            'Inactive' => 'danger',
                            'Active' => 'success',
                            'Configured' => 'success',
                            default => 'gray'
                        };
                    }),
            ])
            ->recordActions([
                Action::make('view')
                    ->visible(fn($record) => isset($record['link']))
                    ->label(fn($record) => $record['link_label'])
                    ->icon('heroicon-o-arrow-top-right-on-square')
                    ->iconPosition(IconPosition::After)
                    ->link()
                    ->openUrlInNewTab()
                    ->url(fn($record) => $record['link']),
            ]);
    }
}
