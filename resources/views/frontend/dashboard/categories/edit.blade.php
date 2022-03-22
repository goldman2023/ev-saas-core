@extends('frontend.layouts.user_panel')

@section('page_title', translate('Edit category'))

@push('head_scripts')

@endpush

@section('panel_content')
    <section>
        <div class="pb-5 mb-5 border-b border-gray-200 sm:flex sm:items-center sm:justify-between">
            <div class="">
                <h3 class="text-24 leading-6 font-semibold text-gray-900">{{ translate('Edit category') }}</h3>
                {{-- <p class="mt-2 max-w-4xl text-sm text-gray-500">Workcation is a property rental website. Etiam ullamcorper massa viverra consequat, consectetur id nulla tempus. Fringilla egestas justo massa purus sagittis malesuada.</p>     --}}
            </div>
            <div class="flex sm:mt-0 sm:ml-4">
                <a href="{{ route('categories.index') }}" class="btn-standard">
                    @svg('heroicon-o-chevron-left', ['class' => 'h-4 h-4 mr-2'])
                    <span>{{ translate('All categories') }}</span>
                </a>
            </div>
        </div>

        <livewire:dashboard.forms.categories.category-form :category="$category"></livewire:dashboard.forms.categories.category-form>
    </section>
@endsection

@push('footer_scripts')

@endpush
