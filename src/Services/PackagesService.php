<?php

namespace PaperLeaf\MissionControl\Services;

class PackagesService
{
    /**
     * Get the version of a specific package installed via Composer
     * 
     * @return string
     */
    function composerVersion($package_name)
    {
        // Get the list of installed packages from composer
        $packages = optional(json_decode(file_get_contents('../vendor/composer/installed.json')))->packages;
        if (!isset($packages)) {
            return 0;
        }

        // Search for the package that was provided
        $package = collect($packages)->firstWhere('name', $package_name);
        if (!isset($package) && !isset($package->version)) {
            return 0;
        }

        // Return the version!
        return $package->version;
    }
}
