<?php

namespace PaperLeaf\MissionControl\Widgets;

use Livewire\Attributes\Computed;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

use PaperLeaf\MissionControl\Extends\BaseWidget;

class DatabaseWidget extends BaseWidget
{
    public string $icon = 'heroicon-o-circle-stack';
    public string $heading = 'Database';

    #[Computed]
    private function data()
    {
        $driver = DB::connection()->getDriverName();

        $version = match($driver) {
            'mysql'  => DB::select('select version() as version')[0]->version,
            'pgsql'  => DB::select('select version() as version')[0]->version,
            'sqlite' => DB::select('select sqlite_version() as version')[0]->version,
            'sqlsrv' => DB::select('SELECT @@VERSION as version')[0]->version,
            default  => 'Unknown',
        };

        // PostgreSQL and SQL Server return long strings; this extracts just the version number
        if ($driver === 'pgsql') {
            preg_match('/PostgreSQL ([\d\.]+)/', $db_version, $matches);
            $db_version = $matches[1] ?? $db_version;
        }

        // Check if bin logs are enabled
        $result = DB::select("SHOW VARIABLES LIKE 'log_bin'");
        $is_bin_log_enabled = !empty($result) && $result[0]->Value === 'ON';

        return [
            'Database Name' => DB::connection()->getDatabaseName(),
            'Database Driver' => $driver,
            'DB Version' => $version,
            'Bin Logs Enabled?' => ($is_bin_log_enabled) ? 'Yes' : 'No',
        ];
    }
}