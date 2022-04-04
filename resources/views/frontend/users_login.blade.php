@extends('frontend.layouts.' . $globalLayout)

@section('content')
<section class="bg-primary md:p-20 py-10">
    <div class="profile">
        <div class="container">
            <div class="">
                <div class="mx-auto">
                    <div class="card max-w-[600px] p-10 md:px-20 bg-white">
                        <x-forms.login-form> </x-forms.login-form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
