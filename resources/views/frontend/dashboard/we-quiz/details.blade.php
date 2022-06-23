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
                                                {{ $quiz->name }}
                                            </p>
                                            <div class="text-sm font-medium text-gray-600">
                                                <div class="text-clip overflow-hidden max-h-[30px]">
                                                    <span class="badge-primary">{{ translate('Quiz') }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-5 flex justify-center sm:mt-0">
                                        <div class="text-center">
                                            <a href="{{ route('dashboard.we-quiz.show', $quiz->id) }}" target="_blank"
                                                class="min-w-[200px] flex justify-center items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-200 bg-primary hover:bg-gray-50 hover:text-gray-900">

                                                {{ translate('Preview') }} {{ translate('Quiz') }}
                                                <svg class="gray-600 flex-shrink-0 h-6 w-6 ml-2"
                                                    xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
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
                            <div
                                class="border-t border-gray-200 bg-gray-50 grid grid-cols-1 divide-y divide-gray-200 sm:grid-cols-3 sm:divide-y-0 sm:divide-x">
                                <div class="px-6 py-5 text-sm font-medium text-center">
                                    <span class="text-gray-900">
                                        {{-- {{ $quiz->public_view_count() }} --}}
                                        100
                                    </span>
                                    <span class="text-gray-600">
                                        {{ translate('Total views') }}
                                    </span>
                                </div>

                                <div class="px-6 py-5 text-sm font-medium text-center">
                                    <span class="text-gray-600">{{ translate('Used in') }}</span>
                                    <span class="text-gray-900">
                                        {{ $quiz->course_items()->count() }}
                                    </span>
                                    <span class="text-gray-600">{{ translate('course chapters') }}</span>
                                </div>

                                <div class="px-6 py-5 text-sm font-medium text-center">
                                    <span class="text-gray-900">{{ $quiz->results()->count() }}</span>
                                    <span class="text-gray-600">{{ translate('Results') }}</span>
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- Actions panel -->
                    <section aria-labelledby="quick-links-title">
                        <div class="flex flex-wrap items-center py-4">
                            <a class="btn btn-soft-info btn-circle btn-xs d-inline-flex align-items-center mr-2 mb-2 bg-white"
                                href="{{ route('dashboard.we-quiz.show', $quiz->id) }}" target="_blank">
                                @svg('heroicon-o-eye', ['style' => 'height: 16px;', 'class' => 'mr-2'])
                                {{ translate('Preview') }}
                            </a>

                            <a class="btn btn-soft-info btn-circle btn-xs d-inline-flex align-items-center mr-2 mb-2 bg-white"
                                href="{{ route('dashboard.we-quiz.edit', $quiz->id) }}">
                                {{ translate('Edit') }} @svg('heroicon-o-pencil-alt', ['style' => 'height: 16px;',
                                'class' => 'ml-2'])
                            </a>

                            <a class="btn btn-soft-info btn-circle btn-xs d-inline-flex align-items-center mr-2 mb-2 bg-white"
                                href="{{ route('dashboard.we-quiz.results', $quiz->id) }}">
                                {{ translate('Results') }} @svg('heroicon-o-pencil-alt', ['style' => 'height:
                                16px;', 'class' => 'ml-2'])
                            </a>

                            <a class=" ml-auto btn btn-soft-danger btn-circle btn-xs d-inline-flex align-items-center confirm-delete mr-2 mb-2 bg-white"
                                href="javascript:void(0)">
                                {{ translate('Delete') }} @svg('heroicon-o-trash', ['style' => 'height: 16px;',
                                'class' => 'ml-2'])
                            </a>
                        </div>


                        <div class="mt-2">
                            <div class="rounded-lg bg-white overflow-hidden shadow">
                                <div class="p-6 relative">
                                    <h3 class="text-base font-medium text-gray-900 relative">
                                        {{ translate('Quiz Activity') }}
                                    </h3>
                                

                                    {{-- <livewire:product-activity :product="$product" /> --}}
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
