<?php

namespace PaperLeaf\MissionControl\Widgets;

use Livewire\Attributes\Computed;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Builder;

use Filament\Actions\Action;
use Filament\Support\Enums\IconPosition;
use Filament\Support\Icons\Heroicon;

use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;

use PaperLeaf\MissionControl\Services\ServicesService;

use PaperLeaf\MissionControl\Models\ComposerPackage;
use PaperLeaf\MissionControl\Models\Enums\InstallType;

class PackagesTableWidget extends TableWidget
{
    public function table(Table $table): Table
    {
        return $table
            ->heading('')
            ->query(fn() => ComposerPackage::query())
            ->columns([
                TextColumn::make('pretty_name')
                    ->label('Package')
                    ->searchable()
                    ->sortable()
                    ->tooltip(fn($record) => $record->description),

                TextColumn::make('install_type')
                    ->badge()
                    ->tooltip(fn($state) => optional($state)->getDescription())
                    ->sortable(),

                TextColumn::make('prettyVersion')
                    ->label('Installed version'),
                
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
            ])
            ->filters([
                Filter::make('hide_dependencies')
                    ->label('Hide Dependencies')
                    ->default()
                    ->query(fn (Builder $query): Builder => $query->where('install_type', '!=', InstallType::DEPENDENCY))
                    ->toggle()
            ]);
    }
}
