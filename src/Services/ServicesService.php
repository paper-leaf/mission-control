<?php

namespace PaperLeaf\MissionControl\Services;

use Illuminate\Support\Facades\Process;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;
use Composer\InstalledVersions;

use PaperLeaf\MissionControl\Models\Enums\ServiceStatus;

class ServicesService
{
    /**
     * Get the version of a specific package installed via Composer
     * 
     * @param string $package_name
     * @return string
     */
    public function composerVersion($package_name)
    {
        return $this->checkPackage($package_name)['version'];
    }

    /**
     * Check if a composer package is even installed
     * 
     * @param string $package_name
     * @return bool
     */
    public function composerInstalled($package_name)
    {
        return $this->checkPackage($package_name)['installed'];
    }

    /**
     * Run an Artisan command
     * 
     * @param string $command
     * @param bool (optional) $return_output
     * @return string
     */
    public function runArtisan($command, $return_output = false)
    {
        $exit_code = Artisan::call($command);

        if($return_output) {
            $output = Artisan::output();
            return $output;
        }
    }

    /**
     * Run a bash/shell command
     * 
     * @param string $command
     * @return string
     */
    public function runSystemCommand($command)
    {
        // 1. Run a basic system command
        $result = Process::run($command);

        // 2. Check if the process completed successfully
        if ($result->successful()) {
            return $result->output();
        }

        return $result->errorOutput();
    }

    /**
     * Check a composer package
     * 
     * @param string $package_name
     * @return array
     */
    public function checkPackage($package_name)
    {
        // Check if the package is installed anywhere in the project
        if (InstalledVersions::isInstalled($package_name)) {
            return [
                'installed' => true,
                'version' => InstalledVersions::getPrettyVersion($package_name),
            ];
        }

        return [
            'installed' => false,
            'version' => null,
        ];
    }

    /**
     * Run a Composer command
     * 
     * @param string $command
     * @return string
     */
    public function runComposer($command)
    {
        // Check if the package is installed anywhere in the project
        if (InstalledVersions::isInstalled('laravel/horizon')) {
            return response()->json([
                'installed' => true,
                'pretty_version' => InstalledVersions::getPrettyVersion($package_name),
            ]);
        }

        return response()->json([
            'installed' => false,
            'message' => 'Package laravel/horizon is not installed.'
        ], 404);
    }

    /*********************************************
     * PACKAGE STATUSES
     *********************************************/

    /**
     * Check if a package is installed
     * 
     * @param string $package_name
     * @return bool
     */
    public function isInstalled($package_type, $package_name) {
        switch($package_type) {
            case 'composer': 
                return $this->composerInstalled($package_name);
                break; 

            default: 

                // dd($test);


                // $function_name = sprintf("is%sInstalled", ucfirst($package));

                // if (method_exists($this, $function_name)) {
                //     return $this->{$function_name}();
                // }

                // return false;

                return false;
                break;
        }        


    }

    /*********************************************
     * SPECIFIC PACKAGE CHECKS
     *********************************************/

    /**
     * Get the current status of Horizon
     * 
     * @return string
     */
    public function horizonStatus()
    {
        return $this->runArtisan('horizon:status');
    }






        // // Get the list of installed packages from composer
        // $packages = optional(json_decode(file_get_contents('../vendor/composer/installed.json')))->packages;
        // if (!isset($packages)) {
        //     return 0;
        // }

        // // Search for the package that was provided
        // $package = collect($packages)->firstWhere('name', $package_name);
        // if (!isset($package) && !isset($package->version)) {
        //     return 0;
        // }

        // // Return the version!
        // return $package->version;
}
