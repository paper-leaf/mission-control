<?php

namespace PaperLeaf\MissionControl;

use Filament\Contracts\Plugin;
use Filament\Panel;

use PaperLeaf\MissionControl\Pages\ControlDashboard;

class MissionControlPlugin implements Plugin
{
    public function getId(): string
    {
        return 'mission-control';
    }

    public function register(Panel $panel): void
    {
        $panel
            ->pages([
                ControlDashboard::class,
            ]);
    }

    public function boot(Panel $panel): void
    {
        //
    }

    public static function make(): static
    {
        return app(static::class);
    }

    public static function get(): static
    {
        /** @var static $plugin */
        $plugin = filament(app(static::class)->getId());

        return $plugin;
    }
}
