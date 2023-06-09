<x-livewire-tables::table.cell class="align-middle text-center ">
    #{{ $row->id }}
</x-livewire-tables::table.cell>

<x-livewire-tables::table.cell class="align-middle ">
    {{ 'Subscription' }}
</x-livewire-tables::table.cell>

<x-livewire-tables::table.cell class="align-middle text-center">
    @if($row->status === \App\Enums\UserSubscriptionStatusEnum::active()->value)
        <span class="badge-success">
            {{ \App\Enums\UserSubscriptionStatusEnum::active()->label }}
        </span>
    @elseif($row->status === \App\Enums\UserSubscriptionStatusEnum::inactive()->value)
        <span class="badge-danger">
            {{ \App\Enums\UserSubscriptionStatusEnum::inactive()->label }}
        </span>
    @elseif($row->status === \App\Enums\UserSubscriptionStatusEnum::canceled()->value)
        <span class="badge-danger">
            {{ \App\Enums\UserSubscriptionStatusEnum::canceled()->label }}
        </span>
    @elseif($row->status === \App\Enums\UserSubscriptionStatusEnum::trial()->value)
        <span class="badge-info">
            {{ \App\Enums\UserSubscriptionStatusEnum::trial()->label }}
        </span>
    @elseif($row->status === \App\Enums\UserSubscriptionStatusEnum::active_until_end()->value)
        <span class="badge-warning">
            {{ \App\Enums\UserSubscriptionStatusEnum::active_until_end()->label }}
        </span>
    @endif
</x-livewire-tables::table.cell>

<x-livewire-tables::table.cell class="align-middle text-center">
    @if($row->status === \App\Enums\UserSubscriptionStatusEnum::trial()->value)
        <span class="badge-warning">
            {{ translate('Payment on: ').$row->end_date->format('d. M Y, H:i') }}
        </span>
    @else
        @if($row->payment_status === \App\Enums\PaymentStatusEnum::paid()->value)
            <span class="badge-success">
                {{ \App\Enums\PaymentStatusEnum::paid()->label }}
            </span>
        @elseif($row->payment_status === \App\Enums\PaymentStatusEnum::unpaid()->value)
            <span class="badge-danger">
                {{ \App\Enums\PaymentStatusEnum::unpaid()->label }}
            </span>
        @elseif($row->payment_status === \App\Enums\PaymentStatusEnum::canceled()->value)
            <span class="badge-dark">
                {{ \App\Enums\PaymentStatusEnum::canceled()->label }}
            </span>
        @elseif($row->payment_status === \App\Enums\PaymentStatusEnum::pending()->value)
            <span class="badge-info">
                {{ \App\Enums\PaymentStatusEnum::pending()->label }}
            </span>
        @endif
    @endif
    
</x-livewire-tables::table.cell>

<x-livewire-tables::table.cell class="hidden md:table-cell align-middle text-center">
    <strong class="text-14">1</strong>
</x-livewire-tables::table.cell>

<x-livewire-tables::table.cell class="hidden md:table-cell align-middle text-center">
    <strong class="text-14">{{ $row->getTotalUpcomingPrice() }}</strong><span class="text-14">{{ '/'.$row->order->invoicing_period }}</span>
</x-livewire-tables::table.cell>

<x-livewire-tables::table.cell class="hidden md:table-cell align-middle text-center">
    <strong class="text-14">{{ $row->getTotalPrice() }}</strong><span class="text-14">{{ '/'.$row->order->invoicing_period }}</span>
</x-livewire-tables::table.cell>

{{-- <x-livewire-tables::table.cell class="hidden md:table-cell align-middle text-center">
    @if(!empty($row->start_date))
        <span class="text-14">{{ $row->start_date->format('d. M Y, H:i') }}</span>
    @else
        -
    @endif
</x-livewire-tables::table.cell> --}}

<x-livewire-tables::table.cell class="hidden md:table-cell align-middle text-center">
    @if(!empty($row->end_date))
        @if($row->end_date->isPast())
            <span class="text-14 text-danger">{{ translate('Expired on ') . $row->end_date->format('d. M Y, H:i') }}</span>
        @else
            <span class="text-14">{{ translate('In ') . $row->end_date->diffInDays() . ' ' . translate('days') }}</span>
        @endif
    @else
        -
    @endif
</x-livewire-tables::table.cell>

@if(!$hideActions ?? true)
<x-livewire-tables::table.cell class="align-middle static ">
    <div class="flex static justify-center" role="group" x-data="{ isOpen: false }" x-cloak>
        {{-- <a class="btn btn-white flex items-center mr-2" href="#">
            @svg('heroicon-o-eye', ['class' => 'w-[18px] h-[18px] mr-2']) {{ translate('View') }}
        </a> --}}
        

        {{-- @if(($row->items->count() === 1 && ($row->items->first()?->pivot?->qty ?? null) === 1))
            <button type="button" class="btn btn-primary flex items-center mr-2 cursor-pointer" @click="$dispatch('display-modal', {id: 'purchase-subscription-with-multiple-items-modal'})" target="_blank">
                {{ translate('Change') }}
            </button>
        @elseif($row->items->count() > 1 || ($row->items->first()?->pivot?->qty ?? null) > 1)
            <button type="button" class="btn btn-primary flex items-center mr-2 cursor-pointer" @click="$dispatch('display-modal', {id: 'purchase-subscription-with-multiple-items-modal'})" target="_blank">
                {{ translate('Change') }}
            </button>
        @else
            <button type="button" class="btn btn-primary flex items-center mr-2 cursor-pointer" @click="$dispatch('display-modal', {id: 'purchase-subscription-with-multiple-items-modal'})" target="_blank">
                {{ translate('Change') }}
            </button>
        @endif --}}

        <button type="button" class="btn btn-primary flex items-center mr-2 cursor-pointer" @click="$dispatch('display-modal', {
            id: 'purchase-subscription-with-multiple-items-modal',
            interval: @js($row->order->invoicing_period),
            plan_id: @js($row->items->first()?->id),
            plan_slug: @js($row->items->first()?->slug),
            qty: 1,
            month_price: @js($row->items->first()?->getTotalPrice(display: true, decimals: 0) ?? 0),
            annual_price: @js(\FX::formatPrice(($row->items->first()?->getTotalAnnualPrice(display: false) ?? 0) / 12, 0)),
        })">
            {{ translate('Change') }}
        </button>

        

        

        {{-- @if(!get_tenant_setting('multi_item_subscription_enabled'))
            <button 
                @click="isOpen = !isOpen" 
                @keydown.escape="isOpen = false" 
                class="flex items-center btn" 
            >
                @svg('heroicon-o-chevron-down', ['class' => 'w-[18px] h-[18px]'])
            </button>
            <ul x-show="isOpen"
                @click.away="isOpen = false"
                class="absolute bg-white z-10 list-none p-0 border rounded mt-10 shadow"
            >
                @if($row->status === \App\Enums\UserSubscriptionStatusEnum::active()->value)
                    <!-- Only if subscription plan is active, user can upgrade/downgrade or cancel it! -->

                    <li>
                        <a href="{{ $row?->getSingleCheckoutPermalink() ?? '#' }}" target="_blank" class="flex items-center px-3 py-3 pr-4 text-gray-900 text-14">
                            @svg('heroicon-o-arrow-circle-up', ['class' => 'w-[18px] h-[18px]'])
                            <span class="ml-2">{{ translate('Upgrade Plan') }}</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ $row?->getSingleCheckoutPermalink() ?? '#' }}" target="_blank" class="flex items-center px-3 py-3 pr-4 text-gray-900 text-14">
                            @svg('heroicon-o-arrow-circle-down', ['class' => 'w-[18px] h-[18px]'])
                            <span class="ml-2">{{ translate('Downgrade Plan') }}</span>
                        </a>
                    </li>

                
                    <li>
                        <div wire:click="cancelPlan({{ $row->id }})" class="flex items-center px-3 py-3 pr-4 text-gray-900 text-14  border-t cursor-pointer">
                            @svg('heroicon-o-trash', ['class' => 'text-danger w-[18px] h-[18px]'])
                            <span class="ml-2">{{ translate('Cancel plan') }}</span>
                        </div>
                    </li>
                @elseif($row->status === \App\Enums\UserSubscriptionStatusEnum::active_until_end()->value && $row->payment_status === \App\Enums\PaymentStatusEnum::paid()->value && $row->end_date > time())
                    <!-- If there's still time left before 'end_date', subscription payment is 'paid' and status is 'active_until_end', you can revive subscription cuz it's not fully canceled in Stripe (cancel_at_period_end is just set to true)  -->
                    <li>
                        <div wire:click="revivePlan({{ $row->id }})" class="flex items-center px-3 py-3 pr-4 text-gray-900 text-14  border-t cursor-pointer">
                            @svg('heroicon-o-arrow-path', ['class' => 'text-info w-[18px] h-[18px]'])
                            <span class="ml-2">{{ translate('Revive plan') }}</span>
                        </div>
                    </li>
                @endif
            </ul>
        @endif --}}
        
    </div>
</x-livewire-tables::table.cell>
@endif