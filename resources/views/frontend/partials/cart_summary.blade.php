<div class="card border-0 shadow-sm rounded">
    <div class="card-header">
        <h3 class="fs-16 fw-600 mb-0">{{translate('Summary')}}</h3>
        <div class="text-right">
            <span class="badge badge-inline badge-primary">{{ count(Session::get('cart')->where('owner_id', Session::get('owner_id'))) }} {{translate('Items')}}</span>
        </div>
    </div>

    <div class="card-body">
        @if (\App\Models\Addon::where('unique_identifier', 'club_point')->first() != null && \App\Models\Addon::where('unique_identifier', 'club_point')->first()->activated)
            @php
                $total_point = 0;
            @endphp
            @foreach (Session::get('cart')->where('owner_id', Session::get('owner_id')) as $key => $cartItem)
                @php
                    $product = \App\Models\Product::find($cartItem['id']);
                    $total_point += $product->earn_point*$cartItem['quantity'];
                @endphp
            @endforeach
            <div class="rounded px-2 mb-2 bg-soft-primary border-soft-primary border">
                {{ translate("Total Club point") }}:
                <span class="fw-700 float-right">{{ $total_point }}</span>
            </div>
        @endif
        <table class="table">
            <thead>
                <tr>
                    <th class="product-name">{{translate('Product')}}</th>
                    <th class="product-total text-right">{{translate('Total')}}</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $subtotal = 0;
                    $tax = 0;
                    $shipping = 0;
                    $product_shipping_cost = 0;
                    $shipping_region = Session::get('shipping_info')['city'];
                @endphp
                @foreach (Session::get('cart')->where('owner_id', Session::get('owner_id')) as $key => $cartItem)
                    @php
                        $product = \App\Models\Product::find($cartItem['id']);
                        $subtotal += $cartItem['price']*$cartItem['quantity'];
                        $tax += $cartItem['tax']*$cartItem['quantity'];

                        if(isset($cartItem['shipping']) && is_array(json_decode($cartItem['shipping'], true))) {
                            foreach(json_decode($cartItem['shipping'], true) as $shipping_info => $val) {
                                if($shipping_region == $shipping_info) {
                                    $product_shipping_cost = (double) $val;
                                }
                            }
                        } else {
                            $product_shipping_cost = (double) $cartItem['shipping'];
                        }

                        if($product->is_quantity_multiplied == 1 && get_setting('shipping_type') == 'product_wise_shipping') {
                            $product_shipping_cost = $product_shipping_cost * $cartItem['quantity'];
                        }

                        $shipping += $product_shipping_cost;

                        $product_name_with_choice = $product->getTranslation('name');
                        if ($cartItem['variant'] != null) {
                            $product_name_with_choice = $product->getTranslation('name').' - '.$cartItem['variant'];
                        }
                    @endphp
                    <tr class="cart_item">
                        <td class="product-name">
                            {{ $product_name_with_choice }}
                            <strong class="product-quantity">× {{ $cartItem['quantity'] }}</strong>
                        </td>
                        <td class="product-total text-right">
                            <span class="pl-4">{{ single_price($cartItem['price']*$cartItem['quantity']) }}</span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <table class="table">

            <tfoot>
                <tr class="cart-subtotal">
                    <th>{{translate('Subtotal')}}</th>
                    <td class="text-right">
                        <span class="fw-600">{{ single_price($subtotal) }}</span>
                    </td>
                </tr>

                <tr class="cart-shipping">
                    <th>{{translate('Tax')}}</th>
                    <td class="text-right">
                        <span class="font-italic">{{ single_price($tax) }}</span>
                    </td>
                </tr>

                <tr class="cart-shipping">
                    <th>{{translate('Total Shipping')}}</th>
                    <td class="text-right">
                        <span class="font-italic">{{ single_price($shipping) }}</span>
                    </td>
                </tr>

                @if (Session::has('club_point'))
                    <tr class="cart-shipping">
                        <th>{{translate('Redeem point')}}</th>
                        <td class="text-right">
                            <span class="font-italic">{{ single_price(Session::get('club_point')) }}</span>
                        </td>
                    </tr>
                @endif

                @if (Session::has('coupon_discount'))
                    <tr class="cart-shipping">
                        <th>{{translate('Coupon Discount')}}</th>
                        <td class="text-right">
                            <span class="font-italic">{{ single_price(Session::get('coupon_discount')) }}</span>
                        </td>
                    </tr>
                @endif

                @php
                    $total = $subtotal+$tax+$shipping;
                    if(Session::has('club_point')) {
                        $total -= Session::get('club_point');
                    }
                    if(Session::has('coupon_discount')){
                        $total -= Session::get('coupon_discount');
                    }
                @endphp

                <tr class="cart-total">
                    <th><span class="strong-600">{{translate('Total')}}</span></th>
                    <td class="text-right">
                        <strong><span>{{ single_price($total) }}</span></strong>
                    </td>
                </tr>
            </tfoot>
        </table>

        @if (\App\Models\Addon::where('unique_identifier', 'club_point')->first() != null && \App\Models\Addon::where('unique_identifier', 'club_point')->first()->activated)
            @if (Session::has('club_point'))
                <div class="mt-3">
                    <form class="" action="{{ route('checkout.remove_club_point') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="input-group">
                            <div class="form-control">{{ Session::get('club_point')}}</div>
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-primary">{{translate('Remove Redeem Point')}}</button>
                            </div>
                        </div>
                    </form>
                </div>
            @else
                @if(auth()->user()->point_balance > 0)
                    <div class="mt-3">
                        <p>
                            {{translate('Your club point is')}}:
                            @if(isset(auth()->user()->point_balance))
                                {{ auth()->user()->point_balance }}
                            @endif
                        </p>
                        <form class="" action="{{ route('checkout.apply_club_point') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="input-group">
                                <input type="text" class="form-control" name="point" placeholder="{{translate('Enter club point here')}}" required>
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-primary">{{translate('Redeem')}}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                @endif
            @endif
        @endif

        @if (Auth::check() && \App\Models\BusinessSetting::where('type', 'coupon_system')->first()->value == 1)
            @if (Session::has('coupon_discount'))
                <div class="mt-3">
                    <form class="" action="{{ route('checkout.remove_coupon_code') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="input-group">
                            <div class="form-control">{{ \App\Models\Coupon::find(Session::get('coupon_id'))->code }}</div>
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-primary">{{translate('Change Coupon')}}</button>
                            </div>
                        </div>
                    </form>
                </div>
            @else
                <div class="mt-3">
                    <form class="" action="{{ route('checkout.apply_coupon_code') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="input-group">
                            <input type="text" class="form-control" name="code" placeholder="{{translate('Have coupon code? Enter here')}}" required>
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-primary">{{translate('Apply')}}</button>
                            </div>
                        </div>
                    </form>
                </div>
            @endif
        @endif

    </div>
</div>
