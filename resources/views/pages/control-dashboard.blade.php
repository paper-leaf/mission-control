<x-filament-panels::page>
    {{ $this->dashboardInfolist() }}



{{-- 
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
