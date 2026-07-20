<x-filament-widgets::widget>
    <x-filament::section
        icon="{{ $this->icon }}"
        icon-color="primary"
        icon-size="md"
    >
        <x-slot name="heading">
            {{ $this->heading }}
        </x-slot>

        @if(isset($this->has_primary_action) && $this->has_primary_action)
            <x-slot name="afterHeader">
                <x-filament::button wire:click="primaryAction">
                    {{ $this->primary_action_label }}
                </x-filament::button>
            </x-slot>
        @endif

        @if(count($this->data()) > 0)
            <div class="flex flex-col gap-3 -mt-4 -mb-3">
                @foreach($this->data() as $label => $data)
                    <p class="
                        flex justify-between items-center py-2
                        @if(!$loop->last) border-b border-gray-200 @endif
                    ">
                        <span>{{ $label }}</span>
                        <span>{{ $data }}</span>
                    </p>
                @endforeach
            </div>
        @endif
    </x-filament::section>
</x-filament-widgets::widget>
