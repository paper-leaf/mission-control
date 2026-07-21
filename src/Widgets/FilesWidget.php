<?php

namespace PaperLeaf\MissionControl\Widgets;

use Livewire\Attributes\Computed;
use Illuminate\Support\Str;

use Filament\Notifications\Notification;
use PaperLeaf\MissionControl\Notifications\TestEmail;

use PaperLeaf\MissionControl\Extends\BaseWidget;

class FilesWidget extends BaseWidget
{
    public string $icon = 'heroicon-o-folder';
    public string $heading = 'File Storage';
    
    #[Computed]
    private function filesystem() {
        return config('filesystems.default', 'local');
    }

    #[Computed]
    private function awsBucket() {
        return config('filesystems.disks.s3.bucket', 'not set');
    }

    #[Computed]
    private function awsRegion() {
        return config('filesystems.disks.s3.region', 'not set');
    }

    #[Computed]
    private function data()
    {
        $data = [];
        $data['File System'] = ($this->filesystem == 's3') ? 'AWS S3' : Str::upper($this->filesystem);

        if($this->filesystem == 's3') {
            $data['Region'] = $this->aws_region;
            $data['Bucket'] = $this->aws_bucket;
        }

        return $data;
    }

    #[Computed]
    private function links()
    {
        $links = [];

        if($this->filesystem == 's3') {
            $s3_url = "https://{$this->aws_region}.console.aws.amazon.com/s3/buckets/{$this->aws_bucket}";
            $prefix = config('mission-control.file_storage.aws_folder_prefix');

            if(isset($prefix)) {
                $s3_url = "{$s3_url}?prefix={$prefix}%2F";
            }

            $links['View Files in S3'] = $s3_url;
        }

        return $links;
    }
}
