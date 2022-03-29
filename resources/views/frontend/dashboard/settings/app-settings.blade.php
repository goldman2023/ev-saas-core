@extends('frontend.layouts.user_panel')
@section('page_title', translate('App Settings'))

@section('panel_content')
  <section>
    <x-dashboard.section-headers.section-header title="{{ translate('App settings') }}" text="">
        <x-slot name="content">
            <a href="#" class="btn-primary">
                @svg('heroicon-o-user', ['class' => 'h-4 h-4 mr-2'])
                <span>{{ translate('My shop') }}</span>
            </a>
        </x-slot>
    </x-dashboard.section-headers.section-header>

    <livewire:dashboard.forms.settings.app-settings-form></livewire:dashboard.forms.settings.app-settings-form>
  </section>

<!-- Basic Info-->
{{-- <div class=" mb-3">
    <div class="card-header p-4">
        <h5 class="h3 text-xl fw-600">{{ translate('Design Settings')}}</h5>
    </div>
    <div class="card-body">
        <div class="p-4">
            <x-default.system.theme-select-form />
        </div>
        <!-- End Tab Content -->

        <div class="mt-3">
            <button type="submit" class="btn btn-primary">{{translate('Update Settings')}}</button>
        </div>
    </div>
</div> --}}


{{-- <form action="{{ route('tenant.settings.application.configuration') }}" method="POST">
    @csrf
    <div class="shadow overflow-hidden sm:rounded-md">
      <div class="px-4 py-5 bg-white sm:p-6">
        <div>
          <label for="company" class="block text-sm font-medium leading-5 text-gray-700">Company name
          </label>
          <div class="mt-1 relative rounded-md shadow-sm">
            <input id="company" name="company" value="{{ old('company', tenant('company')) }}" class="form-input block w-full sm:text-sm sm:leading-5" placeholder="My company" />
          </div>
        </div>

        @error('company')
        <p class="text-red-500 text-xs mt-4">
          {{ $message }}
        </p>
        @enderror
      </div>
      <div class="px-4 sm:px-6 py-2 bg-gray-50 flex justify-end">
        <button class="py-1 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 shadow-sm hover:bg-indigo-500 focus:outline-none focus:shadow-outline-blue focus:bg-indigo-500 active:bg-indigo-600 transition duration-150 ease-in-out">
          Save
        </button>
      </div>
    </div>
  </form>

<form action="{{ route('tenant.settings.application.configuration') }}" method="POST">
    @csrf
<div>
    <div class="flex flex-row flex-wrap">
        <div class="w-full md:w-1/3">
            <div class="px-4 md:px-0">
                <h3 class="text-lg font-medium leading-6 text-gray-900">Domains
                </h3>
                <p class="mt-1 text-sm leading-5 text-gray-600">
                    Manage your application's domains.
                </p>
            </div>
        </div>
        <div class="mt-4 md:mt-0 w-full md:w-2/3 pl-0 md:pl-2">
            @livewire('domains')
            @livewire('new-domain')
            @livewire('fallback-domain')
        </div>
    </div>
</div>
</form> --}}


{{-- Billing settings --}}
{{-- <div>
    <div class="flex flex-row flex-wrap">
      <div class="w-full md:w-1/3">
        <div class="px-4 md:px-0">
          <h3 class="text-lg font-medium leading-6 text-gray-900">Billing
          </h3>
          <p class="mt-1 text-sm leading-5 text-gray-600">
            Manage your subscription and payment methods.
          </p>
        </div>
      </div>
      <div class="mt-4 md:mt-0 w-full md:w-2/3 pl-0 md:pl-2">
        {{-- @livewire('subscription-banner') --}}
        {{-- @livewire('upcoming-payment') --}}
        {{-- @livewire('billing-address') --}}
        {{-- @livewire('invoices') --}}
        {{-- @livewire('subscription-plan') --}}
        {{-- @livewire('payment-method') --}}
      {{-- </div>
    </div>
  </div> --}} 
@endsection
