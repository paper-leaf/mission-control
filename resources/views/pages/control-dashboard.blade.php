<x-filament-panels::page>
    {{-- {{ $this->infolist }} --}}

    {{-- @livewire('control-dashboard') --}}

    {{ $this->dashboardInfolist() }}
    {{-- {!! $this->dashboardInfolist(new \Filament\Schemas\Schema($this))->toHtml() !!} --}}

{{-- test

    <div class="grid grid-cols-6 gap-7">
        <x-filament::section class="col-span-6 lg:col-span-3 xl:col-span-2">
            <p class="font-bold mb-2">Site Environment</p>
            <code class="text-xl">{{ Str::title(config('app.env', 'not set')) }}</code>
        </x-filament::section>

        @if(@exec('echo EXEC') == 'EXEC')
            <x-filament::section class="col-span-6 xl:col-span-2">
                <p class="font-bold mb-2">Git Branch</p>
                <code class="text-xl">{{ exec('git branch --show-current') }}</code>
            </x-filament::section>
        @endif

        <x-filament::section class="col-span-6 lg:col-span-3 xl:col-span-2">
            <p class="font-bold mb-2">Jobs Queue</p>

            <div class="flex flex-col md:flex-row w-full md:justify-between">
                <code class="text-xl">{{ Str::title(config('queue.default', 'not set')) }}</code>
    
                <x-filament::link
                    href="/horizon"
                    tag="a"
                    target="_blank"
                    icon="heroicon-o-arrow-top-right-on-square"
                >
                    Horizon
                </x-filament::link>
            </div>
        </x-filament::section>

        <x-filament::section class="col-span-6 xl:col-span-3">
            <div class="flex flex-col xl:flex-row xl:items-center xl:justify-between gap-4 xl:gap-7">
                <div>
                    <p class="font-bold mb-2">Caching</p>
                    <code class="text-xl">{{ Str::upper(config('cache.default', 'not enabled')) }}</code>
                </div>

                <x-filament::button wire:click="clearCache">
                    Clear cache
                </x-filament::button>
            </div>
        </x-filament::section>

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
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 md:gap-7">
                <div>
                    <p class="font-bold mb-2">{{ Str::upper(config('mail.default', 'mail')) }}</p>
                    <code class="text-xl">{{  Str::upper(config('mail.host', 'not set')) }}</code>

                    <div class="flex items-center gap-2 mt-2">
                        <x-filament::badge color="gray">
                            From Address: {{ config('mail.from.name', 'not set') }}
                        </x-filament::badge>

                        <x-filament::badge color="gray">
                            From Name: {{ config('mail.from.address', 'not set') }}
                        </x-filament::badge>
                    </div>
                </div>

                <x-filament::button wire:click="sendTestEmail">
                    Send test email
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
                Key Package Versions
            </x-slot>

            <div class="flex flex-col gap-3 -mt-4 -mb-3">
                <p class="flex justify-between items-center border-b border-gray-200 py-2">
                    <span>Laravel Version</span>
                    <span>{{ composerVersion('laravel/framework') }}</span>
                </p>

                <p class="flex justify-between items-center border-b border-gray-200 py-2">
                    <span>Livewire Version</span>
                    <span>{{ composerVersion('livewire/livewire') }}</span>
                </p>

                <p class="flex justify-between items-center py-2">
                    <span>Filament Version</span>
                    <span>{{ composerVersion('filament/filament') }}</span>
                </p>
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
