<?php

namespace PaperLeaf\MissionControl\Models\Enums;

use Filament\Support\Contracts\HasLabel;
use Filament\Support\Contracts\HasColor;

enum InstallType: string implements HasLabel, HasColor
{
    case DEPENDENCY = 'dependency';
    case REQUIRE = 'require';
    case REQUIRE_DEV = 'require-dev';

    public static function toArray(): array
    {
        return EnumHelper::toArray(self::class);
    }

    public function getLabel(): ?string
    {
        return match($this) {
            self::DEPENDENCY => 'Dependency',
            self::REQUIRE => 'Installed',
            self::REQUIRE_DEV => 'Dev Install',
        };
    }

    public function getColor(): string | array | null
    {
        return match ($this) {
            self::DEPENDENCY => 'gray',
            self::REQUIRE => 'success',
            self::REQUIRE_DEV => 'warning',
        };
    }

    public function getDescription(): string
    {
        return match ($this) {
            self::DEPENDENCY => 'Installed as a dependency of another package.',
            self::REQUIRE => 'Manually installed. Available in all environments.',
            self::REQUIRE_DEV => 'Manually installed. Available in testing and development environments.',
        };
    }
}
