<ul class="step step-icon-xs mt-6" wire:poll.5s>
    @foreach($activity as $item)
    @if($item->causer)
    <li>
        <div class="relative pb-8">
            <span class="absolute top-5 left-5 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
            <div class="relative flex items-start space-x-3">
                <div class="relative">
                    <img class="h-10 w-10 rounded-full bg-gray-400 flex items-center justify-center ring-8 ring-white"
                        src="{{ $item->causer->getThumbnail() }}" alt="">

                    <span class="absolute -bottom-0.5 -right-1 bg-white rounded-tl px-0.5 py-px">
                        <!-- Heroicon name: solid/chat-alt -->
                        <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                            fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd"
                                d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2zM7 8H5v2h2V8zm2 0h2v2H9V8zm6 0h-2v2h2V8z"
                                clip-rule="evenodd" />
                        </svg>
                    </span>
                </div>
                <div class="min-w-0 flex-1">
                    <div>

                        <div class="text-sm">
                            <a href="{{ $item->causer->getPermalink() }}" class="font-medium text-gray-900">
                                {{ $item->causer->email }}
                            </a>
                        </div>
                        <p class="mt-0.5 text-sm text-gray-500">
                            @isset($item->properties['action'])
                            {{ $item->properties['action'] }}
                            @else
                            {{ $item->description }}
                            @endisset
                            {{ $item->created_at->diffForHumans() }}
                            {{ translate('via') }} <span class="text-[12px]"> {{ get_site_name() }} </span>
                        </p>
                    </div>
                    <div class="mt-2 text-sm text-gray-700">

                        @if($item->subject_type == 'App\Models\Product' && $item->subject)

                        <div class="text-left">
                            <a target="_blank"
                                class="grid grid-cols-3 relative block w-full border-2 border-gray-300 border-dashed rounded-lg p-3 text-left hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                href="{{ $item->subject->getPermalink() }}">
                                <img src="{{ $item->subject->getThumbnail() }}" class="w-10" />

                                <span class="font-medium text-left text-gray-900">
                                    {{ $item->subject->name }}
                                </span>
                            </a>
                        </div>
                        @else
                        @if($item->subject)
                            <a href="#" class="font-medium text-gray-900">
                                {{ $item->subject->name }}
                            </a>
                        @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </li>

    @endif

    @endforeach

</ul>
