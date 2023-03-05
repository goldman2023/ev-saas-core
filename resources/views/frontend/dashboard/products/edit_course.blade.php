@extends('frontend.layouts.user_panel')

@section('page_title', translate('Edit Course Material').': '.$product->name)

@push('pre_head_scripts')

@endpush

@push('head_scripts')
<script src="{{ mix('js/editor.js', 'themes/WeTailwind') }}" defer></script>
@endpush

@section('panel_content')
<section>
    <x-dashboard.section-headers.section-header title="{{ translate('Edit Course Material') }}" text="">
        <x-slot name="content">
            <a href="{{ route('product.details', $product->id) }}" class="btn-standard mr-2 relative">
                <div
                    class="absolute top-[-15px] left-[-20px] mb-2 px-2 py-1 text-gray-100 text-xs font-semibold bg-indigo-700 rounded-full">
                    {{ translate('New!') }} 🔖
                </div>
                @svg('heroicon-o-eye', ['class' => 'h-4 h-4 mr-2'])
                <span>{{ translate('Product Details') }}</span>
            </a>
            <a href="{{ route('products.index') }}" class="btn-standard">
                @svg('heroicon-o-chevron-left', ['class' => 'h-4 h-4 mr-2'])
                <span>{{ translate('All products') }}</span>
            </a>
        </x-slot>
    </x-dashboard.section-headers.section-header>

    <div class="grid grid-cols-12 gap-6">
        <div class="col-span-8">
            @if($product->type === 'course')
            <livewire:dashboard.forms.products.course-items-form :product="$product" />
            @endif
        </div>

        <div class="col-span-4">
            <div class="card">
                <!-- This example requires Tailwind CSS v2.0+ -->
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-1">
                    <div
                        class="relative rounded-lg border border-gray-300 bg-white px-6 py-5 shadow-sm flex items-center space-x-3 hover:border-gray-400 focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                        <div class="flex-1 min-w-0">
                            <a href="{{ route('dashboard.we-quiz.create') }}" target="_blank"
                                class="focus:outline-none">
                                <span class="absolute inset-0" aria-hidden="true"></span>
                                <p class="text-sm font-medium text-gray-900">
                                    {{ translate('Create new Quiz') }}
                                </p>
                                <p class="text-sm text-gray-500 truncate">{{ translate('Add a new quiz via Quiz Editor')
                                    }}</p>
                            </a>
                        </div>
                    </div>

                    <div
                        class="relative rounded-lg border border-gray-300 bg-white px-6 py-5 shadow-sm flex items-center space-x-3 hover:border-gray-400 focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                        <div class="flex-1 min-w-0">
                            <a href="{{ route('dashboard.we-quiz.create') }}" target="_blank"
                                class="focus:outline-none">
                                <span class="absolute inset-0" aria-hidden="true"></span>
                                <p class="text-sm font-medium text-gray-900">
                                    {{ translate('Edit Course') }}
                                </p>
                                <p class="text-sm text-gray-500 truncate">{{ translate('Edit price, description and course information')
                                    }}</p>
                            </a>
                        </div>
                    </div>

                    <!-- More people... -->
                </div>
            </div>
        </div>
    </div>


</section>
@endsection

@push('footer_scripts')

@endpush
