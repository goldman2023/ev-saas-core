@extends('frontend.layouts.app')

@section('content')
    <!-- This example requires Tailwind CSS v2.0+ -->
    <div class="relative bg-gray-50 pt-16 pb-20 px-4 sm:px-6 lg:pt-24 lg:pb-28 lg:px-8">


        <div class="absolute inset-0">
            <div class="bg-white h-1/3 sm:h-2/3"></div>
        </div>
        <div class="relative max-w-7xl mx-auto">
            <x-tenant.blog.hero></x-tenant.blog.hero>

            <div class="mt-12 max-w-lg mx-auto grid gap-5 lg:grid-cols-3 lg:max-w-none">
                @foreach ($blogs as $item)
                    <div class="">
                        <x-tenant.blog.news-card :item="$item"></x-tenant.blog.news-card>
                    </div>
                @endforeach

            </div>
        </div>
    </div>

@endsection
