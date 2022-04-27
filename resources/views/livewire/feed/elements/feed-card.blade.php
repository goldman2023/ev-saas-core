<div x-data="{
    'isModalOpen': false,
}" x-on:keydown.escape="isModalOpen=false">
    @if(!$ignore)
    <div>
        <article class='mb-6 bg-white px-4 py-6 shadow sm:p-6 sm:rounded-lg' x-data="{
            id: 'feed-activity-{{ $item->id }}',
            comment_count: {{ $item->subject->comments()->count() }},
        }"
        @change-activity-comment-count.window="
            if(id == 'feed-activity-'+$event.detail.item_id) {
                comment_count = Number(comment_count) + 1;
            }
        "
        >
            {{-- x-intersect:visible="$wire.track_impression({{ $item->id }})" --}}
            <div>
                <x-feed.elements.card-header-user-info :item="$item">
                </x-feed.elements.card-header-user-info>
                <h2 class="mt-4 text-base font-medium text-gray-900" x-on:click="isModalOpen = true">

                    @if($item->subject_type == 'App\Models\Wishlist')

                    {{ translate('Liked a product') }} <span class="emoji ml-2">❤️</span>

                    @elseif($item->subject_type == 'App\Models\Product' && $item->subject)
                    <a href="{{ $product->getPermalink() }}">
                        @if($item->description == 'created')
                        {{ translate('Added new product') }}
                        @elseif($item->description == 'viewed')
                        {{ $item->properties['action_title'] }} <span class="emoji ml-2">👁️‍🗨️</span>
                        @elseif($item->description == 'liked')
                        {{ $item->properties['action_title'] }} <span class="emoji ml-2">❤️</span>
                        @else
                        {{ $item->description }}
                        @endif
                    </a>
                    @elseif($item->subject_type == 'App\Models\BlogPost' && $item->subject)
                    <span class="text-xs font-gray-500 mt-3 font-normal">
                        {{-- {{ $item->description }} {{ translate('new status update') }} --}}
                    </span>

                    <a href="{{ $item->subject->getPermalink() }}" target="_blank">
                        {{ $item->subject->title }}
                    </a>

                    <p class="text-md font-gray-600 mt-3 font-normal">
                        {{ $item->subject->excerpt}}
                    </p>

                    @if(!empty($item->subject->hasThumbnail()))
                        <div class="w-full mt-4">
                            <img src="{{ $item->subject->getThumbnail(['w' => 600]) }}" class="w-full border border-gray-200 rounded shadow-md"/>
                        </div>
                    @endif

                    @else
                    @if(class_exists($item->subject_type) && $item->subject)
                    {{ $item->description }}
                    {{ class_basename($item->subject)}}
                    @isset($item->subject->name)
                    {{ $item->subject->name }}
                    @endisset


                    @endif
                    @endif
                </h2>
            </div>
            <div class="mt-2 text-sm text-gray-700 space-y-4 cursor-pointer" x-on:click="isModalOpen = true">
                @if($product)
                <div class="grid grid-cols-3  border-2 border-gray-300 border-dashed rounded-lg p-3 gap-10">
                    <div class="flex items-center">
                        {{-- TODO: Implement quick view --}}
                        <x-tenant.system.image alt="{{ get_site_name() }} logo"
                            class="min-h-8 w-full mx-auto sm:min-h-10" :image="$product->getThumbnail()">
                        </x-tenant.system.image>
                    </div>
                    <div class="col-span-2 truncate">
                        <span class="text-dark font-weight-bold">
                            <div>
                                <span class="text-lg font-bold">
                                    {{ $product->name }}
                                </span>
                            </div>

                            @if ($product->getBasePrice() != $product->getTotalPrice())
                            <del class="fw-600 text-danger opacity-50 text-sm mr-1">{{ $product->getBasePrice(true)
                                }}</del>
                            @endif
                            <span class="fw-700 text-black">{{ $product->getTotalPrice(true) }}</span>
                        </span>

                        <div class="max-h-[100px] overflow-hidden">
                            {!! $product->description !!}
                        </div>
                        <div>
                            {{-- <livewire:actions.wishlist-button :key="'product_'.$item->id"
                                template="wishlist-button-detailed" :object="$product">
                            </livewire:actions.wishlist-button> --}}
                        </div>
                        <span class="btn btn-primary mt-4">
                            {{ translate('View product') }}
                        </span>
                    </div>
                </div>
                @endif

            </div>
            <div class="mt-6 flex justify-between space-x-8 mb-3">
                <div class="flex space-x-6">
                    <span class="inline-flex items-center text-sm">

                        @if($item->description != 'liked' && $item->description != 'User liked a product')

                        <livewire:actions.wishlist-button wire:key="post_{{ $item->id }}" :object="$item->subject">
                        </livewire:actions.wishlist-button>
                        @endif


                    </span>
                    <span class="inline-flex items-center text-sm cursor-pointer">
                        <button wire:click="toggle_comments()" type="button"
                            class=" inline-flex space-x-2 text-gray-400 hover:text-gray-500">
                            <!-- Heroicon name: solid/chat-alt -->
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd"
                                    d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2zM7 8H5v2h2V8zm2 0h2v2H9V8zm6 0h-2v2h2V8z"
                                    clip-rule="evenodd" />
                            </svg>
                            {{-- @if($item->subject->comments->count)  --}}
                                <span class="font-medium text-gray-900" x-text="comment_count"></span>
                                <span class="sr-only">replies</span>
                            {{-- @endif --}}
                        </button>
                    </span>
                    <span class="inline-flex items-center text-sm">
                        <button type="button" class="inline-flex space-x-2 text-gray-400 hover:text-gray-500">
                            <!-- Heroicon name: solid/eye -->
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                fill="currentColor" aria-hidden="true">
                                <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                <path fill-rule="evenodd"
                                    d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                                    clip-rule="evenodd" />
                            </svg>
                            <span class="font-medium text-gray-900">{{ $item->impressions }}</span>
                            <span class="sr-only">views</span>
                        </button>
                    </span>
                </div>
                <div class="flex text-sm">
                    <span class="hidden inline-flex items-center text-sm">
                        <button type="button" class="inline-flex space-x-2 text-gray-400 hover:text-gray-500">
                            <!-- Heroicon name: solid/share -->
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                fill="currentColor" aria-hidden="true">
                                <path
                                    d="M15 8a3 3 0 10-2.977-2.63l-4.94 2.47a3 3 0 100 4.319l4.94 2.47a3 3 0 10.895-1.789l-4.94-2.47a3.027 3.027 0 000-.74l4.94-2.47C13.456 7.68 14.19 8 15 8z" />
                            </svg>
                            <span class="font-medium text-gray-900">Share</span>
                        </button>
                    </span>
                </div>

            </div>

            {{-- This is triggered by :wire-click="toggle_comments()" --}}
            @if($showComments)
            <div>
                <livewire:actions.social-comments :item="$item">
                </livewire:actions.social-comments>
            </div>
            @endif
        </article>

    </div>
    <livewire:feed.elements.quick-views.main :item="$item">
    </livewire:feed.elements.quick-views.main>

    @endif

</div>
