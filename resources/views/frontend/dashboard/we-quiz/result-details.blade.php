@extends('frontend.layouts.user_panel')

@section('page_title', translate('Quiz').' - '.$quiz->name)

@section('panel_content')

<div class="min-h-full">

    <main class="pb-8">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:max-w-7xl lg:px-0">
            <!-- Main 3 column grid -->
            <div class="grid grid-cols-1 gap-4 items-start lg:grid-cols-3 lg:gap-8">
                <!-- Left column -->
                <div class="grid grid-cols-1 gap-4 lg:col-span-2">
                    <!-- Welcome panel -->
                    <section aria-labelledby="profile-overview-title">
                        <div class="rounded-lg bg-white overflow-hidden shadow">
                            <div class="bg-white p-6">
                                <div class="sm:flex sm:items-center sm:justify-between">
                                    <div class="sm:flex sm:space-x-5">
                                        <div class="mt-4 text-center sm:mt-0 sm:pt-1 sm:text-left">
                                            <p class="text-xl font-bold text-gray-900 sm:text-2xl mb-3">
                                                {{ translate('Results for') }}: {{ $quiz->name }}
                                            </p>
                                            <div class="text-sm font-medium text-gray-600">
                                                <a href="{{ route('user.details', $user->id) }}" class="flex items-center" >
                                                    @if(!empty($user->thumbnail))
                                                        <img class="h-10 w-10 rounded-full border-3 ring-2 border-gray-200 mr-3 object-cover shrink-0" src="{{ $user->getThumbnail(['w' => '120']) }}" />
                                                    @endif
                                            
                                                    <div class="w-full flex flex-col ">
                                                        <strong class="">{{ $user->name.' '.$user->surname }}</strong>
                                                        <span class="">{{ $user->email }}</span>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-5 flex justify-center sm:mt-0">
                                        <div class="text-center">
                                            <a href="{{ route('dashboard.we-quiz.show', $quiz->id) }}" target="_blank"
                                                class="min-w-[200px] flex justify-center items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-200 bg-primary hover:bg-gray-50 hover:text-gray-900">
                                                {{ translate('Mark as passed') }}
                                            </a>

                                            {{-- <div>
                                                <span
                                                    class="mt-3 mx-auto text-center inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium bg-indigo-100 text-indigo-800">
                                                    <svg class="-ml-1 mr-1.5 h-2 w-2 text-indigo-400"
                                                        fill="currentColor" viewBox="0 0 8 8">
                                                        <circle cx="4" cy="4" r="3" />
                                                    </svg>
                                                    {{ $product->status }}
                                                </span>
                                            </div> --}}
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
                                        {{ translate('Quiz Results') }}
                                    </h3>
                                
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
