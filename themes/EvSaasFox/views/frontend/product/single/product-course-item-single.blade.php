@extends('frontend.layouts.no-sidebar')

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
                if(this.course_item.video.includes('youtube')) {
                    this.video_data = `
                        <iframe width='640' height='360' src='${this.course_item.video}' frameborder='0' allow='accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture' allowfullscreen></iframe>
                    `;
                } else if(this.course_item.video.includes('vimeo')) {
                    fetch('https://vimeo.com/api/oembed.json?url='+encodeURIComponent(this.course_item.video)+'&width=640&height=360', {
                        method: 'GET',
                        cache: 'no-cache',
                        mode: 'cors',
                    })
                    .then(response => response.json())
                    .then(data => this.video_data = data.html);
                } else {
                    this.video_data = `
                        <iframe width='640' height='360' src='${this.course_item.video}' frameborder='0' allow='accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture' allowfullscreen></iframe>
                    `;
                }
            }
        }
    }" x-init="init()">
    <div class="col-span-12 md:col-span-8">
        <div class="w-full bg-white rounded-xl shadow overflow-y-auto mb-4">
            @if(!empty($course_item->cover) && $course_item->type !== \App\Enums\CourseItemTypes::video()->value)
            <div class="w-full pb-8">
                <img class="w-full h-full max-h-[460px] object-cover"
                    src="{{ !empty($course_item->cover) ? $course_item->getCover(['w' => 0, 'h' => 600]) : $course_item->getTHumbnail(['w' => 0, 'h' => 600]) }}"
                    alt="" />
            </div>
            @endif

            @if($course_item->type === \App\Enums\CourseItemTypes::video()->value)
            <div class="w-full pb-4">
                <div class="aspect-w-16 aspect-h-9 " x-html="video_data"></div>
            </div>
            @endif

            {{-- Product Header --}}
            <div
                class="w-full flex flex-row items-center px-7 pb-5 @if(empty($course_item->cover) && $course_item->type !== \App\Enums\CourseItemTypes::video()->value) pt-5 @endif">
                <div class="flex flex-col frow-1">
                    <h1 class="text-24 leading-[36px] font-semibold text-typ-1">
                        {{ $course_item->name }}
                        @if($course_item->free)
                        <span class="badge-success ml-2">{{ translate('Free') }}</span>
                        @endif
                    </h1>

                    <div class="flex flex-row flex-wrap items-center justify-start divide-x">
                        {{-- Course --}}
                        <a href="{{ $product->getPermalink() ?? '#' }}"
                            class="pr-3 inline-flex items-center text-14 font-semibold text-typ-2">
                            <span class="mr-1 font-medium">{{ translate('Course') }}:</span>
                            <span>{{ $product?->name }}</span>
                        </a>

                        {{-- Shop --}}
                        <a href="{{ $product->shop?->getPermalink() ?? '#' }}"
                            class="px-3 inline-flex items-center text-14 font-semibold text-typ-2">
                            <img src="{{ $product->shop->getThumbnail(['w' => 600]) }}"
                                class="w-[30px] h-[30px] object-cover rounded-full border border-gray-200 mr-2" />

                            <span>{{ $product->shop?->name }}</span>
                        </a>
                    </div>
                </div>
            </div>

            {{-- Product Info --}}
            <div class="w-full flex flex-col items-center px-6 pb-8">

                @include('frontend.product.single.partials.course-purchase-cta', [
                'product' => $product,
                'course_items' => $course_items,
                'showing_single_course_item' => true
                ])

                {{-- Excerpt --}}
                @if(!empty($course_item->excerpt))
                <p class="w-full text-gray-500 pb-3 mb-3 border-b border-gray-200">
                    {!! $course_item->excerpt !!}
                </p>
                @endif

                <div class="w-full mb-2">
                    @if($course_item->type === \App\Enums\CourseItemTypes::video()->value)

                    @elseif($course_item->type === \App\Enums\CourseItemTypes::quizz()->value)

                    @if(!empty($quiz_result))
                    <h2 class="pb-4 text-20 font-semibold">{{ translate('My quiz results:') }}</h2>

                    <div class="w-full" id="we-quiz-result-container"></div>

                    <script>
                        $(function() {
                                        Survey.StylesManager.applyTheme('modern');

                                        window.survey = new Survey.Model(@js($course_item->subject->quiz_json));

                                        survey.onComplete.add(function (sender) {
                                            document.querySelector('#we-quiz-result-container').textContent = "Result JSON:\n" + JSON.stringify(sender.data, null, 3);
                                        });
                                        survey.data = @js($quiz_result->quiz_answers);
                                        survey.mode = "display";
                                        survey.questionsOnPageMode = "singlePage";
                                        survey.showNavigationButtons = "none";
                                        survey.showProgressBar = "off";
                                        survey.showTimerPanel = "none";
                                        survey.maxTimeToFinishPage = 0;
                                        survey.maxTimeToFinish = 0;

                                        const correctStr = "{{ translate('Correct') }}";
                                        const inCorrectStr = "{{ translate('Incorrect') }}";
                                        function getTextHtml(text, str, isCorrect) {
                                        if (text.indexOf(str) < 0)
                                            return undefined;

                                        return text.substring(0, text.indexOf(str)) + "<span style='color:" + (
                                            isCorrect
                                            ? "green"
                                            : "red"
                                        ) + "'>" + str + "</span>";
                                        }
                                        function isAnswerCorrect(q) {
                                            const right = q.correctAnswer;

                                            if (! right || q.isEmpty())
                                                return undefined;

                                            var left = q.value;

                                            if (!Array.isArray(right))
                                                return right == left;

                                            if (!Array.isArray(left))
                                                left = [left];

                                            for (var i = 0; i < left.length; i++) {
                                                if (right.indexOf(left[i]) < 0)
                                                    return false;
                                            }

                                            return true;
                                        }
                                        function renderCorrectAnswer(q) {
                                            if (! q)
                                                return;

                                            const isCorrect = isAnswerCorrect(q);
                                            if (! q.prevTitle) {
                                                q.prevTitle = q.title;
                                            }
                                            if (isCorrect === undefined) {
                                                q.title = q.prevTitle;
                                            }
                                            q.title = q.prevTitle + ' ' + (
                                                isCorrect
                                                ? correctStr
                                                : inCorrectStr
                                            );
                                        }
                                        survey.onValueChanged.add((sender, options) => {
                                            renderCorrectAnswer(options.question);
                                        });
                                        survey.onTextMarkdown.add((sender, options) => {
                                            var text = options.text;
                                            var html = getTextHtml(text, correctStr, true);
                                            if (! html) {
                                                html = getTextHtml(text, inCorrectStr, false);
                                            }
                                            if (!! html) {
                                                options.html = html;
                                            }
                                        });

                                        survey.getAllQuestions().forEach(q => renderCorrectAnswer(q));
                                        $("#we-quiz-result-container").Survey({model: survey});
                                    });
                    </script>
                    @else
                    <div class="w-full" id="we-quiz-container"></div>

                    <script>
                        $(function() {
                                        Survey.StylesManager.applyTheme('modern');

                                        var surveyJSON = @js($course_item->subject->quiz_json ?? []);

                                        var survey = new Survey.Model(surveyJSON);

                                        function sendDataToServer(survey) {
                                            // Send Ajax request to your web server
                                            fetch('{{ route('api.we-quiz.result.save', $course_item->subject?->id ?? -1) }}', {
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
                    @endif


                    @elseif($course_item->type === \App\Enums\CourseItemTypes::wysiwyg()->value)
                    {!! $course_item->content !!}
                    @endif
                </div>
            </div>
        </div>

        <div class="w-full bg-white rounded-xl shadow overflow-y-auto px-6 py-6">
            <div class="w-full">
                {{-- Comments --}}
                <h3 class="text-lg font-bold mb-3">
                    {{ translate('Comments and Questions') }} ({{ $course_item->comments->count() }})
                </h3>
                <livewire:actions.social-comments :item="$course_item">
                </livewire:actions.social-comments>
            </div>
        </div>


    </div>



    <div class="col-span-12 md:col-span-4">
        {{-- Chapters --}}
        <div class="w-full bg-white rounded-xl shadow p-5 max-h-[500px] overflow-y-auto mb-6">
            <div class="w-full pb-2 mb-2 flex justify-between items-center border-b border-gray-200">
                <h5 class="text-14 font-semibold">{{ translate('Chapters') }}</h5>
            </div>

            <div class="pb-3 w-full">
                <ul class="w-full flex-flex-col space-y-3">
                    @if($course_items->isNotEmpty())
                    @foreach($course_items as $course_item)
                    @include('frontend.product.single.partials.course-item-list-template',
                    [
                        'product' => $product,
                        'course_item' => $course_item,
                        'current_course_item' => $active_course_item,
                    ])
                    @endforeach
                    @endif
                </ul>
            </div>
        </div>
        <div class="col-span-12 md:col-span-4 mb-6">
            <a href="{{ route(\App\Models\CourseItem::getRouteName(), [
                'product_slug' => $product->slug,
                'slug' => $course_items->first()?->slug ?? ' ',
            ]) }}" class="w-full btn-success">
                {{ translate('Next') }}
            </a>
        </div>
        @auth
            @if(auth()->user()->manages($product) ?? false)
            {{-- Course Stats --}}
            <div class="w-full bg-white rounded-xl shadow p-5 max-h-[500px] overflow-y-auto">
                <div class="w-full pb-2 mb-2 flex justify-between items-center border-b border-gray-200">
                    <h5 class="text-14 font-semibold">{{ translate('Manage Course') }}</h5>
                </div>

                <div class="pb-3 w-full">
                    <ul class="w-full flex-flex-col space-y-3">
                        <li>
                            <a target="_blank" href="{{ route('product.details', [$product->id]) }}">
                                {{ translate('Manage Course') }}
                            </a>
                        </li>

                        <li>
                            <a target="_blank" href="{{ route('product.edit.course', [$product->id]) }}">
                                {{ translate('Manage course material') }}
                            </a>
                        </li>

                        @isset($course_item->subject->quiz_json)
                        <li>
                            <a target="_blank" href="{{ route('dashboard.we-quiz.details', [$course_item->subject_id]) }}">
                                {{ translate('Quiz Submissions') }} ({{ $course_item->subject->results()->count() }})
                            </a>
                        </li>
                        @endisset
                    </ul>
                </div>
            </div>
            @endif
        @endauth
    </div>


    <x-system.form-modal id="gated-content-cta-modal" title="{{ translate('Want to access the full course?') }}"
        class="sm:max-w-2xl">
        <div class="w-full flex flex-col">
            {{-- <h3 class="w-full text-22 mb-2"></h3> --}}
            <p class="text-16 mb-4">{{ translate('Join now and buy this course to have an access to content') }}</p>

            <div class="w-full flex gap-4 justify-start">
                @auth
                @if(\Payments::isStripeEnabled() && \Payments::isStripeCheckoutEnabled())
                <x-system.buy-now-button :model="$product" class="!w-auto" label="{{ translate('Buy now') }}"
                    label-not-in-stock="{{ translate('Not in stock') }}">
                </x-system.buy-now-button>
                @else
                <x-system.add-to-cart-button :model="$product" class="!w-auto" label="{{ translate('Add to cart') }}"
                    label-not-in-stock="{{ translate('Not in stock') }}">
                </x-system.add-to-cart-button>
                @endif
                @endauth

                @guest
                <a href="{{ route('user.login') }}" class="btn-primary">
                    {{ translate('Log in') }}
                </a>
                <a href="{{ route('user.registration') }}" class="btn-primary-outline">
                    {{ translate('Join now') }}
                </a>
                @endguest

            </div>
        </div>
    </x-system.form-modal>
</div>
@endsection
