@extends('frontend.layouts.feed')

@section('meta')
<x-default.products.single.head-meta-tags :product="$product"></x-default.products.single.head-meta-tags>
@endsection

@section('feed_content')
    <div class="grid grid-cols-12 gap-10 col-span-12" x-data="{
        course_item: @js($course_item ?? []),
        qty: 1,
        total_price: {{ $product->total_price }},
        total_price_display: '{{ $product->getTotalPrice(true) }}',
        base_price: {{ $product->base_price }},
        base_price_display: '{{ $product->getBasePrice(true) }}',
        course_items_type: @js($course_item->type),
        video_data: null,
        getEmbed() {
            if(this.course_items_type === 'video') {
                fetch('https://vimeo.com/api/oembed.json?url='+encodeURIComponent(this.course_item.content), {
                    method: 'GET',
                    cache: 'no-cache', 
                    mode: 'cors',
                })
                .then(response => response.json())
                .then(data => this.video_data = data);
            }
        }
    }" x-init="getEmbed()">
        <div class="col-span-12 md:col-span-8">
            <div class="w-full bg-white rounded-xl shadow overflow-y-auto">
                @if(!empty($course_item->cover) && $course_item->type !== \App\Enums\CourseItemTypes::video()->value)
                    <div class="w-full pb-8">
                        <img class="w-full h-full max-h-[460px] object-cover" src="{{ !empty($course_item->cover) ? $course_item->getCover(['w' => 0, 'h' => 600]) : $course_item->getTHumbnail(['w' => 0, 'h' => 600]) }}" alt="" />
                    </div>
                @endif

                @if($course_item->type === \App\Enums\CourseItemTypes::video()->value)
                    <div class="w-full pb-4" >
                        <div class="aspect-w-16 aspect-h-9 " x-html="_.get(video_data, 'html', '')"></div>
                    </div>
                @endif

                {{-- Product Header --}}
                <div class="w-full flex flex-row items-center px-7 pb-5 @if(empty($course_item->cover) && $course_item->type !== \App\Enums\CourseItemTypes::video()->value) pt-5 @endif">
                    <div class="flex flex-col frow-1">
                        <h1 class="text-24 leading-[36px] font-semibold text-typ-1">
                            {{ $course_item->name }}
                            @if($course_item->free)
                                <span class="badge-success ml-2">{{ translate('Free') }}</span>
                            @endif
                        </h1>

                        <div class="flex flex-row flex-wrap items-center justify-start divide-x">
                            {{-- Course --}}
                            <a href="{{ $product->getPermalink() ?? '#' }}" class="pr-3 inline-flex items-center text-14 font-semibold text-typ-2">
                                <span class="mr-1 font-medium">{{ translate('Course') }}:</span>
                                <span>{{ $product?->name }}</span>
                            </a>

                            {{-- Shop --}}
                            <a href="{{ $product->shop?->getPermalink() ?? '#' }}" class="px-3 inline-flex items-center text-14 font-semibold text-typ-2">
                                <img src="{{ $product->shop->getThumbnail(['w' => 600]) }}" 
                                    class="w-[30px] h-[30px] object-cover rounded-full border border-gray-200 mr-2"/>

                                <span>{{ $product->shop?->name }}</span>
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Product Info --}}
                <div class="w-full flex flex-col items-center px-7 pb-8">

                    {{-- Excerpt --}}
                    @if(!empty($course_item->excerpt))
                        <p class="w-full text-gray-500 pb-3 mb-3 border-b border-gray-200">
                            {!! $course_item->excerpt !!}
                        </p>
                    @endif

                    <div class="w-full">
                        @if($course_item->type === \App\Enums\CourseItemTypes::video()->value)

                        @elseif($course_item->type === \App\Enums\CourseItemTypes::quizz()->value)

                        @elseif($course_item->type === \App\Enums\CourseItemTypes::wysiwyg()->value)
                            {!! $course_item->content !!}
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="col-span-12 md:col-span-4">
            

            {{-- Chapters --}}
            <div class="w-full bg-white rounded-xl shadow p-5 max-h-[500px] overflow-y-auto">
                <div class="w-full pb-2 mb-2 flex justify-between items-center border-b border-gray-200">
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
