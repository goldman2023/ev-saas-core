<div class="card hidden">
    <div class="card-header">
        <h5>{{ translate('Social Commerce Channels') }} </h5>
        <p>
            {{ translate('Sync your store with external networks') }}
        </p>
    </div>
    <ul role="list" class="mt-6 border-t border-b border-gray-200 divide-y divide-gray-200">
        @foreach ($integrations as $integration)
        <li>
            <div class="relative group py-4 flex items-start space-x-3">
                <div class="flex-shrink-0">
                    <span class="inline-flex items-center justify-center h-10 w-10 rounded-lg bg-pink-500">
                        <svg class="h-6 w-6 text-white" x-description="Heroicon name: outline/speakerphone"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z">
                            </path>
                        </svg>
                    </span>
                </div>
                <div class="min-w-0 flex-1">
                    <div class="text-sm font-medium text-gray-900">
                        <a href="{{ route('integrations.index') }}" class="">
                            <span class="absolute inset-0" aria-hidden="true"></span>
                            {{ $integration }}
                        </a>
                    </div>
                    <p class="text-sm text-gray-500">{{ translate('Connect your store and stock with ') }} {{
                        $integration }}</p>
                </div>
                <div class="flex-shrink-0 self-center">

                    <svg class="h-5 w-5 text-gray-400 group-hover:text-gray-500"
                        x-description="Heroicon name: solid/chevron-right" xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd"
                            d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                            clip-rule="evenodd"></path>
                    </svg>

                </div>
            </div>
        </li>
        @endforeach
    </ul>
</div>
