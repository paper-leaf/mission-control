<x-filament-widgets::widget>
    <x-filament::section>
        <div class="flex flex-col md:flex-row gap-3 md:gap-7">
            <x-filament::section class="fi-compact !bg-primary-100 hidden md:block">
                <x-filament::icon
                    icon="heroicon-o-rocket-launch"
                    class="w-12 h-12"
                />
            </x-filament::section>

            <div class="flex flex-col gap-2 justify-center">
                <b class="font-bold text-xl">
                    {{ config('app.name', 'not set') }}
                </b>
                <div class="flex flex-col md:flex-row gap-2">
                    <x-filament::badge color="info">
                        Environment: <code>{{ Str::title(config('app.env', 'not set')) }}</code>
                    </x-filament::badge>

                    @if(@exec('echo EXEC') == 'EXEC')
                        <x-filament::badge color="info">
                            Git Branch: <code>{{ exec('git branch --show-current') }}</code>
                        </x-filament::badge>
                    @endif

                </div>
            </div>
        </div>
        
        <div class="mt-4 grid grid-cols-3 gap-4 md:gap-7">
            <x-filament::section class="col-span-3 md:col-span-1 fi-compact">
                <div class="flex flex-row justify-between items-center gap-2">
                    <b class="text-xs block">Laravel</b>
                    <code class="text-sm">{{ $this->packages->composerVersion('laravel/framework') }}</code>
                </div>
            </x-filament::section>

            <x-filament::section class="col-span-3 md:col-span-1 fi-compact">
                <div class="flex flex-row justify-between items-center gap-2">
                    <b class="text-xs block">Filament</b>
                    <code class="text-sm">{{ $this->packages->composerVersion('filament/filament') }}</code>
                </div>
            </x-filament::section>

            <x-filament::section class="col-span-3 md:col-span-1 fi-compact">
                <div class="flex flex-row justify-between items-center gap-2">
                    <b class="text-xs block">Livewire</b>
                    <code class="text-sm">{{ $this->packages->composerVersion('livewire/livewire') }}</code>
                </div>
            </x-filament::section>
        </div>

    </x-filament::section>
</x-filament-widgets::widget>
