<x-livewire-tables::table.cell class="align-middle text-center">
<a href="{{ route('user.details', $row->user->id) }}">
    {{ $row->user->email }} <br>

    @isset($row->plan)
        {{ $row->plan->name }}
    @else
        {{ translate('No Plan') }}
    @endisset
</a>
</x-livewire-tables::table.cell>

<x-livewire-tables::table.cell class="align-middle text-center">
    @isset($row->data['cloud_service'])
    @if($row->data['cloud_service'] == 1)
        @svg('heroicon-o-check', ['class' => 'h-4 inline w-4 text-green-600'])
    @else
        @svg('heroicon-o-x', ['class' => 'h-4 inline w-4 text-red-600'])
    @endif
    @endisset

</x-livewire-tables::table.cell>

<x-livewire-tables::table.cell class="align-middle text-center">
    @isset($row->data['offline_service'])

    @if($row->data['offline_service'] == 1)
        @svg('heroicon-o-check', ['class' => 'text-center inline h-4 w-4 text-green-600'])
    @else
        @svg('heroicon-o-x', ['class' => 'text-center inline h-4 w-4 text-red-600'])
    @endif
    @endisset

</x-livewire-tables::table.cell>

<x-livewire-tables::table.cell class="align-middle  text-center">
    {{ empty($row?->serial_number ?? null) ? translate('Generating...') : ($row?->serial_number ?? '') }}
</x-livewire-tables::table.cell>

@do_action('view.dashboard.row-license.columns', $row)

<x-livewire-tables::table.cell class="align-middle  text-center">
    @isset($row->user_subscription)
    @if(!empty($row->user_subscription->first()?->end_date ?? false))
    @if($row->user_subscription->first()->end_date < now())
    <span class="text-red-600">  Expired:
    @endif

        {{ $row->user_subscription->first()->end_date->format('d. M Y, H:i') }}

        @if($row->user_subscription->first()->end_date < now())
    </span>
    @endif
    @elseif(!empty($row->getData('expiration_date')))
        @if($row->getData('expiration_date') < now())
        <span class="text-red-600"> Expired:
        @endif
        {{ \Carbon::createFromFormat('Y-m-d H:i:s', $row->getData('expiration_date'))->format('d. M Y, H:i') }}

        @if($row->getData('expiration_date') < now())
        </span>
        @endif
    @else
        -
    @endif
    @endisset
</x-livewire-tables::table.cell>

@if(auth()->user()->isAdmin())
    <x-livewire-tables::table.cell class="align-middle static ">
        <div class="flex static justify-center" role="group" x-data="{ isOpen: false }" x-cloak>
            @do_action('view.dashboard.plans.row-license.actions.start', $row)

            <button
                @click="isOpen = !isOpen"
                @keydown.escape="isOpen = false"
                class="flex items-center btn"
            >
                @svg('heroicon-o-chevron-down', ['class' => 'w-[18px] h-[18px]'])
            </button>
            <ul x-show="isOpen"
                @click.away="isOpen = false"
                class="absolute bg-white z-10 list-none p-0 border rounded mt-10 shadow overflow-hidden"
            >
                @do_action('view.dashboard.plans.row-license.actions.dropdown.start', $row)

            </ul>
        </div>
    </x-livewire-tables::table.cell>
@endif
