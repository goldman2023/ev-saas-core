@extends('frontend.layouts.user_panel')

@section('panel_content')


    <div class="row">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h3> {{ translate('Create New Component') }}</h3>

                    <x-default.forms.product-form>
                    </x-default.forms.product-form>

                    <div id="app">
                        {!! $form->render() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
