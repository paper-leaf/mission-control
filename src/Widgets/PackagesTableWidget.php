<?php

namespace PaperLeaf\MissionControl\Widgets;

use Livewire\Attributes\Computed;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

use Filament\Actions\Action;
use Filament\Support\Enums\IconPosition;
use Filament\Support\Icons\Heroicon;

use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;

use PaperLeaf\MissionControl\Services\ServicesService;

class PackagesTableWidget extends TableWidget
{
    private function getRecords($search, $page, $recordsPerPage)
    {
        // Get all the data from composer.json
        $rows = [];
        $package_service = new ServicesService();
        $packages = $package_service->installedPackages()
                        ->transform(function($package) {
                            $source = $package->source ?? null;

                            return [
                                'name' => optional($package)->name,
                                'description' => optional($package)->description,
                                'version' => optional($package)->version,
                                'source_url' => optional($source)->url,
                            ];
                        });

        $total = $packages->count();

        // Apply the Search
        $packages->when(filled($search), function($data) {
            $data->filter(
                fn (array $record): bool => str_contains(Str::lower($record['name']), Str::lower($search)),
            );
        });

        // Apply the pagination
        $packages = $packages->forPage($page, $recordsPerPage);

        return [
            'records' => $packages,
            'total' => $total
        ];
    }

    public function table(Table $table): Table
    {
        return $table
            ->heading('')
            ->records(function (?string $search, int $page, int $recordsPerPage): LengthAwarePaginator {
                $record_data = $this->getRecords($search, $page, $recordsPerPage);
                            
                return new LengthAwarePaginator(
                    $record_data['records'],
                    total: $record_data['total'],
                    perPage: $recordsPerPage,
                    currentPage: $page,
                );
            })
            ->columns([
                TextColumn::make('name')
                    ->label('Package')
                    ->searchable(),

                TextColumn::make('description')
                    ->formatStateUsing(fn($state) => ($state == 0) ? '' : "<i class=\"text-xs\">{$state}</i>")
                    ->html(),

                TextColumn::make('version')
                    ->label('Installed version')
                    ->formatStateUsing(fn($state) => Str::start($state, 'v')),
                
            ])
            ->recordActions([
                Action::make('view')
                    ->visible(fn($record) => isset($record['source_url']))
                    ->label('View Source')
                    ->icon('heroicon-o-arrow-top-right-on-square')
                    ->iconPosition(IconPosition::After)
                    ->link()
                    ->openUrlInNewTab()
                    ->url(fn($record) => $record['source_url']),
            ]);
    }
}
