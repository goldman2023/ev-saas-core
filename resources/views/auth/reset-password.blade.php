@extends('frontend.layouts.' . $globalLayout)

@section('content')
<section class="py-10 md:py-16 bg-white" style="background-image: url('flex-ui-assets/elements/pattern-white.svg'); background-position: center;">
    <div class="container px-4 mx-auto">
      <div class="max-w-sm mx-auto">
        <div class="mb-6 text-center">
          <a class="inline-block mb-6" href="#">
            <x-tenant.system.image alt="{{ get_site_name() }} logo" class="h-12 w-auto"
                    :image="get_site_logo()">
            </x-tenant.system.image>
          </a>
          <h3 class="mb-4 text-2xl md:text-3xl font-bold text-gray-700">{{ translate('Reset password') }}</h3>
          @if($valid)
            <p class="text-16 text-gray-500 font-medium">{{ translate('Create a new password for your account') }}</p>
          @else
            <p class="text-16 text-gray-500 font-medium">{{ translate('Sorry, reset password link is not valid anymore. Please reset password again and go to reset link ASAP (max. 1h)') }}</p>
          @endif
        </div>

        @if($valid)
          <livewire:forms.reset-password-form :user="$user"></livewire:forms.reset-password-form>
        @endif

      </div>
    </div>
</section>
@endsection