
<div class="rounded-lg bg-white overflow-hidden shadow">
    <div class="p-6 relative">
        <h3 class="text-base font-medium text-gray-900 relative mb-3">
            {{ translate('Real-Time') }} {{ get_site_name() }} {{ translate('Activity') }}
        </h3>
        {{-- Live data badge --}}
        <div class="absolute right-6 top-6">

            <span
                class="relative inline-flex font-bold items-center px-3 py-0.5 rounded-full text-sm font-medium bg-red-100 text-red-500">
                <span class="animate-ping inline-flex h-1.5 w-1.5 mr-3 rounded-full bg-red-900 opacity-100"></span>

                {{ translate('Live') }}
            </span>
        </div>
        {{-- Live data badge end --}}
        <ul role="list" class="-mb-8">
            @if($acitivites?->isNotEmpty() ?? null)
                @foreach($acitivites as $item)
                <li>
                    <div class="relative pb-8">
                        <span class="absolute top-5 left-5 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                        <div class="relative flex items-start space-x-3">
                            <div class="relative">
                                <img class="h-10 w-10 rounded-full bg-gray-400 flex items-center justify-center ring-8 ring-white"
                                    src="{{ $item->causer?->getThumbnail() ?? '' }}" alt="">

                                <span class="absolute -bottom-0.5 -right-1 bg-white rounded-tl px-0.5 py-px">
                                    <!-- Heroicon name: solid/chat-alt -->
                                    <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd"
                                            d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2zM7 8H5v2h2V8zm2 0h2v2H9V8zm6 0h-2v2h2V8z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </span>
                            </div>
                            <div class="min-w-0 flex-1">
                                <div>
                                    <div class="text-sm">
                                        <a href="#" class="font-medium text-gray-900">
                                            {{ $item->causer?->name ?? '' }}
                                        </a>
                                    </div>
                                    <p class="mt-0.5 text-sm text-gray-500">
                                        {{ $item->description }} {{ translate('a') }} {{ class_basename($item->subject) }}
                                    </p>
                                </div>
                                <div class="mt-2 text-sm text-gray-700">
                                    @if( class_basename($item->subject) === 'Product')
                                    @isset($item->subject->name)
                                    <a href="{{ $item->subject->getPermalink() }}">
                                        {{ $item->subject->name }}
                                    </a>
                                    @endisset
                                    @else
                                    @isset($item->subject->name)
                                    <p>{{ $item->subject->name }}</p>
                                    @endisset

                                    @endif
                                    <p class="mt-0.5 text-sm text-gray-500">{{ $item->created_at->diffForHumans() }} </p>

                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                @endforeach
            @endif
        </ul>
    </div>
</div>
