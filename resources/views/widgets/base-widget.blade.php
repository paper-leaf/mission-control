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

        @switch(true)
            @case(is_array($this->data))
                @if(count($this->data) > 0)
                    <div class="flex flex-col gap-3 -mt-4 -mb-3">
                        @foreach($this->data() as $label => $data)
                            <p class="
                                flex justify-between items-center py-2
                                @if(!$loop->last) border-b border-gray-200 @endif
                            ">
                                <span class="text-sm">{{ $label }}</span>
                                <code>{{ $data }}</code>
                            </p>
                        @endforeach
                    </div>
                @endif
                @break

            @case(is_string($this->data))
                <code class="text-2xl">{{ $this->data }}</code>
                @break
        @endswitch

        @if(isset($this->links) && is_array($this->links) && count($this->links) > 0)
            <div class="flex items-start gap-2 flex-col md:flex-row mt-3">
                @foreach($this->links as $label => $href)
                    <x-filament::link
                        href="{{ $href }}"
                        tag="a"
                        target="_blank"
                        icon="heroicon-o-arrow-top-right-on-square"
                        class="flex items-start w-content"
                    >
                        {{ $label }}
                    </x-filament::link>
                @endforeach
            </div>
        @endif
    </x-filament::section>
</x-filament-widgets::widget>
