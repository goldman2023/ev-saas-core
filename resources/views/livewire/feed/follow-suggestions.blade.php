<div class="bg-white rounded-lg shadow">
    <div class="p-6">
        <h2 id="who-to-follow-heading" class="text-base font-medium text-gray-900">
            {{ translate('Popular Shops') }}
        </h2>
        <div class="mt-6 flow-root">
            @if(!$readyToLoad)

            <div class="w-full">
                <livewire:feed.elements.feed-card-empty-state variation="small">
                </livewire:feed.elements.feed-card-empty-state>
                <livewire:feed.elements.feed-card-empty-state>
                </livewire:feed.elements.feed-card-empty-state>
                <livewire:feed.elements.feed-card-empty-state>
                </livewire:feed.elements.feed-card-empty-state>
            </div>

            @endif

            <div wire:loading wire:target="loadInit">


            </div>
            <ul role="list" class="-my-4 divide-y divide-gray-200" wire:init="loadInit">
                @if($readyToLoad)
                @foreach($accounts as $account)
                <li class="flex items-center py-4 space-x-3">
                    <div class="flex-shrink-0">
                        <img class="h-8 w-8 rounded-full" src="{{ $account->getThumbnail() }}" alt="">
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="text-sm font-medium text-gray-900">
                            <a href="{{ $account->getPermalink() }}">{{ $account->name }}</a>
                        </p>
                        <p class="text-sm text-gray-500">

                            {{ $account->followers()->count() }} {{ translate('followers') }}
                            {{-- <a href="#">@ {{ $account->name }}</a> --}}
                        </p>
                    </div>
                    <div class="flex-shrink-0">

                        <div>
                            @livewire('actions.wishlist-button', [
                            'object' => $account,
                            'action' => 'Follow'
                            ])
                        </div>
                    </div>
                </li>
                @endforeach

                @endif

                <!-- More people... -->
            </ul>
        </div>
        <div class="mt-6">
            <a href="#"
                class="hidden w-full block text-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                View all </a>
        </div>
    </div>
</div>
