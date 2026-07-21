<?php

namespace PaperLeaf\MissionControl\Widgets;

use Livewire\Attributes\Computed;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Process;

use PaperLeaf\MissionControl\Extends\BaseWidget;

class DeploymentWidget extends BaseWidget
{
    public string $icon = 'heroicon-o-cloud-arrow-up';
    public string $heading = 'Deployments';

    #[Computed]
    private function data()
    {
        $result = Process::run('which forge');
        $has_forge_cli = $result->successful() && !empty(trim($result->output()));
        if($has_forge_cli) {
            $deployment_type = 'Laravel Forge';
        }
        elseif(config('app.env') == 'local') {
            $deployment_type = 'Local, N/A';
        }
        else {
            $deployment_type = 'Manual or Other';
        }

        return [
            'Deployment Type' => $deployment_type,
            'Git Branch' => exec('git branch --show-current'),
        ];
    }
}