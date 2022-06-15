@extends('frontend.layouts.feed')

@section('meta')
<x-default.products.single.head-meta-tags :product="$product"></x-default.products.single.head-meta-tags>
@endsection

@section('feed_content')
    <div class="grid grid-cols-12 gap-10 col-span-12" x-data="{
        qty: 1,
        total_price: {{ $product->total_price }},
        total_price_display: '{{ $product->getTotalPrice(true) }}',
        base_price: {{ $product->base_price }},
        base_price_display: '{{ $product->getBasePrice(true) }}',
    }">
        <div class="col-span-12 md:col-span-8">
            <div class="w-full bg-white rounded-xl shadow overflow-y-auto">
                <div class="w-full pb-8">
                    <img class="w-full h-full max-h-[460px] object-cover" src="{{ !empty($product->cover) ? $product->getCover(['w' => 0, 'h' => 600]) : $product->getTHumbnail(['w' => 0, 'h' => 600]) }}" alt="" />
                </div>

                {{-- Product Header --}}
                <div class="w-full flex flex-row items-center px-7 pb-5">
                    <div class="flex flex-col frow-1">
                        <h1 class="text-24 leading-[36px] font-semibold text-typ-1">{{ $product->name }}</h1>

                        <div class="flex flex-row flex-wrap items-center justify-start divide-x">
                            {{-- Shop --}}
                            <a href="{{ $product->shop?->getPermalink() ?? '#' }}" class="pr-3 inline-flex items-center text-14 font-semibold text-typ-2">
                                <img src="{{ $product->shop->getThumbnail(['w' => 600]) }}" 
                                    class="w-[30px] h-[30px] object-cover rounded-full border border-gray-200 mr-2"/>

                                <span>{{ $product->shop?->name }}</span>
                            </a>

                            {{-- Categories --}}
                            @if($product->categories->isNotEmpty())
                                <ul class="flex items-center px-2">
                                    @foreach($product->categories as $category)
                                        <li class="text-14 text-typ-3">{{ $category->name }}</li>
                                    @endforeach
                                </ul>
                            @endif

                            {{-- Follow shop --}}
                            <div class="pl-3">
                                @livewire('actions.social-action-button', [
                                    'object' => $product->shop,
                                    'action' => 'follow',
                                    'action_text' => translate('Follow shop'),
                                    'action_text_success' => translate('Following shop'),
                                    'class' => 'text-12 mt-[3px]'
                                ])
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Product Info --}}
                <div class="w-full flex flex-col items-center px-7 pb-8">

                    {{-- Excerpt --}}
                    @if(!empty($product->excerpt))
                        <p class="w-full text-gray-500 mb-4">
                            {!! $product->excerpt !!}
                        </p>
                    @endif

                    {{-- Price and Buy --}}
                    <div class="w-full flex justify-between py-2 border-y border-gray-200 mb-5" >
                        <livewire:tenant.product.price :model="$product" :with_label="true" :with-discount-label="true"
                            original-price-class="text-body text-16" base-price-class="text-16" total-price-class="text-20 fw-700 text-primary">
                        </livewire:tenant.product.price>

                        <div class="">
                            @if(\Payments::isStripeEnabled() && \Payments::isStripeCheckoutEnabled())
                                <x-system.buy-now-button :model="$product" class="" label="{{ translate('Buy now') }}"
                                    label-not-in-stock="{{ translate('Not in stock') }}">
                                </x-system.buy-now-button>
                            @else
                                <x-system.add-to-cart-button :model="$product" class="" label="{{ translate('Add to cart') }}"
                                    label-not-in-stock="{{ translate('Not in stock') }}">
                                </x-system.add-to-cart-button>
                            @endif
                        </div>
                    </div>

                    {{-- What you'll learn --}}
                    @if(!empty($product->getCoreMeta('course_what_you_will_learn')))
                        <div class="w-full border border-gray-200 p-4 mb-5">
                            <h4 class="text-18 font-bold mb-4">{{ translate('What you\'ll learn') }}</h4>
                            <ul class="w-full grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-2 items-start">
                                @foreach($product->getCoreMeta('course_what_you_will_learn') as $skill)
                                    <li class="text-14 text-typ-2 flex items-start">
                                        @svg('heroicon-s-check', ['class' => 'shrink-0 w-4 h-4 mr-2 mt-1'])
                                        <span class="">{{ $skill }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- Requirements --}}
                    @if(!empty($product->getCoreMeta('course_requirements')))
                        <div class="w-full mb-4">
                            <h4 class="text-18 font-bold mb-2">{{ translate('Requirements') }}</h4>

                            <ul class="w-full flex flex-col list-disc pl-5 space-y-1">
                                @foreach($product->getCoreMeta('course_requirements') as $req)
                                    <li class="text-14 text-typ-1">
                                        <span class="">{{ $req }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- Description --}}
                    <div class="w-full">
                        <h4 class="text-18 font-bold mb-4">{{ translate('Description') }}</h4>

                        <div class="w-full">
                            {!! $product->description !!}
                        </div>
                    </div>

                    {{-- Target audience --}}
                    @if(!empty($product->getCoreMeta('course_target_audience')))
                        <div class="w-full mt-4">
                            <h4 class="text-18 font-bold mb-2">{{ translate('Who this course is for') }}:</h4>

                            <ul class="w-full flex flex-col list-disc pl-5 space-y-1">
                                @foreach($product->getCoreMeta('course_target_audience') as $target)
                                    <li class="text-14 text-typ-1">
                                        <span class="">{{ $target }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-span-12 md:col-span-4">
            {{-- Course Right Card --}}
            <div class="w-full flex flex-col bg-white rounded-xl shadow p-5 mb-5">
                <div class="w-full flex items-center mb-3">
                    <strong class="text-28 font-semibold text-gray-900 mb-0" x-text="total_price_display"> </strong>

                    <span class="text-18 font-semibold line-through text-gray-400 ml-3" x-show="base_price !== total_price">
                        <del x-text="base_price_display"></del>
                    </span>

                    <span x-data="{}"
                        class="badge-success px-2 py-2 ml-2 !text-14 items-center !font-semibold"
                        :class="{ 'flex': base_price !== total_price, 'hidden': base_price === total_price }">
                        @svg('heroicon-s-tag', ['class' => 'w-4 h-4 mr-1'])
                        <span x-text="'{{ translate('%x%%') }}'.replace('%x%', (100-(100*total_price/base_price)).toFixed(0) )"></span>
                    </span>
                </div>
                
                <div class="w-full mb-4">
                    @if(\Payments::isStripeEnabled() && \Payments::isStripeCheckoutEnabled())
                        <x-system.buy-now-button :model="$product" class="" label="{{ translate('Buy now') }}"
                            label-not-in-stock="{{ translate('Not in stock') }}">
                        </x-system.buy-now-button>
                    @else
                        <x-system.add-to-cart-button :model="$product" class="" label="{{ translate('Add to cart') }}"
                            label-not-in-stock="{{ translate('Not in stock') }}">
                        </x-system.add-to-cart-button>
                    @endif
                </div>

                {{-- Course Includes --}}
                @if(!empty($product->getCoreMeta('course_includes')))
                <div class="w-full">
                    <h4 class="text-16 font-bold mb-2">{{ translate('This course includes') }}:</h4>

                    <ul class="w-full flex flex-col list-disc pl-5 space-y-1">
                        @foreach($product->getCoreMeta('course_includes') as $inc)
                            <li class="text-14 text-typ-1">
                                <span class="">{{ $inc }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
            </div>

            {{-- Chapters --}}
            <div class="w-full bg-white rounded-xl shadow p-5 max-h-[500px] overflow-y-auto">
                <div class="w-full pb-3 mb-3 flex justify-between items-center border-b border-gray-200">
                    <h5 class="text-14 font-semibold">{{ translate('Chapters') }}</h5>
                </div>

                <div class="pb-3 w-full">
                    <ul class="w-full flex-flex-col space-y-3">
                        @if($course_items->isNotEmpty())
                            @foreach($course_items as $course_item)
                                @php course_item_template($course_item, $product); @endphp
                            @endforeach
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection

<?php
    function course_item_template($course_item, $product)  {
?>
    <li class="w-full flex flex-col">
        <div class="flex items-center justify-between">
            {{-- TODO: Link to chapter if it's free, link to chapter if it's bought, display gated content modal or redirect to checkout link in order to buy course --}}
            @if($course_item->children?->isNotEmpty() ?? null)
                <div class="inline-flex items-center text-14">
                    {{ $course_item->name }}
                </div>
            @else
                <a href="{{ route(\App\Models\CourseItem::getRouteName(), [
                    'product_slug' => $product->slug, 
                    'slug' => $course_item->slug
                ]) }}" class="inline-flex items-center text-14">
                    @svg('heroicon-s-play', ['class' => 'w-4 h-4 mr-2'])

                    {{ $course_item->name }}

                    @if($course_item->free)
                        <span class="badge-success ml-2">{{ translate('Free') }}</span>
                    @endif
                </a>
            @endif
            
        </div>
        
        @if($course_item->children?->isNotEmpty() ?? null)
            <ul class="w-full flex-flex-col space-y-2 mt-2 mb-2 pt-2 border-t border-gray-200 pl-4">
                {{-- TODO: Fix ->tree() function when using hasMany relationship! Only then `depth` is available --}}
                {{-- {{ 'p-'.($course_item->children->first()->depth*3)  }} --}}
                <?php foreach($course_item->children as $child) { 
                    course_item_template($child, $product);
                } ?>
            </ul>
        @endif
    </li>
<?php
    }
?>