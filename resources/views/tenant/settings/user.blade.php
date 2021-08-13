@extends('frontend.layouts.app')

@section('content')

<div>
  <div class="flex flex-row flex-wrap">
    <div class="w-full md:w-1/3">
      <div class="px-4 md:px-0">
        <h3 class="text-lg font-medium leading-6 text-gray-900">Personal information
        </h3>
        <p class="mt-1 text-sm leading-5 text-gray-600">
          This information will be displayed publicly.
        </p>
      </div>
    </div>
    <div class="mt-4 md:mt-0 w-full md:w-2/3 pl-0 md:pl-2">
      <form action="{{ route('tenant.settings.user.personal') }}" method="POST">
        @csrf
        <div class="shadow overflow-hidden sm:rounded-md">
          <div class="px-4 py-5 bg-white sm:p-6">
            <div>
              <label for="name" class="block text-sm font-medium leading-5 text-gray-700">Name
              </label>
              <div class="mt-1 relative rounded-md shadow-sm">
                <input id="name" name="name" value="{{ old('name', auth()->user()->name) }}" class="form-input block w-full sm:text-sm sm:leading-5" placeholder="John Doe" />
              </div>
            </div>

            @error('name')
              <p class="text-red-500 text-xs mt-4">
                  {{ $message }}
              </p>
            @enderror

            <div class="mt-4">
              <label for="email" class="block text-sm font-medium leading-5 text-gray-700">Email
              </label>
              <div class="mt-1 relative rounded-md shadow-sm">
                <input id="email" name="email" value="{{ old('email', auth()->user()->email) }}" class="form-input block w-full sm:text-sm sm:leading-5" placeholder="you@example.com" />
              </div>

              @error('email')
              <p class="text-red-500 text-xs mt-4">
                  {{ $message }}
              </p>
            @enderror
            </div>
          </div>
          <div class="px-4 sm:px-6 py-2 bg-gray-50 flex justify-end">
            <button class="py-1 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 shadow-sm hover:bg-indigo-500 focus:outline-none focus:shadow-outline-blue focus:bg-indigo-500 active:bg-indigo-600 transition duration-150 ease-in-out">
              Save
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="py-4 md:py-10">
  <div class="border-t border-transparent md:border-gray-200"></div>
</div>

<div>
  <div class="flex flex-row flex-wrap">
    <div class="w-full md:w-1/3">
      <div class="px-4 md:px-0">
        <h3 class="text-lg font-medium leading-6 text-gray-900">Password
        </h3>
        <p class="mt-1 text-sm leading-5 text-gray-600">
{{--          Change your password. <a class="font-medium text-indigo-600 hover:text-indigo-500 focus:outline-none focus:underline transition ease-in-out duration-150" href="{{ route('tenant.password.request') }}">Forgot your current password?</a>--}}
        </p>
      </div>
    </div>
    <div class="mt-4 md:mt-0 w-full md:w-2/3 pl-0 md:pl-2">
      <form action="{{ route('tenant.settings.user.password') }}" method="POST">
        @csrf
        <div class="shadow overflow-hidden sm:rounded-md">
          <div class="px-4 py-5 bg-white sm:p-6">
            <div class="">
                <label for="password" class="block text-sm font-medium leading-5 text-gray-700">
                    {{ __('Current password') }}
                </label>
                <div class="mt-1 rounded-md">
                    <input id="password" type="password" required class="shadow-sm appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5 @error('password') border-red-500 @enderror" name="password" />

                    @error('password')
                    <p class="text-red-500 text-xs mt-4">
                        {{ $message }}
                    </p>
                    @enderror
                </div>
            </div>

            <div class="mt-4">
                <label for="new_password" class="block text-sm font-medium leading-5 text-gray-700">
                    {{ __('New password') }}
                </label>
                <div class="mt-1 rounded-md">
                    <input id="new_password" type="password" required class="shadow-sm appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5 @error('new_password') border-red-500 @enderror" name="new_password" />

                    @error('new_password')
                    <p class="text-red-500 text-xs mt-4">
                        {{ $message }}
                    </p>
                    @enderror
                </div>
            </div>

            <div class="mt-4">
                <label for="new_password_confirmation" class="block text-sm font-medium leading-5 text-gray-700">
                    {{ __('Confirm password') }}
                </label>
                <div class="mt-1 rounded-md">
                    <input id="new_password_confirmation" type="password" required class="shadow-sm appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5 @error('new_password_confirmation') border-red-500 @enderror" name="new_password_confirmation" />
                </div>
            </div>
          </div>
          <div class="px-4 sm:px-6 py-2 bg-gray-50 flex justify-end">
            <button class="py-1 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 shadow-sm hover:bg-indigo-500 focus:outline-none focus:shadow-outline-blue focus:bg-indigo-500 active:bg-indigo-600 transition duration-150 ease-in-out">
              Save
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
