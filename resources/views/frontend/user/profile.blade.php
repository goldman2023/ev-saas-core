@extends('frontend.layouts.feed')

@section('meta')

@endsection

@section('feed_content')

<div class="col-span-12">

    <section class="relative w-full mb-3 md:mb-5 bg-white rounded-xl">
        <div class="relative w-full">
            <x-tenant.system.image class="block h-[180px] sm:h-[260px] w-full rounded-t-xl " fit="cover" :image="$user->getCover(['w' => 1200])" />
            <x-tenant.system.image class="absolute left-[30px] bottom-[-50px] w-[120px] h-[120px] sm:w-[160px] sm:h-[160px] rounded-full bg-white border border-gray-200" fit="contain" :image="$user->getThumbnail()" />

            @owner($user)
                <a href="{{ route('my.account.settings') }}" class="absolute top-5 right-5 btn-primary">
                    {{ translate('Edit account') }}
                </a>
            @endowner
            {{-- <div class="absolute left-[210px] bottom-[20px] flex ">

            </div> --}}
        </div>
        
        <div class="w-full px-5 grid grid-cols-12 gap-6 h-[70px]">
            <div class="col-span-12 md:col-span-5 flex flex-col justify-center pl-[150px] md:pl-[190px]">
                <h2 class="text-18 text-typ-1 leading-none font-semibold">{{ $user->name.' '.$user->surname }}</h2>
                @if(!empty($user->username))
                    <span class="text-14 text-primary">{{ '@'.$user->username }}</span>
                @endif
            </div>
        
            <div class="col-span-7 hidden md:flex flex-col">
                <ul class="w-full flex ">
                    <div class="flex flex-col items-center py-3 px-3 text-16 text-typ-2 cursor-pointer">
                        <span class="text-typ-1 block">{{ translate('Posts') }}</span>
                        <strong class="text-typ-2">{{ $user->social_posts()->published()->count() }}</strong>
                    </div>
                    <div class="flex flex-col items-center py-3 px-3 text-16 text-typ-2 cursor-pointer">
                        <span class="text-typ-1 block">{{ translate('Articles') }}</span>
                        <strong class="text-typ-2">{{ $user->blog_posts()->published()->where('type', 'blog')->count() }}</strong>
                    </div>
                    <div class="flex flex-col items-center py-3 px-3 text-16 text-typ-2 cursor-pointer">
                        <span class="text-typ-1 block">{{ translate('Portfolios') }}</span>
                        <strong class="text-typ-2">{{ $user->portfolio()->published()->count() }}</strong>
                    </div>
                    <div class="flex flex-col items-center py-3 px-3 text-16 text-typ-2 cursor-pointer">
                        <span class="text-typ-1 block">{{ translate('Followers') }}</span>
                        <strong class="text-typ-2">{{ $user->followers()->count() }}</strong>
                    </div>
                    <div class="flex flex-col items-center py-3 px-3 text-16 text-typ-2 cursor-pointer">
                        <span class="text-typ-1 block">{{ translate('Following') }}</span>
                        <strong class="text-typ-2">{{ $user->follows_users()->count() }}</strong>
                    </div>
                </ul>
            </div>
        </div>
    </section>

    {{-- TODO: Add user stats for mobile somewhere!!! --}}

    <section class="grid grid-cols-12 gap-6 max-w-2xl md:max-w-full mx-auto">
        <div class="col-span-12 md:col-span-5 flex flex-col space-y-4">
            {{-- TODO: Shoud this go to blade template? --}}
            <div class="w-full bg-white rounded-xl shadow">
                <div class="w-full px-5 py-4 pb-3 mb-3 flex justify-between items-center border-b border-gray-200">
                    <h5 class="text-14 font-semibold">{{ translate('About me') }}</h5>

                    @livewire('actions.social-action-button', [
                        'object' => $user,
                        'action' => 'follow'
                    ])
                </div>
            
                <div class="px-5 pb-2 flex flex-col">
                    
                    <p class="text-12 text-typ-3">{{ $user->getUserMeta('short_about_me') }}</p>

                    @if($user->isVerified())
                        <x-feed.elements.verified-badge :item="$user" class="mt-3">
                        </x-feed.elements.verified-badge>
                    @endif

                    <div class="w-full flex justify-start text-sm whitespace-nowrap  mt-3">
                        <span class="text-typ-2 mr-1">{{ translate('Account type')}}:</span>
                        <span class="text-typ-3">
                            {{ $user->user_type === 'seller' ? translate('Creator') : translate('Standard') }}
                        </span>
                    </div>

                    @if($user->created_at)
                        <div class="w-full flex justify-start text-sm whitespace-nowrap  mt-2">
                            <span class="text-typ-2 mr-1">{{ translate('Joined')}}:</span>
                            <time datetime="{{ $user->created_at }}" class="text-typ-3">
                                {{ $user->created_at->diffForHumans() }}
                            </time>
                        </div>
                    @endif

                    {{-- TODO: Add a user setting - if user wants to disclose his/her email or phone! --}}
                    <div class="w-full flex justify-start text-sm whitespace-nowrap  mt-2">
                        <span class="text-typ-2 mr-1">{{ translate('Email')}}:</span>
                        <span class="text-typ-3">
                            {{ $user->email }}
                        </span>
                    </div>

                    @if(!empty($user->getUserMeta('website')))
                    <div class="w-full flex justify-start text-sm whitespace-nowrap  mt-2">
                        <span class="text-typ-2 mr-1">{{ translate('Website')}}:</span>
                        <a href="{{ $user->getUserMeta('website') }}" class="text-primary" target="_blank">
                            {{ $user->getUserMeta('website') }}
                        </a>
                    </div>
                    @endif
                </div>

                @php
                    $social_profiles_urls = $user->getUserMeta('social_profiles');
                    $pass = false;
                    if(!empty($social_profiles_urls)) {
                        foreach($social_profiles_urls as $key => $profile_url) {
                            $icon = collect(\App\Enums\AvailableSocialFieldsEnum::icons())->filter(fn($item, $social_key) => str_starts_with($key, $social_key))?->first() ?? null;
                            if(!empty($profile_url) && !empty($icon)) {
                                $pass = true;
                            }
                        }
                    }
                @endphp
                @if($pass)
                    <div class="px-5 pb-4 flex pt-3 mt-2 border-t border-gray-200 ">
                        @foreach($social_profiles_urls as $key => $profile_url)
                        @php
                            $icon = collect(\App\Enums\AvailableSocialFieldsEnum::icons())->filter(fn($item, $social_key) => str_starts_with($key, $social_key))?->first() ?? null;
                        @endphp
                            @if(!empty($profile_url) && !empty($icon))
                                <a href="{{ $profile_url }}" class="mr-3" target="_blank">
                                    @svg($icon['icon'], ['class' => 'w-5 h-5 text-['.$icon['color'].']'])
                                </a>
                            @endif
                        @endforeach
                    </div>
                @endif
            </div>

            <x-feed.elements.users.shop-card :user="$user" class="hidden md:block" />

            <x-feed.elements.users.portfolio :user="$user" class="hidden md:block" />

            <x-feed.elements.users.work-experience :user="$user" class="hidden md:block" />

            <x-feed.elements.users.education :user="$user" class="hidden md:block" />
        </div>

        <div class="col-span-12 md:col-span-7">
            <livewire:feed.user-profile-feed :user="$user" />
        </div>
    </section>

</div>
@endsection
