<x-filament-panels::page>
    {{ $this->dashboardInfolist() }}



{{-- 
        <x-filament::section class="col-span-6 xl:col-span-3">
            <div class="flex flex-col xl:flex-row xl:items-center xl:justify-between gap-4 xl:gap-7">
                <div>
                    <p class="font-bold mb-2">Notifications</p>
                    <code class="text-xl">In-System</code>
                </div>

                <x-filament::button wire:click="sendTestNotification">
                    Send test
                </x-filament::button>
            </div>
        </x-filament::section>

        <x-filament::section class="col-span-6">
            @php $filesystem = config('filesystems.default', 'local'); @endphp

            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 md:gap-7">
                <div>
                    <p class="font-bold mb-2">File Storage</p>
                    <code class="text-xl">
                        {{ ($filesystem == 's3') ? 'AWS S3' : Str::upper($filesystem) }}
                    </code>

                    @if($filesystem == 's3') 
                        @php 
                            $bucket = config('filesystems.disks.s3.bucket', 'not set');
                            $region = config('filesystems.disks.s3.region', 'not set');
                        @endphp
                        <div class="flex items-center gap-2 mt-2">
                            <x-filament::badge color="gray">Region: {{ $region }}</x-filament::badge>
                            <x-filament::badge color="gray">Bucket: {{ $bucket }}</x-filament::badge>
                        </div>
                    @endif
                </div>

                @if($filesystem == 's3')
                    <x-filament::button     
                        href="https://{{ $region }}.console.aws.amazon.com/s3/buckets/{{ $bucket }}?prefix={{ Str::upper(config('app.env', 'not set')) }}%2F"
                        icon="heroicon-o-arrow-top-right-on-square"
                        tag="a"
                        target="_blank"
                    >
                        View Files
                    </x-filament::button>
                @endif
            </div>
        </x-filament::section>

        <x-filament::section class="col-span-6 lg:col-span-3">
            <x-slot name="heading">
                PHP Details
            </x-slot>

            <div class="flex flex-col gap-3 -mt-4 -mb-3">
                <p class="flex justify-between items-center border-b border-gray-200 py-2">
                    <span>PHP Version</span>
                    <span>v{{ phpversion() }}</span>
                </p>

                <p class="flex justify-between items-center border-b border-gray-200 py-2">
                    <span>Memory Limit</span>
                    <span>{{ ini_get('memory_limit') }}</span>
                </p>

                <p class="flex justify-between items-center border-b border-gray-200 py-2">
                    <span>Max Execution Time</span>
                    <span>{{ ini_get('max_execution_time') }}s</span>
                </p>

                <p class="flex justify-between items-center py-2">
                    <span>Max File Upload Size</span>
                    <span>{{ ini_get('upload_max_filesize') }}</span>
                </p>
            </div>
        </x-filament::section>
    </div> --}}
</x-filament-panels::page>
