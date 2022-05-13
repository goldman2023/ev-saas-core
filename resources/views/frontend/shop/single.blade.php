{{-- @extends('frontend.layouts.' . $globalLayout)

@section('meta')
@endsection

@section('content') --}}
@extends('frontend.layouts.feed')

@section('meta')

@endsection

@section('feed_content')

<div class="col-span-12">
    <section class="grid grid-cols-12 gap-6 max-w-2xl md:max-w-full mx-auto">
        <div class="col-span-12 md:col-span-5 flex flex-col space-y-4">
            <section aria-labelledby="timeline-title" class="">
                <div class="bg-white px-4 pt-5 pb-4 shadow rounded-xl sm:px-6">

                    <div class="mb-3 flex items-center">
                        <x-tenant.system.image alt="{{ get_site_name() }} logo"
                            class="ring-2 ring-indigo-400 bg-white h-[70px] w-[70px] rounded-full mr-3" fit="contain"
                            :image="$shop->getThumbnail()">
                        </x-tenant.system.image>

                        <div class="flex flex-col">
                            <h1 class="mb-0 text-18 font-bold text-typ-1">{{ $shop->name }}</h1>
                            @if($shop->addresses()->first())
                                <div class="flex items-center text-sm font-semibold">
                                    <img class="inline-block mr-2" src="{{ static_asset('assets/img/flags/' . strtolower($shop->addresses()->first()->country) ) }}.png" >
                                    {{ country_name_by_code($shop->addresses()->first()->country) }}
                                </div>
                            @endif

                            @if($shop->isVerified())
                                <x-feed.elements.verified-badge :item="$shop" class="mt-1"></x-feed.elements.verified-badge>
                            @endif
                        </div>
                    </div>

                    <p class="text-14 text-typ-3">
                        {{ $shop->excerpt }}
                    </p>

                    @if($shop->created_at)
                        <div class="w-full flex justify-start text-sm whitespace-nowrap  mt-2">
                            <span class="text-typ-2 mr-1">{{ translate('Joined')}}:</span>
                            <time datetime="{{ $shop->created_at }}" class="text-typ-3">
                                {{ $shop->created_at->diffForHumans() }}
                            </time>
                        </div>
                    @endif

                    <div class="w-full flex flex-col justify-start items-center">
                        <ul class="w-full flex justify-center my-3 border-y border-gray-200">
                            <div class="flex flex-col items-center py-3 px-3 text-16 text-typ-2 ">
                                <strong class="text-16 text-typ-2">{{ $shop->products()->published()->where('type', '!=', 'event')->count() }}</strong>
                                <span class="text-14 text-typ-3 block">{{ translate('Products') }}</span>
                            </div>
                            <div class="flex flex-col items-center py-3 px-3 text-16 text-typ-2 ">
                                <strong class="text-16 text-typ-2">{{ $shop->products()->published()->where('type', '=', 'event')->count() }}</strong>
                                <span class="text-14 text-typ-3 block">{{ translate('Events') }}</span>
        
                            </div>
                            <div class="flex flex-col items-center py-3 px-3 text-16 text-typ-2 ">
                                <strong class="text-16 text-typ-2">{{ $shop->blog_posts()->where('type', 'blog')->count() }}</strong>
                                <span class="text-14 text-typ-3 block">{{ translate('Articles') }}</span>
        
                            </div>
                            <div class="flex flex-col items-center py-3 px-3 text-16 text-typ-2 ">
                                <strong class="text-16 text-typ-2">{{ $shop->followers()->count() }}</strong>
                                <span class="text-14 text-typ-3 block">{{ translate('Followers') }}</span>
                            </div>
                        </ul>

                        <div class="w-full flex justify-center items-center space-x-5 py-1">
                            <div class="text-right text-sm whitespace-nowrap text-gray-500">
                                @livewire('actions.social-action-button', [
                                    'object' => $shop,
                                    'action' => 'follow',
                                    'class' => '!rounded-lg !py-2 border border-indigo-600 !px-4'
                                ])
                            </div>
                            <div class="text-right text-sm whitespace-nowrap text-gray-500">
                                <div class="btn-standard-outline">
                                    {{ translate('Contact') }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Activity Feed -->
                    {{-- <div class="mt-6 flow-root">
                        <ul role="list" class="-mb-8">
                            <li>
                                <div class="relative pb-8">
                                    <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200"
                                        aria-hidden="true"></span>
                                    <div class="relative flex space-x-3">
                                        <div>
                                            <span
                                                class="h-8 w-8 rounded-full bg-gray-400 flex items-center justify-center ring-8 ring-white">
                                                <!-- Heroicon name: solid/user -->
                                                <svg class="w-5 h-5 text-white" xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                    <path fill-rule="evenodd"
                                                        d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </span>
                                        </div>
                                        <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                            <div>
                                                <p class="text-sm text-gray-500">
                                                    {{ $shop->followers()->count() }} {{ translate('Followers')}}
                                                    <a href="#" class="font-medium text-gray-900"></a>
                                                </p>
                                            </div>
                                            <div class="text-right text-sm whitespace-nowrap text-gray-500">
                                                @livewire('actions.social-action-button', [
                                                'object' => $shop,
                                                'action' => 'follow'
                                                ])
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>

                            <li>
                                <div class="relative pb-8">
                                    <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200"
                                        aria-hidden="true"></span>
                                    <div class="relative flex space-x-3">
                                        <div>
                                            <span
                                                class="h-8 w-8 rounded-full bg-blue-500 flex items-center justify-center ring-8 ring-white">
                                                <!-- Heroicon name: solid/thumb-up -->
                                                <svg class="w-5 h-5 text-white" xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                    <path
                                                        d="M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.43a2 2 0 001.106 1.79l.05.025A4 4 0 008.943 18h5.416a2 2 0 001.962-1.608l1.2-6A2 2 0 0015.56 8H12V4a2 2 0 00-2-2 1 1 0 00-1 1v.667a4 4 0 01-.8 2.4L6.8 7.933a4 4 0 00-.8 2.4z" />
                                                </svg>
                                            </span>
                                        </div>
                                        <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                            <div>
                                                <p class="text-sm text-gray-500">
                                                    {{ translate('Products') }}
                                                    <a href="#" class="font-medium text-gray-900">
                                                        {{ $shop->products()->count() }}
                                                    </a>
                                                </p>
                                            </div>
                                            <div class="text-right text-sm whitespace-nowrap text-gray-500">
                                                <a
                                                    class="inline-flex items-center px-3 py-0.5 rounded-full bg-indigo-50 text-sm font-medium text-indigo-700 hover:bg-indigo-100">
                                                    {{ translate('View') }}
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>

                            <li>
                                <div class="relative pb-8">
                                    <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200"
                                        aria-hidden="true"></span>
                                    <div class="relative flex space-x-3">
                                        <div>
                                            <span
                                                class="h-8 w-8 rounded-full bg-green-500 flex items-center justify-center ring-8 ring-white">
                                                <!-- Heroicon name: solid/check -->
                                                <svg class="w-5 h-5 text-white" xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                    <path fill-rule="evenodd"
                                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </span>
                                        </div>
                                        <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                            <div>
                                                <p class="text-sm text-gray-500">{{ translate('Joined') }}<a href="#"
                                                        class="font-medium text-gray-900">
                                                        {{ $shop->created_at->diffForHumans() }}</a>
                                                </p>
                                            </div>
                                            <div class="text-right text-sm whitespace-nowrap text-gray-500">

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>

                            <li>
                                <div class="relative pb-8">

                                    <div class="relative flex space-x-3">
                                        <div>
                                            <span
                                                class="h-8 w-8 rounded-full bg-blue-500 flex items-center justify-center ring-8 ring-white">
                                                <!-- Heroicon name: solid/thumb-up -->
                                                <svg class="w-5 h-5 text-white" xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                    <path
                                                        d="M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.43a2 2 0 001.106 1.79l.05.025A4 4 0 008.943 18h5.416a2 2 0 001.962-1.608l1.2-6A2 2 0 0015.56 8H12V4a2 2 0 00-2-2 1 1 0 00-1 1v.667a4 4 0 01-.8 2.4L6.8 7.933a4 4 0 00-.8 2.4z" />
                                                </svg>
                                            </span>
                                        </div>
                                        <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                            @if($shop->isVerified())
                                            <div>
                                                <p class="text-sm text-gray-500">{{ translate('Verified Profile') }}</p>
                                            </div>
                                            @endif
                                            <div class="text-right text-sm whitespace-nowrap text-gray-500">
                                                <time datetime="{{ $shop->updated_at }}">{{ $shop->updated_at->diffForHumans() }}</time>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>


                        </ul>
                    </div> --}}
                    {{-- <div class="mt-6 flex flex-col justify-stretch">
                        <a type="button"
                            class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            {{ translate('View full profile') }}
                    </a>
                    </div> --}}
                </div>
            </section>

            <x-feed.elements.shop.shop-information :shop="$shop" class="" />

            {{-- Contacy info --}}
            <div class="w-full bg-white rounded-xl shadow ">
                <div class="w-full px-5 py-4 pb-3 mb-3 flex justify-between items-center border-b border-gray-200">
                    <h5 class="text-14 font-semibold">{{ translate('Contact information') }}</h5>
                </div>
            
                <div class="px-5 pb-3 flex flex-col ">
                    @if(!empty($shop->getShopMeta('contact_details')))
                        @foreach($shop->getShopMeta('contact_details') as $index => $contact)
                            <div class="w-full flex flex-col  @if($index !== count($shop->getShopMeta('contact_details')) - 1) border-b border-gray-200 pb-3 mb-3 @endif">
                                <strong class="block mb-0 text-16 text-typ-1">{{ $contact['department_name'] ?? '' }}</strong>
                                <div class="flex flex-row items-center text-14 mb-1">
                                    <strong class="text-typ-2">{{ $contact['email'] }}</strong>
                                </div>
                                <div class="flex flex-col items-start text-14">
                                    @if(!empty($contact['phones'] ?? null))
                                        @foreach($contact['phones'] as $phone)
                                            <span class="text-typ-2 text-14" href="{{ $phone }}">{{ $phone }}</span>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="col-span-12 relative block w-full bg-white border-2 border-gray-300 border-dashed rounded-lg p-12 text-center">
                            @svg('icomoon-book', ['class' => 'mx-auto h-12 w-12 text-gray-400'])
                            <span class="mt-2 block text-sm font-medium text-typ-2">{{ translate('No contact details yet...') }}</span>

                            @owner($user)
                                <a href="{{ route('settings.shop-settings') }}" class="btn-primary mt-3">
                                    {{ translate('Add Contact Details?') }}
                                </a>
                            @endowner
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-span-12 md:col-span-7">
            {{-- Cover --}}
            <div class="w-full rounded-xl mb-4">
                <x-tenant.system.image class="block h-[180px] sm:h-[200px] w-full rounded-xl " fit="cover" :image="$shop->getCover(['w' => 1200])" />
            </div>

            <livewire:feed.shop-profile-feed :shop="$shop" />
        </div>
    </section>
</div>


<div class="min-h-full bg-gray-100">
    <main class="pb-10">
        <!-- Page header -->
        <div class="relative ">

            <x-tenant.system.image alt="{{ get_site_name() }} logo" class="absolute bg-white h-[320px] w-full"
                fit="cover" :image="$shop->getCover()">
            </x-tenant.system.image>
            {{-- Background overlay --}}
            <div class='h-[320px] from-gray-900 bg-gradient-to-t z-100 relative'></div>
        </div>
        <div style="margin-top:-130px; z-index: 99;"
            class="relative z-100 max-w-3xl mx-auto px-4 sm:px-6 md:flex md:items-center md:justify-between md:space-x-5 lg:max-w-7xl lg:px-8">
            <div class="flex items-center space-x-5 ">

                <div class="flex-shrink-0 ">
                    <div class="relative">
                        <x-tenant.system.image alt="{{ get_site_name() }} logo"
                            class="ring-2 ring-indigo-400 bg-white h-16 w-16 rounded-full" fit="contain"
                            :image="$shop->getThumbnail()">
                        </x-tenant.system.image>
                        <span class="absolute inset-0 shadow-inner rounded-full" aria-hidden="true"></span>
                    </div>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-gray-200">{{ $shop->name }}</h1>
                    <p class="text-sm font-medium text-gray-300">{{ translate('Last active') }} <a href="#"
                            class="text-gray-500">{{ $shop->taglin }}</a> on <time datetime="2020-08-25">August 25,
                            2020</time></p>
                </div>
            </div>
            <div
                class="mt-6 flex flex-col-reverse justify-stretch space-y-4 space-y-reverse sm:flex-row-reverse sm:justify-end sm:space-x-reverse sm:space-y-0 sm:space-x-3 md:mt-0 md:flex-row md:space-x-3">

                <div
                    class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-blue-500">
                    @livewire('actions.social-action-button', [
                    'object' => $shop,
                    'action' => 'follow'
                    ])
                </div>
                <button type="button"
                    x-on:click="CometChatWidget.openOrCloseChat(true); CometChatWidget.chatWithUser('web_{{ $shop->users()->first()->id }}');"
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
                            <span>{{ translate('Seller Profile') }}</span>
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
                            <span>{{ translate('Reviews') }}</span>
                            <span aria-hidden="true" class="bg-transparent absolute inset-x-0 bottom-0 h-0.5"></span>
                        </a>

                    </nav>
                    <div class="bg-white shadow sm:rounded-lg">
                        <div class="px-4 py-5 sm:px-6">
                            <h2 id="applicant-information-title" class="text-lg leading-6 font-medium text-gray-900">
                               {{ $shop->name }} {{ translate('Activity') }}
                            </h2>

                            @if($shop->isVerified())
                            <p class="mt-1 max-w-2xl text-sm text-gray-500 flex items-center">
                                <span
                                    class="h-4 w-4 rounded-full bg-green-500 flex items-center justify-center ring-8 ring-white mr-3">
                                    <!-- Heroicon name: solid/check -->
                                    <svg class="w-3 h-3 text-white" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd"
                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </span>
                                <span class="text-indigo-600 font-medium">
                                    {{ translate('Verified profile') }}
                                </span>
                            </p>
                            @endif
                        </div>
                        <div class="border-t border-gray-200 px-4 py-5 sm:px-6">
                            <dl class="grid grid-cols-1 gap-10 sm:grid-cols-2">
                                @foreach($shop->products()->paginate(10) as $product)
                                <livewire:feed.elements.product-card :product="$product">
                                </livewire:feed.elements.product-card>

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

            
        </div>
    </main>
</div>


@endsection
