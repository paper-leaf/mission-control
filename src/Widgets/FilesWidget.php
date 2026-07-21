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
    
    public bool $has_primary_action = false;
    // public string $primary_action_label = 'Send Test';

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

            // ?prefix=%s%%2F

            // 

            $links['View Files in S3'] = $s3_url;
        }

        return $links;
    }
}



// <x-filament::section class="col-span-6">
//             @php $filesystem = config('filesystems.default', 'local'); @endphp

//             <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 md:gap-7">
//                 <div>

//                     @if($filesystem == 's3') 
//                         @php 
//                             $bucket = config('filesystems.disks.s3.bucket', 'not set');
//                             $region = config('filesystems.disks.s3.region', 'not set');
//                         @endphp
//                         <div class="flex items-center gap-2 mt-2">
//                             <x-filament::badge color="gray">Region: {{ $region }}</x-filament::badge>
//                             <x-filament::badge color="gray">Bucket: {{ $bucket }}</x-filament::badge>
//                         </div>
//                     @endif
//                 </div>

//                 @if($filesystem == 's3')
//                     <x-filament::button     
//                         href="https://{{ $region }}.console.aws.amazon.com/s3/buckets/{{ $bucket }}?prefix={{ Str::upper(config('app.env', 'not set')) }}%2F"
//                         icon="heroicon-o-arrow-top-right-on-square"
//                         tag="a"
//                         target="_blank"
//                     >
//                         View Files
//                     </x-filament::button>
//                 @endif
//             </div>
//         </x-filament::section>
