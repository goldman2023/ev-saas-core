@extends('frontend.layouts.' . $globalLayout)

@section('content')
<section class="py-10 md:py-16 bg-white">
    <div class="container px-4 mx-auto">
      <div class="max-w-sm mx-auto">
        <div class="mb-6 text-center">
          <a class="inline-block mb-6" href="#">
            <x-tenant.system.image alt="{{ get_site_name() }} logo" class="h-12 w-auto"
                    :image="get_site_logo()">
            </x-tenant.system.image>
          </a>
          <h3 class="mb-4 text-2xl md:text-3xl font-bold text-gray-700">{{ translate('Forgot your password?') }}</h3>
          <p class="text-16 text-gray-500 font-medium">{{ translate('Revive your account by receiving a reset password link to your email!') }}</p>
        </div>

        <livewire:forms.forgot-password-form></livewire:forms.forgot-password-form>

      </div>
    </div>
</section>
@endsection