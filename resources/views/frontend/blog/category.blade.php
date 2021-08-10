@extends('frontend.layouts.app')

@section('content')

    <section class="pt-4 mb-4">
        <div class="container text-center">
            <div class="row">
                <div class="col-lg-12 text-center text-lg-left">
                    <!-- Title -->
                    <div class="w-md-80 w-lg-50 text-center mx-md-auto mb-5 mb-md-9">
                        <h2 class="h1">{{ translate('Premium Forestry Industry News')}}</h2>
                        <p>{{ __('Stay informed of what is going on in the forestry and wood sector in a global market')}}</p>
                    </div>
                    <!-- End Title -->
                </div>
                <div class="col-lg-12">
                    <ul class="breadcrumb bg-transparent p-0 justify-content-center justify-content-lg-start">
                        <li class="breadcrumb-item opacity-50">
                            <a class="text-reset" href="{{ route('home') }}">
                                {{ translate('Home') }}
                            </a>
                        </li>
                        <li class="text-dark fw-600 breadcrumb-item">
                            <a class="text-reset" href="{{ route('news') }}">
                                "{{ translate('Blog') }}"
                            </a>
                        </li>
                        <li class="text-dark fw-600 breadcrumb-item">
                            <a class="text-reset" href="{{ route('news') }}">
                                {{ translate('Category') }}
                            </a>
                        </li>
                        <li class="text-dark fw-600 breadcrumb-item">
                            <a class="text-reset" href="{{ route('news') }}">
                                {{ $category->name }}
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
@endsection
