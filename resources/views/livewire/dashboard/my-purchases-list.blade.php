@push('head_scripts')
    <link href="https://calendly.com/assets/external/widget.css" rel="stylesheet">
    <script src="https://calendly.com/assets/external/widget.js" type="text/javascript"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/add-to-calendar-button@1.8/assets/css/atcb.min.css">
    <script src="https://cdn.jsdelivr.net/npm/add-to-calendar-button@1.8" defer></script>
@endpush

<div class="w-full">
    <div class="w-full flex flex-wrap justify-between items-center mb-5">
        <div class="">
            <span>{{ translate('Total number of owned assets') }}:</span>
            <strong>{{ $count }}</strong>
        </div>
        <div class="mt-1 relative flex items-center">
          <input type="text" name="search" id="search" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full pr-12 sm:text-sm border-gray-300 rounded-md">
          <div class="absolute inset-y-0 right-0 flex py-1.5 pr-1.5">
            <button type="button" class="cursor-pointer inline-flex items-center border border-gray-200 rounded px-2 text-sm font-sans font-medium text-gray-400"> 
                {{ translate('Search') }} 
            </button>
          </div>
        </div>
    </div>

    <div class="w-full flex flex-col space-y-8 lg:px-0">

        @if($items?->isNotEmpty() ?? null)
            @foreach($items as $item)
                <div class="bg-white border-t border-b border-gray-200 shadow-sm sm:rounded-lg sm:border" x-data="{
                    ownership_id: {{ $item->id }},
                }">
                    <div class="flex items-center p-4 border-b border-gray-200 sm:p-6 sm:grid sm:grid-cols-4 sm:gap-x-6">
                        <dl class="flex-1 grid grid-cols-2 gap-x-6 text-sm sm:col-span-3 sm:grid-cols-3 lg:col-span-2">
                            <div>
                                <dt class="font-medium text-gray-900">{{ translate('Asset type') }}</dt>
                                <dd class="mt-1 text-sky-500">{{ \App\Enums\ProductTypeEnum::getLabel($item->subject->type) }}</dd>
                            </div>
                            <div class="hidden sm:block">
                                <dt class="font-medium text-gray-900">{{ translate('Date purchased') }}</dt>
                                <dd class="mt-1 text-gray-500">
                                    <time datetime="2021-07-06">{{ $item->created_at->format('d M, Y') }}</time>
                                </dd>
                            </div>
                            <div>
                                <dt class="font-medium text-gray-900">{{ translate('Amount') }}</dt>
                                <dd class="mt-1 font-medium text-gray-900">{{ \FX::formatPrice($item->getOrderItem()?->total_price ?? 0)  }}</dd>
                            </div>
                        </dl>

                        <div class="relative flex justify-end lg:hidden">
                            <div class="flex items-center">
                                <button type="button" class="-m-2 p-2 flex items-center text-gray-400 hover:text-gray-500" id="menu-0-button" aria-expanded="false" aria-haspopup="true">
                                    @svg('heroicon-o-dots-vertical', ['class' => 'w-6 h-6'])
                                </button>
                            </div>
                        </div>

                        <div class="hidden lg:col-span-2 lg:flex lg:items-center lg:justify-end lg:space-x-4">
                            <a href="{{ route('order.details', ['id' => $item->order_id]) }}" class="flex items-center justify-center bg-white py-2 px-2.5 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                <span>{{ translate('View Order') }}</span>
                            </a>
                            <a href="{{ route('order.details', ['id' => $item->order_id]) }}" class="flex items-center justify-center bg-white py-2 px-2.5 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                <span>{{ translate('View Invoice') }}</span>
                            </a>
                        </div>
                    </div>

                    <!-- Owned Product -->
                    <ul role="list" class="divide-y divide-gray-200">
                        @if(!empty($item->subject))
                            <li class="p-4 sm:p-6" x-data="{
                                notify_owner_when_updated: {{ $item->notify_owner_when_updated === true ? 'true':'false' }},
                            }" x-init="$watch('notify_owner_when_updated', (value) => {
                                $wire.setNotifyOnUpdate(ownership_id, value);
                            })">
                                <div class="flex items-center sm:items-start">
                                    <div class="flex-shrink-0 w-20 h-20 bg-gray-200 rounded-lg overflow-hidden sm:w-40 sm:h-40">
                                        <img src="{{ $item->subject?->getThumbnail() ?? '' }}" class="w-full h-full object-center object-cover">
                                    </div>
                                    <div class="flex-1 ml-6 text-sm flex flex-col">
                                        <div class="font-medium text-gray-900 sm:flex sm:justify-between">
                                            <h5 class="text-15">{{ $item->subject?->name ?? '' }}</h5>
                                        </div>
                                        <p class="hidden text-gray-500 sm:block sm:mt-2">{{ $item->subject?->excerpt ?? '' }}</p>
                                        <div class="w-full">
                                            @if($item->subject->type === \App\Enums\ProductTypeEnum::standard()->value)
                                                <a href="#" type="button" class="btn-primary mt-4">
                                                    {{ translate('Track shipment') }}
                                                </a>
                                            @elseif($item->subject->type === \App\Enums\ProductTypeEnum::digital()->value)
                                                <a href="#" type="button" class="btn-primary mt-4">
                                                    {{ translate('Download') }}
                                                </a>
                                            @elseif($item->subject->type === \App\Enums\ProductTypeEnum::bookable_service()->value)
                                                <button type="button" class="btn-primary" @click="Calendly.showPopupWidget('{{ $item->subject->getBookingLink() }}');">
                                                    {{ translate('Schedule a meeting') }}
                                                </button>
                                            @elseif($item->subject->type === \App\Enums\ProductTypeEnum::event()->value)
                                                @if($item->subject->getCoreMeta('location_type') === 'remote')
                                                    @php
                                                        $location_link = $item->subject->getCoreMeta('location_link');
                                                        $default_1h_diff = $item->subject->getCoreMeta('start_date') + 3600;
                                                    @endphp
                                                    <div class="atcb" style="display:none;">
                                                        {
                                                            "name":"{{ $item->subject->name }}",
                                                            "description":"{{ $item->subject->excerpt }}",
                                                            "startDate":"{{ date('Y-m-d', $item->subject->getCoreMeta('start_date')) }}",
                                                            @if($item->subject->getCoreMeta('date_type') == 'range') 
                                                                "endDate":"{{ date('Y-m-d', $item->subject->getCoreMeta('end_date')) }}",
                                                            @else
                                                                "endDate":"{{ date('Y-m-d', $default_1h_diff) }}",
                                                            @endif

                                                            "startTime":"{{ date('H:i', $item->subject->getCoreMeta('start_date')) }}",
                                                            
                                                            @if($item->subject->getCoreMeta('date_type') == 'range') 
                                                                "endTime":"{{ date('H:i', $item->subject->getCoreMeta('end_date')) }}",
                                                            @else
                                                                "endTime":"{{ date('H:i', $default_1h_diff) }}",
                                                            @endif
                                                            "location":"{{ $item->subject->getCoreMeta('location_link') ?? ' ' }}",
                                                            "label":"{{ translate('Add to Calendar') }}",
                                                            "options":[
                                                                "Apple",
                                                                "Google",
                                                                "iCal",
                                                                "Microsoft365",
                                                                "MicrosoftTeams",
                                                                "Outlook.com",
                                                                "Yahoo"
                                                            ],
                                                            "timeZone":"{{ date_default_timezone_get() }}",
                                                            {{-- "timeZoneOffset":"{{ date('P') }}", --}}
                                                            "trigger":"click",
                                                            "iCalFileName":"Event-{{ $item->subject->name }}"
                                                        }
                                                    </div>
                                                @elseif($item->subject->getCoreMeta('location_type') === 'offline')
                                                    @php
                                                        $location_link = $item->subject->getCoreMeta('location_address_map_link');
                                                        $default_1h_diff = $item->subject->getCoreMeta('start_date') + 3600;
                                                    @endphp
                                                    <div class="atcb" class="mt-4" style="display:none;">
                                                        {
                                                            "name":"{{ $item->subject->name }}",
                                                            "description":"{{ $item->subject->excerpt }}",
                                                            "startDate":"{{ date('Y-m-d', $item->subject->getCoreMeta('start_date')) }}",
                                                            @if($item->subject->getCoreMeta('date_type') == 'range') 
                                                                "endDate":"{{ date('Y-m-d', $item->subject->getCoreMeta('end_date')) }}",
                                                            @else
                                                                "endDate":"{{ date('Y-m-d', $default_1h_diff) }}",
                                                            @endif

                                                            "startTime":"{{ date('H:i', $item->subject->getCoreMeta('start_date')) }}",
                                                            
                                                            @if($item->subject->getCoreMeta('date_type') == 'range') 
                                                                "endTime":"{{ date('H:i', $item->subject->getCoreMeta('end_date')) }}",
                                                            @else
                                                                "endTime":"{{ date('H:i', $default_1h_diff) }}",
                                                            @endif
                                                            "location":"{{ $item->subject->getCoreMeta('location_link') ?? ' ' }}",
                                                            "label":"{{ translate('Add to Calendar') }}",
                                                            "options":[
                                                                "Apple",
                                                                "Google",
                                                                "iCal",
                                                                "Microsoft365",
                                                                "MicrosoftTeams",
                                                                "Outlook.com",
                                                                "Yahoo"
                                                            ],
                                                            "timeZone":"{{ date_default_timezone_get() }}",
                                                            {{-- "timeZoneOffset":"{{ date('P') }}", --}}
                                                            "trigger":"click",
                                                            "iCalFileName":"Event-{{ $item->subject->name }}"
                                                        }
                                                    </div>
                                                @endif
                                                
                                            @elseif($item->subject->type === \App\Enums\ProductTypeEnum::course()->value)
                                                <a href="{{ $item->subject->getPermalink() }}" type="button" class="btn-primary mt-4">
                                                    {{ translate('Go to course') }}
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-6 sm:flex sm:justify-between">
                                    <div class="relative flex items-start">
                                        <div class="relative flex items-start">
                                            <div class="flex items-center h-5">
                                              <input id="notify_owner_when_updated-{{ $item->subject->id }}" x-model="notify_owner_when_updated" name="comments" type="checkbox" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded">
                                            </div>
                                            <div class="ml-3 text-sm">
                                                <label for="notify_owner_when_updated-{{ $item->subject->id }}" class="font-medium text-gray-500">
                                                    {{ translate('Get notified by email if this item is updated') }}
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mt-6 border-t border-gray-200 pt-4 flex items-center space-x-4 divide-x divide-gray-200 text-sm font-medium sm:mt-0 sm:ml-4 sm:border-none sm:pt-0">
                                        <div class="flex-1 flex justify-center">
                                            <a href="{{ route(\App\Models\Product::getRouteName(), $item->subject->slug) }}" target="_blank" class="text-indigo-600 whitespace-nowrap hover:text-indigo-500">View product</a>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @endif
                        

                    </ul>
                </div>
            @endforeach
        @endif
        
    </div>
</div>