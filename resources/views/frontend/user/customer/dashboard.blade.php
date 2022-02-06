@extends('frontend.layouts.user_panel')

@section('panel_content')


<div class="card d-flex flex-row  pl-3 py-3 align-items-center mb-3">
    <h2 class="h3 d-flex align-items-center my-0">

        <span> {{ translate('Welcome,' ) }} {{ auth()->user()->name }} 👋 </span>
    </h2>
    <br>
    <div>
        <p>{{ translate('This is your customer dashboard, where you will find all the neccesary information') }}
    </div>
</div>
<div class="row">
    <div class="col-12 mb-3">
        <x-default.promo.shop-subscribe></x-default.promo.shop-subscribe>

    </div>
</div>
<div class="row">
    <div class="col-8">
        <div class="row">

            <div class="col-sm-6">
                {{-- <x-default.dashboard.customer.current-plan>
                    @slot('title')
                    AdeoWeb - Headache Free Website
                    @endslot

                    @slot('image')
                    <img
                        src="https://images.ev-saas.com/insecure/fill/1200/0/ce/0/plain/https://ev-saas.fra1.digitaloceanspaces.com/uploads/95729fac-ae52-44ea-824e-b634d8100c54/1641824421_Screenshot%202022-01-10%20at%2013.46.00.png@webp" />
                    @endslot
                </x-default.dashboard.customer.current-plan> --}}
            </div>

            <div class="col-sm-6">
                {{-- <x-default.dashboard.customer.current-plan>
                    @slot('title')
                    PassCamp - Headache Free Website
                    @endslot

                    @slot('image')
                    <img
                        src="https://images.ev-saas.com/insecure/fill/1200/0/ce/0/plain/https://ev-saas.fra1.digitaloceanspaces.com/uploads/95729fac-ae52-44ea-824e-b634d8100c54/1641824541_Screenshot%202022-01-10%20at%2016.22.00.png@webp" />
                    @endslot

                </x-default.dashboard.customer.current-plan> --}}
            </div>

            <div class="col-12">
                <x-default.dashboard.customer.invoices> </x-default.dashboard.customer.invoices>
            </div>

            <div class="col-12 mt-6">
                <section>
                    <x-default.products.recently-viewed-products columns="4">
                    </x-default.products.recently-viewed-products>
                </section>
            </div>
        </div>

    </div>





    <div class="col-sm-4">
        <x-default.dashboard.customer.support-agent>
        </x-default.dashboard.customer.support-agent>
        <a class="card card-hover-shadow mb-4" href="#">
            <div class="card-body">
                <div class="media align-items-center">
                    <div class="media-body">
                        <h3 class="text-hover-primary mb-1">✅ New Task</h3>
                        <span class="text-body">Create a new task for our development team</span>
                    </div>

                    <div class="ml-2 text-right">
                        <i class="tio-chevron-right tio-lg text-body text-hover-primary"></i>
                    </div>
                </div>
                <!-- End Row -->
            </div>
        </a>

        <a class="card card-hover-shadow mb-4" href="#">
            <div class="card-body">
                <div class="media align-items-center">
                    <div class="media-body">
                        <h3 class="text-hover-primary mb-1">🗓️ Book A Meeting</h3>
                        <span class="text-body">Book a meeting with your project manager</span>
                    </div>

                    <div class="ml-2 text-right">
                        <i class="tio-chevron-right tio-lg text-body text-hover-primary"></i>
                    </div>
                </div>
                <!-- End Row -->
            </div>
        </a>

        <a class="card card-hover-shadow mb-4" href="#">
            <div class="card-body">
                <div class="media align-items-center">
                    <div class="media-body">
                        <h3 class="text-hover-primary mb-1">ℹ️ Knowledge Base</h3>
                        <span class="text-body">All the links and all the answers to your questions</span>
                    </div>

                    <div class="ml-2 text-right">
                        <i class="tio-chevron-right tio-lg text-body text-hover-primary"></i>
                    </div>
                </div>
                <!-- End Row -->
            </div>
        </a>
    </div>
</div>
@endsection
