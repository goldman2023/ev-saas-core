<div class="w-full bg-white rounded-xl shadow">
    <div class="w-full px-5 py-4 mb-5 flex justify-between border-b border-gray-200">
        <h5 class="text-14 font-semibold">{{ translate('Upcoming Events') }}</h5>
    </div>

    <div class="px-5 pb-4 flex flex-col">
        @if(!empty($events))
            @foreach($events as $key => $event)
                <div class="w-full pb-3 @if($events->count()-1 !== $key) mb-4 border-b border-gray-20 @endif">
                    <div class="flex space-x-4">
                        <div class="flex-shrink-0">
                            <div class="inline-block relative">
                                <a href="{{ $event->getPermalink() }}">
                                    <x-tenant.system.image
                                        class="h-11 w-11 rounded-xl border-3 ring-2 ring-gray-200" fit="cover"
                                        :image="$event->getThumbnail()">
                                    </x-tenant.system.image>
                                </a>
                            </div>
                        </div>
                        <div class="min-w-0 flex-1">
                            <div class="w-full flex flex-row ">
                                <div class="w-full flex flex-col pr-4">
                                    <a href="{{ $event->getPermalink() }}" class="text-14 text-typ-2 font-medium block hover:underline mb-1 leading-tight">
                                        {{ $event->name }}
                                    </a>
                                    <p class="text-12 text-typ-3 line-clamp-2 mb-2">
                                        {{ $event->excerpt }}
                                    </p>
                                </div>
                                <div class="flex-shrink-0 self-start flex">
                                    <div class="relative inline-block text-left cursor-pointer">
                                        @svg('heroicon-s-dots-horizontal', ['class' => 'text-gray-400 w-5 h-5'])
                                    </div>
                                </div>
                            </div>
                            

                            <div class="w-full flex flex-col relative">
                                <div class="absolute top-0 right-0 flex items-center mb-2">
                                    @if($event->getCoreMeta('location_type') === 'remote')
                                        <span class="badge border border-primary text-typ-2 !text-10">{{ translate('Remote') }}</span>
                                    @else
                                        <span class="badge border border-green-700 text-typ-2 !text-10">{{ translate('Offline') }}</span>
                                    @endif
                                </div>

                                <div class="flex flex-col text-typ-2">
                                    <div class="w-full flex">
                                        @svg('heroicon-o-calendar', ['class' => 'h-4 h-5 mr-2 '])
                                        <span class="text-14">{{ translate('Start') }}:</span>
                                    </div>
                                   
                                    <time datetime="{{ $event->getCoreMeta('start_date') }}" class="pl-7 text-12">
                                        -{{ \Carbon::createFromTimestamp($event->getCoreMeta('start_date'))->format('d.m.Y H:i')  }}
                                    </time>
                                </div>

                                @if($event->getCoreMeta('date_type') === 'range' 
                                        && !empty($event->getCoreMeta('end_date')))
                                    <div class="flex flex-col text-typ-2">
                                        <div class="w-full flex">
                                            @svg('heroicon-o-calendar', ['class' => 'h-4 h-5 mr-2 '])
                                            <span class="text-14">{{ translate('End') }}:</span>
                                        </div>
                                    
                                        <time datetime="{{ $event->getCoreMeta('end_date') }}" class="pl-7 text-12">
                                            -{{ \Carbon::createFromTimestamp($event->getCoreMeta('end_date'))->format('d.m.Y H:i')  }}
                                        </time>
                                    </div>
                                @endif
                            </div>
                        </div>
                        
                    </div>
                </div>
            @endforeach

        @else
            {{-- TODO: Empty State --}}
        @endif

        <div class="w-full border-t border-gray-200 flex justify-center">
            <a href="#" class="text-typ-3 hover:underline w-full pt-2 text-14 text-center">
                {{ translate('See all') }}
            </a>
        </div>
    </div>
</div>