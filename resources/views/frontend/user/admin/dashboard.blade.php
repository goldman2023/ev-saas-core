@extends('frontend.layouts.user_panel')

@section('panel_content')

<section>
    <div class="grid grid-cols-3">
        <div class="col-span-1">
            {{-- <x-default.dashboard.widgets.onboarding-widget></x-default.dashboard.widgets.onboarding-widget> --}}
        </div>

        <div class="col-span-1">
            {{-- <x-default.promo.shop-subscribe></x-default.promo.shop-subscribe> --}}

        </div>
    </div>
</section>

<section>
    <div class="row">
        <div class="grid">
            <x-dashboard.widgets.user-welcome></x-dashboard.widgets.user-welcome>
        </div>
        <div class="grid grid-cols-4 gap-12 mb-12">
            <x-dashboard.elements.card class="lg:col-span-2 col-span-2">
                <div class="bg-white px-4 py-5 shadow sm:rounded-lg sm:px-6">
                    <x-slot name="cardHeader" class="font-bold mb-3">
                        <div class="mb-3">
                            {{translate('Most popular categories') }}
                        </div>
                    </x-slot>

                    <x-slot name="cardBody" class="flow-root mt-6">
                        <ul role="list" class="-my-5 divide-y divide-gray-200">
                            @foreach (Categories::getAll(true)->sortBy('created_at')->take(5) as $category) <li
                                class="py-4">
                                <div class="flex items-center space-x-4">
                                    <div class="flex-shrink-0">
                                        <img class="h-8 w-8 rounded-full"
                                            src="https://images.unsplash.com/photo-1519345182560-3f2917c472ef?ixlib=rb-1.2.1&amp;ixid=eyJhcHBfaWQiOjEyMDd9&amp;auto=format&amp;fit=facearea&amp;facepad=2&amp;w=256&amp;h=256&amp;q=80"
                                            alt="">
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-gray-900 truncate">
                                            {{ $category->name }}
                                        </p>
                                        <p class="text-sm text-gray-500 truncate">
                                            321 Views / {{ $category->products()->count() }} {{ translate('Products') }}
                                        </p>
                                    </div>
                                    <div>
                                        <a href="{{ $category->getPermalink() }}" target="blank"
                                            class="inline-flex items-center shadow-sm px-2.5 py-0.5 border border-gray-300 text-sm leading-5 font-medium rounded-full text-gray-700 bg-white hover:bg-gray-50">
                                            {{ translate('View') }}
                                        </a>
                                    </div>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    </x-slot>


                    <x-slot name="cardFooter">
                        <a href="{{ route('categories.index') }}" type="button" class="btn btn-secondary">
                            {{ translate('View all categories') }}
                        </a>
                    </x-slot>

                </div>
            </x-dashboard.elements.card>


            <x-dashboard.elements.card>
                <x-slot name="cardHeader" class="flow-root mt-6">
                    <div class="h5 fw-600">{{ translate('Products') }} </div>
                </x-slot>
                <x-slot name="cardBody" class="">
                    {{-- TODO : make this company name dynamic --}}
                    <p>{{ translate('Manage & organize your inventory and products') }}</p>

                </x-slot>
                <x-slot name="cardFooter">
                    <a href="{{ route('products.index') }}" class="btn btn-soft-primary">
                        {{ translate('Manage Products') }}
                    </a>
                </x-slot>
            </x-dashboard.elements.card>
            <div>
                <x-dashboard.elements.support-card class="card mb-3">
                </x-dashboard.elements.support-card>
                <x-dashboard.elements.card>
                    <x-slot name="cardHeader" class="flow-root mt-6">
                        <div class="h5 fw-600">{{ translate('Quick Actions') }} </div>
                    </x-slot>
                    <x-slot name="cardBody" class="">
                        {{-- TODO : make this company name dynamic --}}
                        <p>{{ translate('') }}</p>

                    </x-slot>
                    <x-slot name="cardFooter">
                        <div class="overflow-x-auto sm:flex lg:block">
                            <a href="{{ route('products.index') }}" class="btn btn-soft-primary mb-3">
                                🚚 {{ translate('Process Orders') }}
                            </a>

                            <a href="{{ route('products.index') }}" class="btn btn-soft-primary mb-3">
                                📄 {{ translate('Create manual invoice') }}
                            </a>

                            <a href="{{ route('products.index') }}" class="btn btn-soft-primary mb-3">
                                📦 {{ translate('Manage Products') }}
                            </a>

                            <a href="{{ route('products.index') }}" class="btn btn-soft-primary">
                                🏷️ {{ translate('Manage Categories') }}
                            </a>
                        </div>
                    </x-slot>
                </x-dashboard.elements.card>
            </div>

        </div>
    </div>
</section>



<section class="stats mb-3">
    <div class="grid grid-cols-2 gap-10">
        <x-default.dashboard.widgets.integrations-widget>

        </x-default.dashboard.widgets.integrations-widget>

        <x-default.products.recently-viewed-products></x-default.products.recently-viewed-products>
    </div>
</section>

<section>

</section>
@endsection
