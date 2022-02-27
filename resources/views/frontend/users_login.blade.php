@extends('frontend.layouts.' . $globalLayout)

@section('content')
<section class="gry-bg py-5">
    <div class="profile">
        <div class="container">
            <div class="row">
                <div class="col-xxl-4 col-xl-5 col-lg-6 col-md-8 mx-auto">
                    <div class="card p-4">
                        <x-forms.login-form> </x-forms.login-form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
