@extends('backend.layouts.app')

@section('content')
    @php
        $full_carts = get_theme_cart_templates('full');
        $adhoc_carts = get_theme_cart_templates('adhoc');
        $mini_carts = get_theme_cart_templates('mini');
    @endphp

    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card">
                <div class="card-header">
                    <h1 class="mb-0 h6">{{ translate('Checkout Flow') }}</h1>
                </div>
                <div class="card-body">
                    <form class="form-horizontal" action="{{ route('admin.tenant_settings.update') }}" method="POST"
                          enctype="multipart/form-data">
                        @csrf
                        <!-- FULL CART TEMPLATE -->
                        <div class="form-group row">
                            <label class="col-sm-3 col-from-label">{{ translate('Full Cart Template') }}</label>
                            <input type="hidden" name="types[]" value="cart_full_template">

                            <select name="cart_full_template" class="col-sm-9 form-control aiz-selectpicker">
                                @if($full_carts)
                                    @foreach($full_carts as $key => $title)
                                        <option value="{{ $key }}" onchange="updateSettings(this, 'cart_full_template')" {{ get_setting('cart_full_template') === $key ? "selected":"" }}>
                                            {{ $title }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>

                        <!-- ADHOC CART TEMPLATE -->
                        <div class="form-group row">
                            <label class="col-sm-3 col-from-label">{{ translate('Ad-hoc Cart Template (modal, flyout etc.)') }}</label>
                            <input type="hidden" name="types[]" value="cart_adhoc_template">

                            <select name="cart_adhoc_template" class="col-sm-9 form-control aiz-selectpicker">
                                @if($adhoc_carts)
                                    @foreach($adhoc_carts as $key => $title)
                                        <option value="{{ $key }}" onchange="updateSettings(this, 'cart_adhoc_template')" {{ get_setting('cart_adhoc_template') === $key ? "selected":"" }}>
                                            {{ $title }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>


                        <!-- MINI CART TEMPLATE -->
                        <div class="form-group row">
                            <label class="col-sm-3 col-from-label">{{ translate('Mini Cart Template') }}</label>
                            <input type="hidden" name="types[]" value="cart_mini_template">

                            <select name="cart_mini_template" class="col-sm-9 form-control aiz-selectpicker">
                                @if($mini_carts)
                                    @foreach($mini_carts as $key => $title)
                                        <option value="{{ $key }}" onchange="updateSettings(this, 'cart_mini_template')" {{ get_setting('cart_mini_template') === $key ? "selected":"" }}>
                                            {{ $title }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>

                        <div class="text-right">
                            <button type="submit" class="btn btn-primary">{{ translate('Update') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
