<?php

namespace PaperLeaf\MissionControl\Widgets;

use Livewire\Attributes\Computed;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Process;

use PaperLeaf\MissionControl\Extends\BaseWidget;

class ServerWidget extends BaseWidget
{
    public string $icon = 'heroicon-o-cpu-chip';
    public string $heading = 'Server';

    #[Computed]
    private function data()
    {
        $os = PHP_OS_FAMILY;

        $name = match($os) {
            'Darwin' => 'MacOS',
            default => $os
        };

        $version = match($os) {
            'Linux'   => trim(Process::run("grep 'VERSION_ID=' /etc/os-release | cut -d'=' -f2 | tr -d '\"'")->output()) ?: php_uname('r'),
            'Windows' => sprintf('%s.%s', PHP_WINDOWS_VERSION_MAJOR, PHP_WINDOWS_VERSION_MINOR),
            'Darwin'  => trim(Process::run('sw_vers -productVersion')->output()),
            default   => php_uname('r'),
        };

        $result = Process::run('which logrotate');
        $has_log_rotate = $result->successful() && !empty(trim($result->output()));

        $result = Process::run('docker --version');
        $has_docker = $result->successful();
        $docker_version = 'N/A';
        if ($has_docker) {
            preg_match('/version\s([\d\.]+)/i', $result->output(), $matches);
            $docker_version = $matches[1] ?? 'Installed';

            $status_check = Process::run('systemctl is-active docker');
            $is_docker_running = trim($status_check->output()) === 'active';
            $docker_status = ($is_docker_running) ? 'Running' : 'Inactive';

            $docker_version = "{$docker_version} ({$docker_status})";
        }

        $total_space = disk_total_space(base_path()); // Total bytes
        $free_space  = disk_free_space(base_path());  // Free bytes

        // Convert bytes to Gigabytes (GB) for scannability
        $total_gb = round($total_space / (1024 ** 3), 2);
        $free_gb  = round($free_space / (1024 ** 3), 2);

        return [
            'Operating System' => $name,
            'OS Version' => $version,
            'Web Server' => request()->server('SERVER_SOFTWARE'),
            'Remaining Disk Space' => "{$free_gb}G / {$total_gb}G",
            'Log Rotate Enabled?' => ($has_log_rotate) ? 'Yes' : 'No',
            'Docker' => $docker_version
        ];
    }
}