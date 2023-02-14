@extends('frontend.layouts.user_panel')

@section('page_title', translate('Edit Page').': '.$page->getTranslation('name'))

@push('head_scripts')

@endpush

@section('panel_content')
<section>
    <x-dashboard.section-headers.section-header title="{{ translate('Page details') }}: {{ $page->name }}" text="">
        <x-slot name="content">
            <a href="{{ route('pages.index') }}" class="btn-standard">
                @svg('heroicon-o-chevron-left', ['class' => 'h-4 h-4 mr-2'])
                <span>{{ translate('All pages') }}</span>
            </a>
        </x-slot>
    </x-dashboard.section-headers.section-header>
    <div class="grid grid-cols-12 gap-8">
        <div class="col-span-8">
            <div class="overflow-hidden bg-white shadow sm:rounded-lg">
                <div class="px-4 py-5 sm:px-6">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">
                        {{ translate('Page information & statistics') }}
                    </h3>
                    <p class="mt-1 max-w-2xl text-sm text-gray-500">
                        {{ translate('Real time data about page performance and information') }}
                    </p>
                </div>
                <div class="border-t border-gray-200 px-4 py-5 sm:p-0">
                    <dl class="sm:divide-y sm:divide-gray-200">
                        <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">
                                {{ translate('Page name') }}
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                                {{ $page->name }} <br>
                                <small>
                                    <a class="text-primary" href="{{ $page->getPermalink() }}" target="_blank">
                                        {{ $page->getPermalink() }}
                                    </a>
                                </small>
                            </dd>
                        </div>
                        <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">
                                {{ translate('Page views') }}
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                                {{ rand(1,5000) }} {{ translate('Views') }}
                            </dd>
                        </div>

                        <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">
                                {{ translate('Page reading time') }}
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                                {{ rand(1,5000) }} {{ translate('minutes') }}
                            </dd>
                        </div>
                        <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">
                                {{ translate('Sitemap and visibility') }}
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                                <p class="mt-2 flex items-center text-sm text-gray-500">
                                    <svg class="mr-1.5 h-5 w-5 flex-shrink-0 text-green-400"
                                        x-description="Heroicon name: mini/check-circle"
                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                        aria-hidden="true">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    {{ translate('Included in sitemap') }}/ <span class="capitalize">{{ $page->status}}
                                    </span>
                                </p>
                            </dd>
                        </div>

                        <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">
                                {{ translate('Meta Description') }}
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                                @if($page->meta_description)

                                {{ $page->meta_description }}
                                @else
                                <span class="text-gray-500">
                                    {{ translate('No meta description set') }}
                                    </span>
                                @endif
                                <br><small>
                                    <a target="_blank" href="{{ route('page.edit', $page->id) }}" class="text-primary">
                                        {{ translate('Edit') }}

                                    </a>
                                </small>
                            </dd>
                        </div>

                    </dl>
                </div>
            </div>

        </div>

        <div class="col-span-4">
            <div class="px-4 py-5 sm:px-6 bg-white">
                <h3 class="text-lg font-medium leading-6 text-gray-900">
                    {{ translate('Preview') }}
                </h3>

            </div>
            <h3 class="text-lg leading-6 font-medium text-gray-900 mb-3">

            </h3>
            <div style="transform: scale(0.5); width: 200%; transform-origin: top left;">
                <iframe class="p-1 bg-black bg-white rounded-xl shadow bg-white w-full min-h-[1200px]"
                    src="{{ $page->getPermalink() }}?preview=true"> </iframe>
            </div>
        </div>
    </div>
</section>
@endsection

@push('footer_scripts')
{{-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
--}}
{{-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
--}}
{{-- <script type="text/javascript"
    src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.11.3/b-2.1.1/b-colvis-2.1.1/b-html5-2.1.1/b-print-2.1.1/date-1.1.1/fh-3.2.0/r-2.2.9/sl-1.3.4/datatables.min.js">
</script>--}}
@endpush
