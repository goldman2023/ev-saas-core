@extends('frontend.layouts.feed')

@section('meta')
<x-default.products.single.head-meta-tags :product="$product"></x-default.products.single.head-meta-tags>
@endsection

@push('head_scripts')
    @if($course_item->type === \App\Enums\CourseItemTypes::quizz()->value)
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"
            integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

        <link href="https://unpkg.com/survey-jquery@1.9.33/modern.css" type="text/css" rel="stylesheet" />
        <script src="https://unpkg.com/survey-jquery@1.9.33/survey.jquery.min.js"></script>

        <style>

        </style>
    @endif
@endpush

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
        init() {
            if(this.course_items_type === 'video') {
                this.getEmbed();
            }
        },
        getEmbed() {
            if(this.course_items_type === 'video') {
                if(this.course_item.content.includes('youtube')) {
                    this.video_data = `
                        <iframe width='640' height='360' src='${this.course_item.content}' frameborder='0' allow='accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture' allowfullscreen></iframe>
                    `;
                } else if(this.course_item.content.includes('vimeo')) {
                    fetch('https://vimeo.com/api/oembed.json?url='+encodeURIComponent(this.course_item.content), {
                        method: 'GET',
                        cache: 'no-cache', 
                        mode: 'cors',
                    })
                    .then(response => response.json())
                    .then(data => this.video_data = data.html);
                } else {
                    this.video_data = `
                        <iframe width='640' height='360' src='${this.course_item.content}' frameborder='0' allow='accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture' allowfullscreen></iframe>
                    `;
                }
            }
        }
    }" x-init="init()">
        <div class="col-span-12 md:col-span-8">
            <div class="w-full bg-white rounded-xl shadow overflow-y-auto">
                @if(!empty($course_item->cover) && $course_item->type !== \App\Enums\CourseItemTypes::video()->value)
                    <div class="w-full pb-8">
                        <img class="w-full h-full max-h-[460px] object-cover" src="{{ !empty($course_item->cover) ? $course_item->getCover(['w' => 0, 'h' => 600]) : $course_item->getTHumbnail(['w' => 0, 'h' => 600]) }}" alt="" />
                    </div>
                @endif

                @if($course_item->type === \App\Enums\CourseItemTypes::video()->value)
                    <div class="w-full pb-4" >
                        <div class="aspect-w-16 aspect-h-9 " x-html="video_data"></div>
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
                            <div class="w-full" id="we-quiz-container"></div>

                            <script>
                                $(function() {
                                    Survey.StylesManager.applyTheme('modern');

                                    var surveyJSON = @js($course_item->subject->quiz_json ?? []);

                                    var survey = new Survey.Model(surveyJSON);
                                    
                                    function sendDataToServer(survey) {
                                        // Send Ajax request to your web server
                                        fetch('{{ route('api.we-quiz.result.save', $course_item->subject->id) }}', {
                                            method: 'POST',
                                            headers: {
                                                'Content-Type': 'application/json'
                                            },
                                            body: JSON.stringify({
                                                'user_id': {{ auth()->user()->id }},
                                                'answers': survey.data,
                                            }),
                                        })
                                        .then(response => response.json())
                                        .then(data => {
                                            if(data.error !== undefined) {
                                                alert(data.error.message);
                                            }
                                        });
                                        // alert('The results are: ' + JSON.stringify(survey.data));
                                    }

                                    $('#we-quiz-container').Survey({
                                        model: survey,
                                        onComplete: sendDataToServer
                                    });

                                    survey.completedHtml =  '{{ translate('You completed the quiz!') }}';
                                    survey.showPreviewBeforeComplete = 'showAllQuestions';

                                    ;
                                });
                            </script>
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
                                @include('frontend.product.single.partials.course-item-list-template', ['product' => $product, 'course_item' => $course_item])
                            @endforeach
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>


    <x-system.form-modal id="gated-content-cta-modal" title="{{ translate('Want to access the full course?') }}" class="sm:max-w-2xl">
        <div class="w-full flex flex-col">
            {{-- <h3 class="w-full text-22 mb-2"></h3> --}}
            <p class="text-16 mb-4">{{ translate('Join now and buy this course to have an access to content') }}</p>

            <div class="w-full flex gap-4">
                <a href="{{ route('user.login') }}" class="btn-primary">
                    {{ translate('Log in') }}
                </a>
                <a href="{{ route('user.registration') }}" class="btn-primary-outline">
                    {{ translate('Join now') }}
                </a>
            </div>
        </div>
    </x-system.form-modal>
@endsection