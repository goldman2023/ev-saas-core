<div>
    <article {{ $attributes->merge(['class' => 'mb-3 bg-white px-4 py-6 shadow sm:p-6 sm:rounded-lg']) }}>
        <div x-intersect:visible="$wire.track_impression({{ $item->id }})">
            <div class="flex space-x-3">
                <div class="flex-shrink-0">
                    <div class="inline-block relative">
                        {{-- TODO: Implement quick view for person and for product click --}}
                        <x-tenant.system.image alt="{{ get_site_name() }} logo" class="h-10 w-10 rounded-full border-3"
                            :image="$item->causer->getAvatar()">
                        </x-tenant.system.image>
                        <span
                            class="absolute bottom-0 right-0 block h-4 w-4 rounded-full ring-2 ring-white bg-green-400"></span>
                    </div>

                </div>
                <div class="min-w-0 flex-1">
                    <p class="text-sm font-medium text-gray-900">
                        @isset( $item->causer->name)
                        <a href="#" class="hover:underline">
                            {{ $item->causer->name }}
                        </a>
                        @endisset
                    </p>
                    <p class="text-sm text-gray-500">
                        <a href="#" class="hover:underline">
                            <time datetime="2020-12-09T11:43:00">
                                {{ $item->created_at->diffForHumans() }}
                            </time>
                        </a>
                    </p>
                </div>
                <div class="flex-shrink-0 self-center flex">
                    <div class="relative inline-block text-left">
                        <div>
                            <button type="button"
                                class="-m-2 p-2 rounded-full flex items-center text-gray-400 hover:text-gray-600"
                                id="options-menu-0-button" aria-expanded="false" aria-haspopup="true">
                                <span class="sr-only">Open options</span>
                                <!-- Heroicon name: solid/dots-vertical -->
                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                    fill="currentColor" aria-hidden="true">
                                    <path
                                        d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z" />
                                </svg>
                            </button>
                        </div>

                    </div>
                </div>
            </div>
            <h2 class="mt-4 text-base font-medium text-gray-900">

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
                @elseif($item->subject_type == 'App\Models\BlogPost')
                Blog post
                @else
                @if(class_exists($item->subject_type))
                {{-- {{ $item->description }} {{ class_basename($item->subject)}} {{ $item->subject->name }} --}}
                @endif
                @endif
            </h2>
        </div>
        <div class="mt-2 text-sm text-gray-700 space-y-4">
            @if($product)
            <div class="grid grid-cols-3  border-2 border-gray-300 border-dashed rounded-lg p-3 gap-10">
                <div class="flex items-center">
                    {{-- TODO: Implement quick view --}}
                    <a href="{{ $product->getPermalink() }}" class="text-lg font-bold">
                        <x-tenant.system.image alt="{{ get_site_name() }} logo"
                            class="min-h-8 w-full mx-auto sm:min-h-10" :image="$product->getThumbnail()">
                        </x-tenant.system.image>
                    </a>
                </div>
                <div class="col-span-2 truncate">
                    <span class="text-dark font-weight-bold">
                        <div>
                            <a href="{{ $product->getPermalink() }}" class="text-lg font-bold">
                                {{ $product->name }}
                            </a>
                        </div>

                        @if ($product->getBasePrice() != $product->getTotalPrice())
                        <del class="fw-600 text-danger opacity-50 text-sm mr-1">{{ $product->getBasePrice(true) }}</del>
                        @endif
                        <span class="fw-700 text-black">{{ $product->getTotalPrice(true) }}</span>
                    </span>

                    <div class="max-h-[200px]">
                        {!! $product->description !!}
                    </div>
                    <div>
                        <livewire:actions.social-action-button :key="$item->id" action="wishlist" template="wishlist-button-detailed"
                            :object="$product">
                        </livewire:actions.social-action-button>
                    </div>
                    <a href="{{ $product->getPermalink() }}" class="btn btn-primary mt-4">
                        {{ translate('View product') }}
                    </a>
                </div>
            </div>
            @endif

        </div>
        <div class="mt-6 flex justify-between space-x-8">
            <div class="flex space-x-6">
                <span class="inline-flex items-center text-sm">
                    <button type="button" class="inline-flex space-x-2 text-gray-400 hover:text-gray-500">
                        <!-- Heroicon name: solid/thumb-up -->
                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                            aria-hidden="true">
                            <path
                                d="M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.43a2 2 0 001.106 1.79l.05.025A4 4 0 008.943 18h5.416a2 2 0 001.962-1.608l1.2-6A2 2 0 0015.56 8H12V4a2 2 0 00-2-2 1 1 0 00-1 1v.667a4 4 0 01-.8 2.4L6.8 7.933a4 4 0 00-.8 2.4z" />
                        </svg>
                        <span class="font-medium text-gray-900">
                            {{ $likes }}
                        </span>
                        <span class="sr-only">likes</span>

                    </button>
                    <livewire:actions.social-action-button wire:key="post_{{ $item->id }}" :object="$item" action="reaction" type="like">
                    </livewire:actions.social-action-button>
                </span>
                <span class="inline-flex items-center text-sm">
                    <button type="button" class="inline-flex space-x-2 text-gray-400 hover:text-gray-500">
                        <!-- Heroicon name: solid/chat-alt -->
                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                            aria-hidden="true">
                            <path fill-rule="evenodd"
                                d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2zM7 8H5v2h2V8zm2 0h2v2H9V8zm6 0h-2v2h2V8z"
                                clip-rule="evenodd" />
                        </svg>
                        <span class="font-medium text-gray-900">11</span>
                        <span class="sr-only">replies</span>
                    </button>
                </span>
                <span class="inline-flex items-center text-sm">
                    <button type="button" class="inline-flex space-x-2 text-gray-400 hover:text-gray-500">
                        <!-- Heroicon name: solid/eye -->
                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                            aria-hidden="true">
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
                <span class="inline-flex items-center text-sm">
                    <button type="button" class="inline-flex space-x-2 text-gray-400 hover:text-gray-500">
                        <!-- Heroicon name: solid/share -->
                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                            aria-hidden="true">
                            <path
                                d="M15 8a3 3 0 10-2.977-2.63l-4.94 2.47a3 3 0 100 4.319l4.94 2.47a3 3 0 10.895-1.789l-4.94-2.47a3.027 3.027 0 000-.74l4.94-2.47C13.456 7.68 14.19 8 15 8z" />
                        </svg>
                        <span class="font-medium text-gray-900">Share</span>
                    </button>
                </span>
            </div>
        </div>
    </article>
</div>
