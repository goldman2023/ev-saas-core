@extends('frontend.layouts.feed')

{{-- @section('meta_title'){{ $social_post->name.' | '.get_site_name() }}@endsection --}}

@section('meta')
    {{-- <x-tailwind-ui.blog.blog-post-head-meta-tags :blog-post="$social_post"></x-tailwind-ui.blog.blog-post-head-meta-tags> --}}
@endsection

@section('feed_content')
<div class="col-span-12" x-data="{
    show_form: false,
    vehicle: null,
    ports: [],
    from: null,
    to: null,
    email: null,
    pickup_needed: false,
    in_process: false,
    initForm() {
        fetch('https://client.atlanticexpresscorp.com/common-data-ajax/get-ports-with-country', {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            },
        })
            .then(response => response.json())
            .then(data => this.ports = data.items);
    },
    requestQuote() {
        this.in_process = true;

        const formData  = new FormData();
        formData.append('email', this.email);
        formData.append('commodity_type', 1);
        formData.append('vehicle_type', this.vehicle);
        formData.append('to_port', this.to);
        formData.append('from_branch', this.from);
        formData.append('vehicle_pickup_is_needed', this.pickup_needed);

        fetch('https://client.atlanticexpresscorp.com/api/quote-request/', {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Content-Type': 'multipart/form-data'
            },
            body: formData,
        })
            .then(response => response.json())
            .then(data => {
                this.in_process = false;
                console.log(data)
            });
    }
}" x-init="initForm()">
    <section class="grid grid-cols-12 gap-6 max-w-2xl md:max-w-full mx-auto">
        <div class="bg-white col-span-12 md:col-span-8 flex flex-col space-y-4 border border-gray-200 rounded-xl overflow-x-hidden">
            {{-- Image --}}
            @if(!empty($social_post->thumbnail))
            <div class="w-full mb-3">
                <x-tenant.system.image class="block max-h-[300px] sm:max-h-[300px] md:max-h-[340px] h-full w-full rounded-t-xl " fit="cover" :image="$social_post->getThumbnail(['w' => '900'])" />
            </div>
            @endif

            <div class="w-full flex items-center px-5 pb-5 @if(empty($social_post->thumbnail)) pt-5 @endif">
                <a href="{{ $author->getPermalink() }}" class="">
                    <x-tenant.system.image alt="{{ get_site_name() }} logo"
                        class="ring-2 ring-indigo-400 bg-white h-[50px] w-[50px] rounded-full mr-3" fit="contain"
                        :image="$author->getThumbnail(['w' => 100])">
                    </x-tenant.system.image>
                </a>


                {{-- Authors --}}
                <div class="flex flex-col">
                    <h3 class="flex items-center mb-0 text-18 font-bold text-typ-1">
                        <a href="{{ $author->getPermalink() }}" class="text-14 font-bold text-typ-1">
                            {{ $author->name.' '.$author->surname }}
                        </a>
                    </h3>
                    <div class="flex items-center text-sm font-medium text-typ-3 text-12">
                        {{ translate('Posted on').' '.$social_post->created_at->format('d M, Y') }}
                    </div>
                </div>
            </div>

            {{-- Title & Content--}}
            <div class="flex flex-col px-6 sm:px-8">
                <div class="w-full wysiwyg_content">
                    {!! $social_post->content !!}
                </div>
            </div>

            {{-- Comments --}}
            <div class="flex flex-col px-5 py-4 mt-4 border-t border-gray-200">
                <h3 class="text-lg font-bold mb-3">
                    {{ translate('Discussion') }} ({{ $social_post->comments->count() }})
                </h3>

                <livewire:actions.social-comments :item="$social_post">
                </livewire:actions.social-comments>
            </div>
        </div>

        {{-- Right Column --}}
        <div class="col-span-12 md:col-span-4">
            {{-- @if(!empty($shop))
                <x-feed.elements.users.shop-card :shop="$shop" class="mb-5" />
            @endif --}}

            @if($latest_social_posts->isNotEmpty())
            {{-- Recent --}}
            <div class="w-full bg-white rounded-xl shadow">
                <div class="w-full px-5 py-4 mb-5 flex justify-between border-b border-gray-200">
                    <h5 class="text-14 font-semibold">{{ translate('Latest Posts') }}</h5>
                </div>

                <div class="px-5 pb-4 flex flex-col">
                    @foreach($latest_social_posts as $social_post)
                        <x-tailwind-ui.blog.blog-post-card :blog-post="$social_post" template="social" />
                    @endforeach
                </div>

                <div class="w-full border-t border-gray-200 flex justify-center">
                    <a href="{{ route('feed.trending') }}" class="text-typ-3 hover:underline w-full py-2 text-14 text-center">
                        {{ translate('See trending') }}
                    </a>
                </div>
            </div>
            @endif


        </div>
    </section>
</div>
@endsection
