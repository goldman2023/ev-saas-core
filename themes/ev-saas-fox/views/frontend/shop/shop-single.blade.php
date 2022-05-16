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
@endsection
