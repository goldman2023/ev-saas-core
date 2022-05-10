<div class="w-full bg-white rounded-xl shadow">
    <div class="w-full px-5 py-4 mb-5 flex justify-between border-b border-gray-200">
        <h5 class="text-14 font-semibold">{{ translate('Suggested members') }}</h5>
    </div>

    <div class="px-5 pb-4 flex flex-col">
        <div class="w-full">
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

            <div wire:loading wire:target="loadInit"></div>

            <ul role="list" class="" wire:init="loadInit">
                @if($readyToLoad)
                    @foreach($accounts as $key => $account)
                        <li class="flex items-center" x-data="{
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

                            <div class="w-full  @if($accounts->count()-1 !== $key) pb-3 mb-4 border-b border-gray-20 @endif">
                                <div class="flex space-x-4">
                                    <div class="flex-shrink-0">
                                        <div class="inline-block relative">
                                            <a href="{{ $account->getPermalink() }}">
                                                <x-tenant.system.image
                                                    class="h-9 w-9 rounded-full" fit="cover"
                                                    :image="$account->getThumbnail()">
                                                </x-tenant.system.image>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <div class="w-full flex flex-row ">
                                            <div class="w-full flex flex-col pr-4">
                                                <a href="{{ $account->getPermalink() }}" class="text-14 text-typ-2 font-medium block hover:underline mb-1 leading-tight">
                                                    {{ $account->name }}
                                                </a>
                                                {{-- <p class="text-12 text-typ-3 line-clamp-2 mb-2">
                                                    {{ $account->excerpt }}
                                                </p> --}}
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
                                                
                                                {{-- TODO: No need for this component because suggested members should be the ones user does not follow! --}}
                                                {{-- <div class="flex-shrink-0">
                                                    <div>
                                                        @livewire('actions.social-action-button', [
                                                        'object' => $account,
                                                        'action' => 'follow'
                                                        ])
                                                    </div>
                                                </div> --}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    @endforeach

                @endif

            </ul>
        </div>
        

        
        {{-- <div class="mt-6">
            <a href="#"
                class="hidden w-full block text-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                View all </a>
        </div> --}}
    </div>

    <div class="w-full py-3 border-t border-gray-200 flex justify-center">
        <a href="{{ route('feed.shops') }}" class="text-typ-3 hover:underline w-full  text-14 text-center">
            {{ translate('Explore more profiles...') }}
        </a>
    </div>
</div>
