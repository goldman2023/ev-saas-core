{{-- Order Information --}}
<div class="p-4 border bg-white border-gray-200 rounded-lg shadow mb-5"
@if(empty($order->id))
    x-init="wef.cycle_status = {{ $default_cycle_status_value }};"
@else
    {{-- TODO: find a better way to set cycle_status for order updating... --}}
    x-init="wef.cycle_status = {{ $current_cycle_status_value }};"
@endif
>
    <div class="w-full flex justify-between items-center flex-wrap">


        @if(!empty($order->id))

            @if($next_cycle_status_label)
                <a type="button" href="{{ route('dashboard.order.change-status', $order->id) }}" class="w-full mb-3 btn-primary">
                    {{ translate('Next step') }}
                    @svg('heroicon-s-chevron-right', ['class' => 'w-5 h-5 ml-2'])
                </a>
            @endif

            <h3 class="flex items-center gap-x-2">
                <span class="text-md leading-6 font-400 text-gray-900">{{ translate('Cycle status') }}: </span>
                <span class="text-md bg-gray-100 leading-6 font-medium text-gray-900 border px-2 py-1 rounded-md">{{ $current_cycle_status_label }}</span>
            </h3>

            <div class="w-full flex gap-x-1 text-16 items-center flex-[1_0_100%] mt-1 justify-between flex-wrap">
                <p class="flex items-center text-sm text-gray-700">
                    @svg('heroicon-o-calendar-days', ['class' => 'mr-1.5 h-5 w-5 flex-shrink-0 text-gray-600'])
                    @if($current_cycle_status_date !== $order->created_at->timestamp)
                        {{ $current_cycle_status_label.' '.translate('at: ') }} {{ date('d M, Y H:i', $current_cycle_status_date) }}
                    @else
                        {{ translate('Created at: ') }} {{ date('d M, Y H:i', $current_cycle_status_date) }}
                    @endif
                </p>

                @if($next_cycle_status_label)
                    <p class="mt-1">
                        {{ translate('Next cycle step is:') }}
                        <b>{{ $next_cycle_status_label }}</b>
                    </p>
                @endif
            </div>
        @endif

        <x-dashboard.form.input type="number" min="0" field="wef.cycle_status" :x="true" class="hidden" />
    </div>

    <div class="w-full">

    </div>
</div>
