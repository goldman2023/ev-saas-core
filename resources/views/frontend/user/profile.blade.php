@extends('frontend.layouts.' . $globalLayout)

@section('meta')
@endsection

@section('content')

<div class="min-h-full bg-gray-100">


    <main class="pb-10">
        <!-- Page header -->
        <div class="relative ">

            <x-tenant.system.image alt="{{ get_site_name() }} logo" class="absolute bg-white h-[320px] w-full"
                fit="cover" :image="$user->getCover()">
            </x-tenant.system.image>
            {{-- Background overlay --}}
            <div class='h-[320px] from-gray-900 bg-gradient-to-t z-100 relative'></div>
        </div>
        <div style="margin-top:-130px; z-index: 9;"
            class="relative z-100 max-w-3xl mx-auto px-4 sm:px-6 md:flex md:items-center md:justify-between md:space-x-5 lg:max-w-7xl lg:px-8">
            <div class="flex items-center space-x-5 ">

                <div class="flex-shrink-0 ">
                    <div class="relative">
                        <x-tenant.system.image alt="{{ get_site_name() }} logo"
                            class="ring-2 ring-indigo-400 bg-white h-16 w-16 rounded-full" fit="contain"
                            :image="$user->getThumbnail()">
                        </x-tenant.system.image>
                        <span class="absolute inset-0 shadow-inner rounded-full" aria-hidden="true"></span>
                    </div>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-gray-200">{{ $user->name }}</h1>
                    <p class="text-sm font-medium text-gray-300">{{ translate('Last active') }}
                        <a href="#" class="text-gray-500"></a>
                        <time datetime="2020-08-25">{{ $user->updated_at->diffForHumans() }}</time>
                        @if($user->isVerified())
                        <span>{{ translate('Verified FoxAsk Member') }}</span>
                        @endif
                    </p>
                </div>
            </div>
            <div
                class="mt-6 flex flex-col-reverse justify-stretch space-y-4 space-y-reverse sm:flex-row-reverse sm:justify-end sm:space-x-reverse sm:space-y-0 sm:space-x-3 md:mt-0 md:flex-row md:space-x-3">

                <div
                    class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-blue-500">
                    @livewire('actions.wishlist-button', [
                    'object' => $user,
                    'action' => 'Follow'
                    ])
                </div>
                <button type="button"
                    x-on:click="CometChatWidget.openOrCloseChat(true); CometChatWidget.chatWithUser('web_{{ $user->id }}');"
                    class="inline-flex items-center justify-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-blue-500">
                    {{ translate('Send message') }}
                </button>
                {{-- <button type="button"
                    class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-blue-500">
                    Advance
                    to offer
                </button> --}}
            </div>
        </div>

        <div
            class="relative z-30 mt-8 max-w-3xl mx-auto grid grid-cols-1 gap-6 sm:px-6 lg:max-w-7xl lg:grid-flow-col-dense lg:grid-cols-3">



            <div class="space-y-6 lg:col-start-1 lg:col-span-2">
                <!-- Description list-->
                <section aria-labelledby="applicant-information-title">
                    <nav class="relative z-0 rounded-lg shadow flex divide-x divide-gray-200 mb-6" aria-label="Tabs">

                        <a href="#timeline" aria-current="page"
                            class="text-gray-900 rounded-l-lg  group relative min-w-0 flex-1 overflow-hidden bg-white py-4 px-6 text-sm font-medium text-center hover:bg-gray-50 focus:z-10"
                            x-state:on="Current" x-state:off="Default"
                            x-state-description="Current: &quot;text-gray-900&quot;, Default: &quot;text-gray-500 hover:text-gray-700&quot;">
                            <span>{{ translate('Timeline') }}</span>
                            <span aria-hidden="true" class="bg-rose-500 absolute inset-x-0 bottom-0 h-0.5"></span>
                        </a>

                        <a href="#products"
                            class="text-gray-500 hover:text-gray-700   group relative min-w-0 flex-1 overflow-hidden bg-white py-4 px-6 text-sm font-medium text-center hover:bg-gray-50 focus:z-10"
                            x-state-description="undefined: &quot;text-gray-900&quot;, undefined: &quot;text-gray-500 hover:text-gray-700&quot;">
                            <span>{{ translate('Products') }}</span>
                            <span aria-hidden="true" class="bg-transparent absolute inset-x-0 bottom-0 h-0.5"></span>
                        </a>

                        <a href="#"
                            class="text-gray-500 hover:text-gray-700  rounded-r-lg group relative min-w-0 flex-1 overflow-hidden bg-white py-4 px-6 text-sm font-medium text-center hover:bg-gray-50 focus:z-10"
                            x-state-description="undefined: &quot;text-gray-900&quot;, undefined: &quot;text-gray-500 hover:text-gray-700&quot;">
                            <span>{{ translate('Profile and info') }}</span>
                            <span aria-hidden="true" class="bg-transparent absolute inset-x-0 bottom-0 h-0.5"></span>
                        </a>

                    </nav>

                    <div class="mb-6">

                    <livewire:feed.elements.add-post></livewire:feed.elements.add-post>
                    </div>

                    <div class="bg-white shadow sm:rounded-lg">
                        <div class="px-4 py-5 sm:px-6">
                            <h2 id="applicant-information-title" class="text-lg leading-6 font-medium text-gray-900">
                                {{ translate('User timeline') }}
                            </h2>
                            {{-- <p class="mt-1 max-w-2xl text-sm text-gray-500">Personal details and application.</p>
                            --}}
                        </div>
                        <div class="border-t border-gray-200 px-4 py-5 sm:px-6">
                            <dl class="grid grid-cols-1 gap-3 sm:grid-cols-1">
                                @foreach($data as $item)
                                <div class="w-full">
                                    <livewire:feed.elements.feed-card wire:key="activity_{{ $item->id }}" :item="$item">
                                    </livewire:feed.elements.feed-card>
                                </div>

                                @endforeach

                            </dl>
                        </div>
                        <div>
                            <a href="#"
                                class="hidden block bg-gray-50 text-sm font-medium text-gray-500 text-center px-4 py-4 hover:text-gray-700 sm:rounded-b-lg">

                                Read
                                full application</a>
                        </div>
                    </div>
                </section>
            </div>

            <section aria-labelledby="timeline-title" class="lg:col-start-3 lg:col-span-1">
                <div class="bg-white px-4 py-5 shadow sm:rounded-lg sm:px-6">
                    <h2 id="timeline-title" class="text-lg font-medium text-gray-900">
                        {{ translate('About') }}
                    </h2>


                    <!-- Activity Feed -->
                    <div class="mt-6 flow-root">
                        <ul role="list" class="mb-0">
                            <li>
                                <div class="relative pb-8">
                                    <div class="relative flex space-x-3">
                                        <div>
                                            <span class="rounded-full bg-gray-400 flex items-center justify-center">
                                                <!-- Heroicon name: solid/user -->
                                                <img src="{{ $user->getThumbnail() }}"
                                                    class="w-12 h-12 rounded-full object-contain bg-white ring-2 ring-indigo-400">

                                            </span>
                                        </div>
                                        <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                            <div>
                                                <p class="text-md font-semibold text-gray-700">
                                                    {{ $user->name }}
                                                </p>
                                                @if($user->isVerified())
                                                    <x-feed.elements.verified-badge :item="$user">
                                                    </x-feed.elements.verified-badge>
                                                @endif

                                                @if($user->created_at)
                                                <div class="text-sm whitespace-nowrap text-gray-500">
                                                    <time datetime="{{ $user->created_at }}">
                                                        {{ translate('Joined')}} {{ $user->created_at->diffForHumans()
                                                        }}
                                                    </time>
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>

                        </ul>

                        <div>
                            <h3 class="font-medium text-gray-900">
                                {{ translate('About') }}
                            </h3>
                            <dl class="mt-2 border-t border-b border-gray-200 divide-y divide-gray-200">

                                <div class="py-3 flex justify-between text-sm font-medium">
                                    <dt class="capitalize text-gray-500">
                                        {{ translate('Followers') }}
                                    </dt>
                                    <dd class="text-gray-900">{{ $user->followers()->count() }}</dd>
                                </div>

                                <div class="py-3 flex justify-between text-sm font-medium">
                                    <dt class="capitalize text-gray-500">
                                        {{ translate('Following') }}
                                    </dt>
                                    <dd class="text-gray-900">{{ $user->following()->count() }}</dd>
                                </div>
                            </dl>
                        </div>
                    </div>
                    <div class="mt-6 flex flex-col justify-stretch">
                        <a href="#" type="button"
                            class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            {{ translate('View full profile') }}
                        </a>
                    </div>
                </div>
            </section>
        </div>
    </main>
</div>


@endsection
