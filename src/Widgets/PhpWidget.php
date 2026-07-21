<?php

namespace PaperLeaf\MissionControl\Widgets;

use Livewire\Attributes\Computed;
use Illuminate\Support\Str;

use PaperLeaf\MissionControl\Extends\BaseWidget;

class PhpWidget extends BaseWidget
{
    public string $icon = 'heroicon-o-cog-6-tooth';
    public string $heading = 'PHP';

    #[Computed]
    private function data()
    {
        return [
            'Version' => sprintf('v%s', phpversion()),
            'Memory Limit' => ini_get('memory_limit'),
            'Max Execution Time' => sprintf('%ss', ini_get('max_execution_time')),
            'Max File Upload Size' => ini_get('upload_max_filesize'),
        ];
    }
}