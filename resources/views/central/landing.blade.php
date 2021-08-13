@extends('central.layouts.central')

@section('main')

    <x-central.hero></x-central.hero>

    <div class="flex justify-center mt-4">
        <a href="" class="block py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo active:bg-indigo-700 transition duration-150 ease-in-out">
            Login
        </a>
        <a href="{{ route('central.tenants.register') }}" class="block ml-2 py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo active:bg-indigo-700 transition duration-150 ease-in-out">
            Register
        </a>
    </div>

@endsection
