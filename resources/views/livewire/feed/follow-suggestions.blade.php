<div class="bg-white rounded-lg shadow">
    <div class="p-6">
        <h2 id="who-to-follow-heading" class="text-base font-medium text-gray-900">
            {{ translate('Recommended members') }}
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
                        <li class="flex items-center py-4 space-x-3" x-data="{
                            action: 'follow',
                            followers: @js($account->followers()->count()),
                            model_id: {{ $account->id }},
                            model_class: atob('{{ base64_encode($account::class) }}')
                        }"
                        @refresh-social-action-count.window="
                            if($event.detail.action === action && $event.detail.model_id === model_id && $event.detail.model_class === model_class) {
                                followers = $event.detail.count;
                            }
                        ">
                            <div class="flex-shrink-0 mr-1">
                                <a href="{{ $account->getPermalink() }}">
                                    <img class="h-12 w-12 rounded-full object-fit" src="{{ $account->getThumbnail() }}" alt="">
                                </a>
                            </div>
                            <div class="min-w-0 flex-1">
                                <p class="text-md mb-1 font-medium text-gray-900">
                                    <a href="{{ $account->getPermalink() }}">{{ $account->name }}</a>
                                </p>
                                <p class="text-sm text-gray-500">
                                    <template x-if="followers <= 0">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                            <svg class="-ml-0.5 mr-1.5 h-2 w-2 text-indigo-400" fill="currentColor"
                                                viewBox="0 0 8 8">
                                                <circle cx="4" cy="4" r="3" />
                                            </svg>
                                            {{ translate('New member!') }}
                                        </span>
                                    </template>
                                    <template x-if="followers > 0">
                                        <span x-text="followers+' {{ translate('followers') }}'"></span>
                                    </template>
                                </p>
                            </div>
                            <div class="flex-shrink-0">
                                <div>
                                    @livewire('actions.social-action-button', [
                                    'object' => $account,
                                    'action' => 'follow'
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
