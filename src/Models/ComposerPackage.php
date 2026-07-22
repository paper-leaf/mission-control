<?php

namespace PaperLeaf\MissionControl\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Casts\Attribute;

use PaperLeaf\MissionControl\Services\ServicesService;

use PaperLeaf\MissionControl\Models\Enums\InstallType;

class ComposerPackage extends Model
{
    use \Sushi\Sushi;

    protected $schema = [
        'name' => 'string',
        'description' => 'string',
        'install_type' => 'string',
        'version' => 'float',
        'source_url' => 'string',
    ];

    public function getRows()
    {
        $package_service = new ServicesService();
        $installed_packages = $package_service->userInstalledPackages();

        $packages = $package_service->installedPackages()
                ->transform(function($package) use($installed_packages) {
                    $name = optional($package)->name;
                    $source = $package->source ?? null;

                    // Check WHY this package was installed
                    $install_type = $installed_packages->get($name, 'dependency');

                    return [
                        'name' => $name,
                        'description' => optional($package)->description,
                        'install_type' => $install_type,
                        'version' => optional($package)->version,
                        'source_url' => optional($source)->url,
                    ];
                });

        return $packages->toArray();
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'install_type' => InstallType::class,
        ];
    }

    /**
     * Nicely formatted version
     */
    protected function prettyVersion(): Attribute
    {
        return Attribute::make(
            get: fn () => Str::start($this->version, 'v'),
        );
    }

    /**
     * Nicely formatted name
     */
    protected function prettyName(): Attribute
    {
        $pretty_name = Str::of($this->name)
                        ->after('/')
                        ->headline();

        return Attribute::make(
            get: fn () => $pretty_name,
        );
    }

    protected function sushiShouldCache()
    {
        return true;
    }

    protected function sushiCacheReferencePath()
    {
        return base_path('/vendor/composer/installed.json');
    }
}
