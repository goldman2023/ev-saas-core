@extends('frontend.layouts.user_panel')

@section('page_title', translate('Quiz Result for ').' - '.$quiz->name)

@push('head_scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <link href="https://unpkg.com/survey-jquery@1.9.33/modern.css" type="text/css" rel="stylesheet" />
    <script src="https://unpkg.com/survey-jquery@1.9.33/survey.jquery.min.js"></script>

    <style>

    </style>
@endpush

@section('panel_content')

<div class="min-h-full">

    <main class="pb-8" x-data="{ 
        quiz_passed: {{ $quiz_result->quiz_passed === true ? 'true' : 'false' }},
        togglePassed() {
            wetch.post('{{ route('api.dashboard.we-quiz.toggle-passed', $quiz_result->id) }}')
            .then(data => this.quiz_passed = data.quiz_passed)
            .catch(error => console.error('There was an error!', error));
        }
     }">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:max-w-7xl lg:px-0">
            <!-- Main 3 column grid -->
            <div class="grid grid-cols-1 gap-4 items-start lg:grid-cols-3 lg:gap-8">
                <!-- Left column -->
                <div class="grid grid-cols-1 gap-4 lg:col-span-2">
                    <section aria-labelledby="profile-overview-title">
                        <div class="rounded-lg bg-white overflow-hidden shadow">
                            <div class="bg-white p-6">
                                <div class="sm:flex sm:items-center sm:justify-between">
                                    <div class="sm:flex sm:space-x-5">
                                        <div class="mt-4 text-center sm:mt-0 sm:pt-1 sm:text-left">
                                            <p class="text-xl font-bold text-gray-900 sm:text-2xl mb-3">
                                                {{ translate('Results for') }}: {{ $quiz->name }}
                                            </p>
                                            <div class="flex items-center text-sm font-medium text-gray-600">
                                                <a href="{{ route('user.details', $user->id) }}" class="flex items-center" >
                                                    @if(!empty($user->thumbnail))
                                                        <img class="h-10 w-10 rounded-full border-3 ring-2 border-gray-200 mr-3 object-cover shrink-0" src="{{ $user->getThumbnail(['w' => '120']) }}" />
                                                    @endif
                                            
                                                    <div class="w-full flex flex-col ">
                                                        <strong class="">{{ $user->name.' '.$user->surname }}</strong>
                                                        <span class="">{{ $user->email }}</span>
                                                    </div>
                                                </a>
                                                <span class="ml-3" :class="{'badge-success': quiz_passed, 'badge-danger': !quiz_passed}" x-text="quiz_passed ? '{{ translate('Passed') }}' : '{{ translate('Failed') }}'">
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-5 flex justify-center sm:mt-0">
                                        <div class="text-center" x-cloak>
                                            <button @click="togglePassed()" x-show="!quiz_passed" class="min-w-[200px] btn-success">
                                                {{ translate('Mark as passed') }}
                                            </button>

                                            <button @click="togglePassed()" x-show="quiz_passed" class="min-w-[200px] btn-danger">
                                                {{ translate('Mark as failed') }}
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- Quiz Results -->
                    <section class="w-full">
                        <div class="w-full">
                            <div class="rounded-lg bg-white overflow-hidden shadow">
                                <div class="p-6 relative">
                                    <h3 class="text-base font-medium text-gray-900 relative">
                                        {{ translate('Quiz Result') }}
                                    </h3>
                                
                                    <div class="">
                                        <div class="w-full" id="we-quiz-result-container"></div>

                                        <script>
                                            $(function() {
                                                Survey.StylesManager.applyTheme('modern');

                                                window.survey = new Survey.Model(@js($quiz->quiz_json));

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
                                    </div>
                                </div>
                            </div>
                        </div>

                    </section>
                </div>

                <!-- Right column -->
                <div class="grid grid-cols-1 gap-4">
                    <!-- Recent Results -->
                    <section aria-labelledby="recent-hires-title">
                        <div class="rounded-lg bg-white overflow-hidden shadow">
                            <div class="flex flex-col p-6">
                                <h2 class="text-base font-medium text-gray-900 pb-3 mb-5 border-b border-gray-200">
                                    {{ translate('Recent results') }}
                                </h2>
                                <div class="w-full">
                                    <ul role="list" class="divide-y divide-gray-200">
                                        @if($quiz->results->isNotEmpty())
                                            @foreach($quiz->results->take(3) as $result)
                                                <li class="py-4">
                                                    <div class="flex items-center space-x-4">
                                                        <div class="flex-shrink-0">
                                                            <img class="h-8 w-8 rounded-full"
                                                                src="{{ $result->user?->getThumbnail(['w' => 100]) }}"
                                                                alt="">
                                                        </div>
                                                        <div class="flex-1 min-w-0">
                                                            <p class="text-sm font-medium text-gray-900 truncate">{{ $result->user?->name.' '.$result->user?->surname }}</p>
                                                            <p class="text-sm text-gray-500 truncate">{{ translate('submit the quiz results') }}</p>
                                                        </div>
                                                        <div>
                                                            <a href="#"
                                                                class="inline-flex items-center shadow-sm px-2.5 py-0.5 border border-gray-300 text-sm leading-5 font-medium rounded-full text-gray-700 bg-white hover:bg-gray-50">
                                                                {{ translate('View') }} 
                                                            </a>
                                                        </div>
                                                    </div>
                                                </li>
                                            @endforeach
                                        @else
                                            <div class="w-full text-16">
                                                {{ translate('There are no submissions yet...') }}
                                            </div>
                                        @endif
                                    </ul>
                                </div>
                                @if($quiz->results->isNotEmpty())
                                    <div class="mt-6">
                                        <a href="{{ route('dashboard.we-quiz.results', $quiz->id) }}"
                                            class="w-full flex justify-center items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                            {{ translate('View all') }} 
                                        </a>
                                    </div>
                                @endif

                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </main>

</div>


<div class="grid grid-cols-3 gap-5">
    <div>

    </div>

    <div>


    </div>

</div>



@endsection

@push('footer_scripts')

@endpush
