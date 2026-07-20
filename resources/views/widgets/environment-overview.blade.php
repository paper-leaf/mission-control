<x-filament-widgets::widget>
    <x-filament::section>
        <div class="flex items-center gap-x-3">
            <x-filament-panels::avatar.user size="lg" :user="$this->user" />

            <div class="flex-1">
                <p class="text-base font-semibold leading-6 text-gray-950">
                    Welcome back, {{ $this->user->myName() }}!
                </p>

                <p class="text-sm text-gray-500">
                    You belong to the <b>{{ optional($this->user_group)->label }}</b> user group.
                </p>

                @if(optional($this->user_group)->id != optional($this->viewing_group)->id)
                    <p class="text-sm italic flex flex-row gap-1 mt-2 bg-orange-100 p-2 rounded-lg w-fit">
                        <x-filament::icon
                            icon="heroicon-s-information-circle"
                            color="warning"
                            class="h-5 w-5 text-orange"
                        />

                        You are currently viewing the system as a member of the <b>{{ optional($this->viewing_group)->label }}</b> user group.
                    </p>
                @endif
            </div>

            <form
                action="{{ filament()->getLogoutUrl() }}"
                method="post"
                class="my-auto"
            >
                @csrf

                <x-filament::button
                    color="gray"
                    icon="heroicon-m-arrow-left-on-rectangle"
                    icon-alias="panels::widgets.account.logout-button"
                    labeled-from="sm"
                    tag="button"
                    type="submit"
                >
                    {{ __('filament-panels::widgets/account-widget.actions.logout.label') }}
                </x-filament::button>
            </form>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
