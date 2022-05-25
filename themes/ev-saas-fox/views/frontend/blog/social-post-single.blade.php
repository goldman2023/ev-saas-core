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

    <section class="w-full flex flex-col bg-white max-w-[876px] rounded-lg mt-5">
        <div class="w-full flex flex-col items-center relative py-[24px]">
            <strong class="text-14 text-[#55A4B9] uppercase">Get instant quote</strong>
            <h3 class="text-20 text-[#28415B] font-bold">What are you shipping?</h3>

            <div class="w-[280px] h-[72px] absolute top-0 right-0 bg-[#28415B] flex flex-col items-start justify-center pl-[57px]" style="
                    -webkit-clip-path: polygon(0 0, 0 100%, 100% 100%, 100% 25%, 75% 0);
                    clip-path: polygon(0 0, 100% 0, 100% 100%, 20% 100%);
                ">
                <div class="text-white uppercase text-14">
                    Shipping Insurance
                </div>
                <div class="text-12 text-white">
                    from <strong>$45 only!</strong>
                </div>
                <svg class="absolute right-[19px] top-[17px]" width="28" height="36" viewBox="0 0 28 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M14 35.5C9.91667 34.4792 6.5625 32.1094 3.9375 28.3906C1.3125 24.6719 0 20.5958 0 16.1625V5.75L14 0.5L28 5.75V16.1625C28 20.5958 26.6875 24.6719 24.0625 28.3906C21.4375 32.1094 18.0833 34.4792 14 35.5ZM14 32.7875C17.3542 31.6792 20.0885 29.5865 22.2031 26.5094C24.3177 23.4323 25.375 19.9833 25.375 16.1625V7.5875L14 3.3L2.625 7.5875V16.1625C2.625 19.9833 3.68229 23.4323 5.79688 26.5094C7.91146 29.5865 10.6458 31.6792 14 32.7875Z" fill="#EFF8FA"/>
                </svg>
            </div>
        </div>

        <div class="w-full relative py-[25px] px-6 opacity-60" :class="{'opacity-60 pointer-events-none':in_process}">
            <ul class="flex flex-row items-center justify-center flex-wrap">
                <li @click="vehicle = 12; show_form = true" :class="{'ring-2 ring-[#28415B]': vehicle == 12}" class="min-w-[165px] flex flex-col justify-center items-center py-[12px] border border-gray-200 px-3 cursor-pointer">
                    <img src="https://images.we-saas.com/insecure/fill/350/0/ce/0/plain/https://ev-saas.fra1.digitaloceanspaces.com/uploads/bf9205a4-3473-4472-953e-ec6a9dabbe85/1652775760_image%2034.png@webp" class="h-[56px] object-contain mb-[10px]"/>
                    <span class="text-[#28415B] uppercase text-12 font-[600]">Motorcycle</span>
                </li>

                {{-- Wrong ID --}}
                <li @click="vehicle = 18; show_form = true" :class="{'ring-2 ring-[#28415B]': vehicle == 18}" class="min-w-[165px] flex flex-col justify-center items-center py-[12px] border border-gray-200 px-1 cursor-pointer">
                    <img src="https://images.we-saas.com/insecure/fill/350/0/ce/0/plain/https://ev-saas.fra1.digitaloceanspaces.com/uploads/bf9205a4-3473-4472-953e-ec6a9dabbe85/1652775793_image%2031.png@webp" class="h-[56px] object-contain mb-[10px]"/>
                    <span class="text-[#28415B] uppercase text-12 font-[600]">Passenger car</span>
                </li>
                <li @click="vehicle = 14; show_form = true" :class="{'ring-2 ring-[#28415B]': vehicle == 14}" class="min-w-[165px] flex flex-col justify-center items-center py-[12px] border border-gray-200 cursor-pointer">
                    <img src="https://images.we-saas.com/insecure/fill/350/0/ce/0/plain/https://ev-saas.fra1.digitaloceanspaces.com/uploads/bf9205a4-3473-4472-953e-ec6a9dabbe85/1652775814_image%2030-2x.png@webp" class="h-[56px] object-contain mb-[10px]"/>
                    <span class="text-[#28415B] uppercase text-12 font-[600]">SUV</span>
                </li>

                {{-- Wrong ID --}}
                <li @click="vehicle = 19; show_form = true" :class="{'ring-2 ring-[#28415B]': vehicle == 19}" class="min-w-[165px] flex flex-col justify-center items-center py-[12px] border border-gray-200 px-1 cursor-pointer">
                    <img src="https://images.we-saas.com/insecure/fill/350/0/ce/0/plain/https://ev-saas.fra1.digitaloceanspaces.com/uploads/bf9205a4-3473-4472-953e-ec6a9dabbe85/1652775761_image%2032.png@webp" class="h-[56px] object-contain mb-[10px]"/>
                    <span class="text-[#28415B] uppercase text-12 font-[600]">Pickup</span>
                </li>

                {{-- Wrong ID --}}
                <li @click="vehicle = 20; show_form = true" :class="{'ring-2 ring-[#28415B]': vehicle == 20}" class="min-w-[165px] flex flex-col justify-center items-center py-[12px] border border-gray-200 px-2 cursor-pointer">
                    <img src="https://images.we-saas.com/insecure/fill/350/0/ce/0/plain/https://ev-saas.fra1.digitaloceanspaces.com/uploads/bf9205a4-3473-4472-953e-ec6a9dabbe85/1652775761_Screenshot%202022-05-01%20at%2011.58%201.png@webp" class="h-[56px] object-contain mb-[10px]"/>
                    <span class="text-[#28415B] uppercase text-12 font-[600]">Van</span>
                </li>
            </ul>
        </div>

        {{-- Form --}}
        <div class="w-full relative py-[25px] px-6 " :class="{'opacity-60 pointer-events-none':in_process}" x-show="show_form" x-collapse>
            <div class="w-full">
                <h3 class="text-16 font-[600] pb-3 text-[#28415B]">Shipping information</h3>

                <div class="flex flex-row items-center flex-wrap md:flex-nowrap">
                    <div class="flex rounded-md shadow-sm flex-auto md:flex-1 mb-4 md:mb-0">
                        <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-[#28415B] text-14 font-[600]"> From: </span>
                        <select x-model="from" class="flex-1 min-w-0 block w-full px-3 py-2 rounded-none rounded-r-md focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border-gray-300">
                            <option value="" disabled selected>Select your option...</option>
                            <template x-for="port in ports">
                                <option x-bind:value="port.id" x-text="port.text" x-bind:disabled="to == port.id"></option>
                            </template>
                        </select>
                    </div>

                    <span class="hidden md:inline px-3">
                        <svg width="14" height="8" viewBox="0 0 14 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M10.3333 1.12476L13 3.79437M13 3.79437L10.3333 6.46399M13 3.79437L1 3.79437" stroke="#28415B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </span>

                    <div class="flex rounded-md shadow-sm flex-auto md:flex-1">
                        <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-[#28415B] text-14 font-[600]"> To: </span>
                        <select x-model="to" class="flex-1 min-w-0 block w-full px-3 py-2 rounded-none rounded-r-md focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border-gray-300">
                            <option value="" disabled selected>Select your option...</option>
                            <template x-for="port in ports">
                                <option x-bind:value="port.id" x-text="port.text" x-bind:disabled="from == port.id"></option>
                            </template>
                        </select>
                    </div>
                </div>

                <div class="w-full relative flex items-start py-6">
                    <div class="flex items-center h-5">
                      <input id="pickup_needed_checkbox" x-model="pickup_needed" type="checkbox" class="cursor-pointer focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded">
                    </div>
                    <div class="ml-3 text-sm">
                      <label for="pickup_needed_checkbox" class="cursor-pointer font-medium text-gray-700">Vehicle pickup needed</label>
                      <p class="text-gray-500">We use local transport to pick up your car and store it in a warehouse before in_process it to the ship.</p>
                    </div>
                </div>
            </div>

            <div class="w-full">
                <h3 class="text-16 font-[600] pb-3 text-[#28415B]">Contact information</h3>
                <div class="flex flex-row items-center">
                    <div class="flex rounded-md shadow-sm flex-1 md:pr-8">
                        <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-[#28415B] text-14 font-[600]"> Email: </span>
                        <input x-model="email" type="text"  class="flex-1 min-w-0 block w-full px-3 py-2 rounded-none rounded-r-md focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border-gray-300">
                    </div>
                    <div class="hidden md:block flex-1"></div>
                </div>
            </div>
        </div>

        <div class="w-full flex items-center justify-between relative pb-[25px] px-6">
            <div class="flex text-14">
                <span class="">Need other type of cargo?</span>
                <a href="" class="text-[#5EB6CE] ml-1">Other services</a>
            </div>
            <div @click="requestQuote()" x-cloak class="cursor-pointer rounded py-[9px] px-[17px] bg-[#5EB6CE] text-white text-16 uppercase font-bold tracking-[-0.02em]">
                <span x-show="in_process">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-[22px] h-[22px]" width="38" height="38" viewBox="0 0 38 38">
                        <defs>
                            <linearGradient x1="8.042%" y1="0%" x2="65.682%" y2="23.865%" id="a">
                                <stop stop-color="#fff" stop-opacity="0" offset="0%"/>
                                <stop stop-color="#fff" stop-opacity=".631" offset="63.146%"/>
                                <stop stop-color="#fff" offset="100%"/>
                            </linearGradient>
                        </defs>
                        <g fill="none" fill-rule="evenodd">
                            <g transform="translate(1 1)">
                                <path d="M36 18c0-9.94-8.06-18-18-18" id="Oval-2" stroke="url(#a)" stroke-width="2">
                                    <animateTransform attributeName="transform" type="rotate" from="0 18 18" to="360 18 18" dur="0.9s" repeatCount="indefinite"/>
                                </path>
                                <circle fill="#fff" cx="36" cy="18" r="1">
                                    <animateTransform attributeName="transform" type="rotate" from="0 18 18" to="360 18 18" dur="0.9s" repeatCount="indefinite"/>
                                </circle>
                            </g>
                        </g>
                    </svg>
                </span>

                <span x-show="!in_process">
                    Request a Quote
                </span>
            </div>
        </div>
    </section>
</div>
@endsection
