@extends('frontend.layouts.' . $globalLayout)

@section('meta_title'){{ translate('Checkout page').' '.\TenantSettings::get('site_name').' | '.\TenantSettings::get('site_motto') }}@stop

@section('meta_keywords'){{ translate('checkout, cart, purchase, ecommerce') }}@stop

@section('meta')

@endsection

@section('content')
    <section class="checkout position-relative mb-5"
        x-data="{
            selected_shipping_method: 0
        }"
    >
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="bg-white rounded card">

                        <div class="card-body">
                            <div class="border-bottom pb-2 mb-3">
                                <h3 class="card-header-title">{{ translate('Billing and shipping information') }}</h3>
                            </div>

                            <!-- Content -->
                            <div class="container">

                                <!-- Form -->
                                <form class="needs-validation" novalidate>
                                    <div class="row g-3">
                                        <div class="col-sm-6">
                                            <label for="firstNameShopCheckout" class="form-label">{{ translate('First name') }}</label>
                                            <input type="text" class="form-control" id="firstNameShopCheckout" placeholder="" value="" required>
                                            <div class="invalid-feedback">
                                                Valid first name is required.
                                            </div>
                                        </div>
                                        <!-- End Col -->

                                        <div class="col-sm-6">
                                            <label for="lastNameShopCheckout" class="form-label">Last name</label>
                                            <input type="text" class="form-control" id="lastNameShopCheckout" placeholder="" value="" required>
                                            <div class="invalid-feedback">
                                                Valid last name is required.
                                            </div>
                                        </div>
                                        <!-- End Col -->

                                        <div class="col-12 mt-2">
                                            <label for="emailShopCheckout" class="form-label">Email</label>
                                            <input type="email" class="form-control " id="emailShopCheckout" placeholder="you@example.com">
                                            <div class="invalid-feedback">
                                                Please enter a valid email address for shipping updates.
                                            </div>
                                        </div>
                                        <!-- End Col -->

                                        <div class="col-12 mt-2">
                                            <label for="addressShopCheckout" class="form-label">Address</label>
                                            <input type="text" class="form-control " id="addressShopCheckout" placeholder="1234 Main St" required>
                                            <div class="invalid-feedback">
                                                Please enter your shipping address.
                                            </div>
                                        </div>
                                        <!-- End Col -->

                                        <div class="col-12 mt-2">
                                            <label for="address2ShopCheckout" class="form-label">Address 2 <span class="form-label-secondary">(Optional)</span></label>
                                            <input type="text" class="form-control " id="address2ShopCheckout" placeholder="Apartment or suite">
                                        </div>
                                        <!-- End Col -->

                                        <!-- Add Phone number -->
                                        <div id="addSerialNumberTemplate" class="w-100" style="display: none;">
                                            <div class="d-flex flex-row align-items-start w-100 pb-2">
                                                <div class="input-group-add-field mt-0 pr-3">
                                                    <input type="text" name="serial_number" class="form-control" value="" />
                                                </div>
                                                <div class="input-group-add-field mt-1 mr-3">
                                                    <select class="js-custom-select-dynamic" name="serial_number_status" data-hs-select2-options='{
                                                              "minimumResultsForSearch": "Infinity",
                                                              "customClass": "custom-select custom-select-sm",
                                                              "dropdownAutoWidth": true,
                                                              "width": true
                                                    }'>
                                                        <option value="in_stock" >{{ translate('In stock') }}</option>
                                                        <option value="out_of_stock" >{{ translate('Out of stock') }}</option>
                                                        <option value="reserved" >{{ translate('Reserved') }}</option>
                                                    </select>
                                                </div>

                                                <div class="input-group-add-field " style="margin-top: 12px;">
                                                    <button type="button" class="btn btn-danger btn-xs p-1 rounded js-delete-field d-inline-flex">
                                                        @svg('heroicon-o-x', ['style' => 'width: 16px; height: 16px;'])
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End Add Serial Number Template -->

                                        <div class="col-md-5 mt-2">
                                            <label for="countryShopCheckout" class="form-label">Country</label>

                                            <!-- Select -->
                                            <select class="form-select" id="country ShopCheckout" required>
                                                <option value="">Choose...</option>
                                                <option value="">Select country</option>
                                                <option value="AF">Afghanistan</option>
                                                <option value="AX">Åland Islands</option>
                                                <option value="AL">Albania</option>
                                                <option value="DZ">Algeria</option>
                                                <option value="AS">American Samoa</option>
                                                <option value="AD">Andorra</option>
                                                <option value="AO">Angola</option>
                                                <option value="AI">Anguilla</option>
                                                <option value="AQ">Antarctica</option>
                                                <option value="AG">Antigua and Barbuda</option>
                                                <option value="AR">Argentina</option>
                                                <option value="AM">Armenia</option>
                                                <option value="AW">Aruba</option>
                                                <option value="AU">Australia</option>
                                                <option value="AT">Austria</option>
                                                <option value="AZ">Azerbaijan</option>
                                                <option value="BS">Bahamas</option>
                                                <option value="BH">Bahrain</option>
                                                <option value="BD">Bangladesh</option>
                                                <option value="BB">Barbados</option>
                                                <option value="BY">Belarus</option>
                                                <option value="BE">Belgium</option>
                                                <option value="BZ">Belize</option>
                                                <option value="BJ">Benin</option>
                                                <option value="BM">Bermuda</option>
                                                <option value="BT">Bhutan</option>
                                                <option value="BO">Bolivia, Plurinational State of</option>
                                                <option value="BQ">Bonaire, Sint Eustatius and Saba</option>
                                                <option value="BA">Bosnia and Herzegovina</option>
                                                <option value="BW">Botswana</option>
                                                <option value="BV">Bouvet Island</option>
                                                <option value="BR">Brazil</option>
                                                <option value="IO">British Indian Ocean Territory</option>
                                                <option value="BN">Brunei Darussalam</option>
                                                <option value="BG">Bulgaria</option>
                                                <option value="BF">Burkina Faso</option>
                                                <option value="BI">Burundi</option>
                                                <option value="KH">Cambodia</option>
                                                <option value="CM">Cameroon</option>
                                                <option value="CA">Canada</option>
                                                <option value="CV">Cape Verde</option>
                                                <option value="KY">Cayman Islands</option>
                                                <option value="CF">Central African Republic</option>
                                                <option value="TD">Chad</option>
                                                <option value="CL">Chile</option>
                                                <option value="CN">China</option>
                                                <option value="CX">Christmas Island</option>
                                                <option value="CC">Cocos (Keeling) Islands</option>
                                                <option value="CO">Colombia</option>
                                                <option value="KM">Comoros</option>
                                                <option value="CG">Congo</option>
                                                <option value="CD">Congo, the Democratic Republic of the</option>
                                                <option value="CK">Cook Islands</option>
                                                <option value="CR">Costa Rica</option>
                                                <option value="CI">Côte d'Ivoire</option>
                                                <option value="HR">Croatia</option>
                                                <option value="CU">Cuba</option>
                                                <option value="CW">Curaçao</option>
                                                <option value="CY">Cyprus</option>
                                                <option value="CZ">Czech Republic</option>
                                                <option value="DK">Denmark</option>
                                                <option value="DJ">Djibouti</option>
                                                <option value="DM">Dominica</option>
                                                <option value="DO">Dominican Republic</option>
                                                <option value="EC">Ecuador</option>
                                                <option value="EG">Egypt</option>
                                                <option value="SV">El Salvador</option>
                                                <option value="GQ">Equatorial Guinea</option>
                                                <option value="ER">Eritrea</option>
                                                <option value="EE">Estonia</option>
                                                <option value="ET">Ethiopia</option>
                                                <option value="FK">Falkland Islands (Malvinas)</option>
                                                <option value="FO">Faroe Islands</option>
                                                <option value="FJ">Fiji</option>
                                                <option value="FI">Finland</option>
                                                <option value="FR">France</option>
                                                <option value="GF">French Guiana</option>
                                                <option value="PF">French Polynesia</option>
                                                <option value="TF">French Southern Territories</option>
                                                <option value="GA">Gabon</option>
                                                <option value="GM">Gambia</option>
                                                <option value="GE">Georgia</option>
                                                <option value="DE">Germany</option>
                                                <option value="GH">Ghana</option>
                                                <option value="GI">Gibraltar</option>
                                                <option value="GR">Greece</option>
                                                <option value="GL">Greenland</option>
                                                <option value="GD">Grenada</option>
                                                <option value="GP">Guadeloupe</option>
                                                <option value="GU">Guam</option>
                                                <option value="GT">Guatemala</option>
                                                <option value="GG">Guernsey</option>
                                                <option value="GN">Guinea</option>
                                                <option value="GW">Guinea-Bissau</option>
                                                <option value="GY">Guyana</option>
                                                <option value="HT">Haiti</option>
                                                <option value="HM">Heard Island and McDonald Islands</option>
                                                <option value="VA">Holy See (Vatican City State)</option>
                                                <option value="HN">Honduras</option>
                                                <option value="HK">Hong Kong</option>
                                                <option value="HU">Hungary</option>
                                                <option value="IS">Iceland</option>
                                                <option value="IN">India</option>
                                                <option value="ID">Indonesia</option>
                                                <option value="IR">Iran, Islamic Republic of</option>
                                                <option value="IQ">Iraq</option>
                                                <option value="IE">Ireland</option>
                                                <option value="IM">Isle of Man</option>
                                                <option value="IL">Israel</option>
                                                <option value="IT">Italy</option>
                                                <option value="JM">Jamaica</option>
                                                <option value="JP">Japan</option>
                                                <option value="JE">Jersey</option>
                                                <option value="JO">Jordan</option>
                                                <option value="KZ">Kazakhstan</option>
                                                <option value="KE">Kenya</option>
                                                <option value="KI">Kiribati</option>
                                                <option value="KP">Korea, Democratic People's Republic of</option>
                                                <option value="KR">Korea, Republic of</option>
                                                <option value="KW">Kuwait</option>
                                                <option value="KG">Kyrgyzstan</option>
                                                <option value="LA">Lao People's Democratic Republic</option>
                                                <option value="LV">Latvia</option>
                                                <option value="LB">Lebanon</option>
                                                <option value="LS">Lesotho</option>
                                                <option value="LR">Liberia</option>
                                                <option value="LY">Libya</option>
                                                <option value="LI">Liechtenstein</option>
                                                <option value="LT">Lithuania</option>
                                                <option value="LU">Luxembourg</option>
                                                <option value="MO">Macao</option>
                                                <option value="MK">Macedonia, the former Yugoslav Republic of</option>
                                                <option value="MG">Madagascar</option>
                                                <option value="MW">Malawi</option>
                                                <option value="MY">Malaysia</option>
                                                <option value="MV">Maldives</option>
                                                <option value="ML">Mali</option>
                                                <option value="MT">Malta</option>
                                                <option value="MH">Marshall Islands</option>
                                                <option value="MQ">Martinique</option>
                                                <option value="MR">Mauritania</option>
                                                <option value="MU">Mauritius</option>
                                                <option value="YT">Mayotte</option>
                                                <option value="MX">Mexico</option>
                                                <option value="FM">Micronesia, Federated States of</option>
                                                <option value="MD">Moldova, Republic of</option>
                                                <option value="MC">Monaco</option>
                                                <option value="MN">Mongolia</option>
                                                <option value="ME">Montenegro</option>
                                                <option value="MS">Montserrat</option>
                                                <option value="MA">Morocco</option>
                                                <option value="MZ">Mozambique</option>
                                                <option value="MM">Myanmar</option>
                                                <option value="NA">Namibia</option>
                                                <option value="NR">Nauru</option>
                                                <option value="NP">Nepal</option>
                                                <option value="NL">Netherlands</option>
                                                <option value="NC">New Caledonia</option>
                                                <option value="NZ">New Zealand</option>
                                                <option value="NI">Nicaragua</option>
                                                <option value="NE">Niger</option>
                                                <option value="NG">Nigeria</option>
                                                <option value="NU">Niue</option>
                                                <option value="NF">Norfolk Island</option>
                                                <option value="MP">Northern Mariana Islands</option>
                                                <option value="NO">Norway</option>
                                                <option value="OM">Oman</option>
                                                <option value="PK">Pakistan</option>
                                                <option value="PW">Palau</option>
                                                <option value="PS">Palestinian Territory, Occupied</option>
                                                <option value="PA">Panama</option>
                                                <option value="PG">Papua New Guinea</option>
                                                <option value="PY">Paraguay</option>
                                                <option value="PE">Peru</option>
                                                <option value="PH">Philippines</option>
                                                <option value="PN">Pitcairn</option>
                                                <option value="PL">Poland</option>
                                                <option value="PT">Portugal</option>
                                                <option value="PR">Puerto Rico</option>
                                                <option value="QA">Qatar</option>
                                                <option value="RE">Réunion</option>
                                                <option value="RO">Romania</option>
                                                <option value="RU">Russian Federation</option>
                                                <option value="RW">Rwanda</option>
                                                <option value="BL">Saint Barthélemy</option>
                                                <option value="SH">Saint Helena, Ascension and Tristan da Cunha</option>
                                                <option value="KN">Saint Kitts and Nevis</option>
                                                <option value="LC">Saint Lucia</option>
                                                <option value="MF">Saint Martin (French part)</option>
                                                <option value="PM">Saint Pierre and Miquelon</option>
                                                <option value="VC">Saint Vincent and the Grenadines</option>
                                                <option value="WS">Samoa</option>
                                                <option value="SM">San Marino</option>
                                                <option value="ST">Sao Tome and Principe</option>
                                                <option value="SA">Saudi Arabia</option>
                                                <option value="SN">Senegal</option>
                                                <option value="RS">Serbia</option>
                                                <option value="SC">Seychelles</option>
                                                <option value="SL">Sierra Leone</option>
                                                <option value="SG">Singapore</option>
                                                <option value="SX">Sint Maarten (Dutch part)</option>
                                                <option value="SK">Slovakia</option>
                                                <option value="SI">Slovenia</option>
                                                <option value="SB">Solomon Islands</option>
                                                <option value="SO">Somalia</option>
                                                <option value="ZA">South Africa</option>
                                                <option value="GS">South Georgia and the South Sandwich Islands</option>
                                                <option value="SS">South Sudan</option>
                                                <option value="ES">Spain</option>
                                                <option value="LK">Sri Lanka</option>
                                                <option value="SD">Sudan</option>
                                                <option value="SR">Suriname</option>
                                                <option value="SJ">Svalbard and Jan Mayen</option>
                                                <option value="SZ">Swaziland</option>
                                                <option value="SE">Sweden</option>
                                                <option value="CH">Switzerland</option>
                                                <option value="SY">Syrian Arab Republic</option>
                                                <option value="TW">Taiwan, Province of China</option>
                                                <option value="TJ">Tajikistan</option>
                                                <option value="TZ">Tanzania, United Republic of</option>
                                                <option value="TH">Thailand</option>
                                                <option value="TL">Timor-Leste</option>
                                                <option value="TG">Togo</option>
                                                <option value="TK">Tokelau</option>
                                                <option value="TO">Tonga</option>
                                                <option value="TT">Trinidad and Tobago</option>
                                                <option value="TN">Tunisia</option>
                                                <option value="TR">Turkey</option>
                                                <option value="TM">Turkmenistan</option>
                                                <option value="TC">Turks and Caicos Islands</option>
                                                <option value="TV">Tuvalu</option>
                                                <option value="UG">Uganda</option>
                                                <option value="UA">Ukraine</option>
                                                <option value="AE">United Arab Emirates</option>
                                                <option value="GB">United Kingdom</option>
                                                <option value="US">United States</option>
                                                <option value="UM">United States Minor Outlying Islands</option>
                                                <option value="UY">Uruguay</option>
                                                <option value="UZ">Uzbekistan</option>
                                                <option value="VU">Vanuatu</option>
                                                <option value="VE">Venezuela, Bolivarian Republic of</option>
                                                <option value="VN">Viet Nam</option>
                                                <option value="VG">Virgin Islands, British</option>
                                                <option value="VI">Virgin Islands, U.S.</option>
                                                <option value="WF">Wallis and Futuna</option>
                                                <option value="EH">Western Sahara</option>
                                                <option value="YE">Yemen</option>
                                                <option value="ZM">Zambia</option>
                                                <option value="ZW">Zimbabwe</option>
                                            </select>
                                            <!-- End Select -->

                                            <div class="invalid-feedback">
                                                Please select a valid country.
                                            </div>
                                        </div>
                                        <!-- End Col -->

                                        <div class="col-md-4 mt-2">
                                            <label for="stateShopCheckout" class="form-label">State</label>

                                            <!-- Select -->
                                            <select class="form-select" id="stateShopCheckout" required>
                                                <option value="">Choose...</option>
                                                <option>California</option>
                                            </select>
                                            <!-- End Select -->

                                            <div class="invalid-feedback">
                                                Please provide a valid state.
                                            </div>
                                        </div>
                                        <!-- End Col -->

                                        <div class="col-md-3 mt-2">
                                            <label for="zipShopCheckout" class="form-label">Zip</label>
                                            <input type="text" class="form-control " id="zipShopCheckout" placeholder="" required>
                                            <div class="invalid-feedback">
                                                Zip code required.
                                            </div>
                                        </div>
                                        <!-- End Col -->
                                    </div>

                                    <hr class="my-3">

                                    <div class="d-flex flex-column">
                                        <!-- Check -->
                                        <div class="form-check mb-1">
                                            <input type="checkbox" class="form-check-input" id="sameAddressShopCheckout">
                                            <label class="form-check-label" for="sameAddressShopCheckout">Shipping address is the same as my billing address</label>
                                        </div>
                                        <!-- End Check -->

                                        <!-- Check -->
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="saveInfoShopCheckout">
                                            <label class="form-check-label" for="saveInfoShopCheckout">Save this information for next time</label>
                                        </div>
                                        <!-- End Check -->
                                    </div>

                                    <hr class="my-3">

                                    <h4 class="mb-3">Payment</h4>

                                    <div class="my-3">
                                        <!-- Check -->
                                        <div class="form-check">
                                            <input id="creditShopCheckout" name="paymentMethod" type="radio" class="form-check-input" checked required>
                                            <label class="form-check-label" for="creditShopCheckout">Credit card</label>
                                        </div>
                                        <!-- End Check -->

                                        <!-- Check -->
                                        <div class="form-check">
                                            <input id="debitShopCheckout" name="paymentMethod" type="radio" class="form-check-input" required>
                                            <label class="form-check-label" for="debitShopCheckout">Debit card</label>
                                        </div>
                                        <!-- End Check -->

                                        <!-- Check -->
                                        <div class="form-check">
                                            <input id="paypalShopCheckout" name="paymentMethod" type="radio" class="form-check-input" required>
                                            <label class="form-check-label" for="paypalShopCheckout">PayPal</label>
                                        </div>
                                        <!-- End Check -->
                                    </div>

                                    <div class="row gy-3">
                                        <div class="col-md-6">
                                            <label for="ccNameShopCheckout" class="form-label">Name on card</label>
                                            <input type="text" class="form-control " id="ccNameShopCheckout" placeholder="" required>
                                            <small class="text-muted">Full name as displayed on card</small>
                                            <div class="invalid-feedback">
                                                Name on card is required
                                            </div>
                                        </div>
                                        <!-- End Col -->

                                        <div class="col-md-6">
                                            <label for="ccNumberShopCheckout" class="form-label">Credit card number</label>
                                            <input type="text" class="form-control " id="ccNumberShopCheckout" placeholder="" required>
                                            <div class="invalid-feedback">
                                                Credit card number is required
                                            </div>
                                        </div>
                                        <!-- End Col -->

                                        <div class="col-md-3 mt-2">
                                            <label for="ccExpirationShopCheckout" class="form-label">Expiration</label>
                                            <input type="text" class="form-control " id="ccExpirationShopCheckout" placeholder="" required>
                                            <div class="invalid-feedback">
                                                Expiration date required
                                            </div>
                                        </div>
                                        <!-- End Col -->

                                        <div class="col-md-3 mt-2">
                                            <label for="ccCvvShopCheckout" class="form-label">CVV</label>
                                            <input type="text" class="form-control " id="ccCvvShopCheckout" placeholder="" required>
                                            <div class="invalid-feedback">
                                                Security code required
                                            </div>
                                        </div>
                                        <!-- End Col -->
                                    </div>
                                    <!-- End Row -->

                                    <hr class="my-4">

                                    <div class="row align-items-center">
                                        <div class="col-sm-6 order-sm-1 mb-3 mb-sm-0">
                                            <div class="d-grid">
                                                <button type="submit" class="btn btn-primary">Place order</button>
                                            </div>
                                        </div>
                                        <!-- End Col -->

                                        <div class="col-sm text-left d-flex">
                                            <a class="link d-flex align-items-center justify-content-left text-dark text-14 mr-auto" href="{{ route('cart') }}">
                                                @svg('heroicon-o-chevron-left', ['class' => 'square-16 mr-1'])
                                                <span>{{ translate('Go back to cart') }}</span>
                                            </a>
                                        </div>
                                        <!-- End Col -->
                                    </div>
                                    <!-- End Row -->
                                </form>
                                <!-- End Form -->
                            </div>
                            <!-- End Content -->
                        </div>

                    </div>
                </div>

                <!-- Order Summary -->
                <div class="col-lg-4">
                    <div class="bg-white rounded card">
                        <div class="card-body">
                            <div class="border-bottom pb-2 mb-3">
                                <h3 class="card-header-title">{{ translate('Order summary') }}</h3>
                            </div>

                            <div class="">
                                @if($cart_items->isNotEmpty())
                                    @foreach($cart_items as $item)
                                        @php
                                            $has_variations = ($item->hasMain()) ? $item->main->getTranslation('name') : $item->hasVariations();
                                            $name = ($item->hasMain()) ? $item->main->getTranslation('name') : $item->getTranslation('name');
                                            $excerpt = ($item->hasMain()) ? $item->main->getTranslation('excerpt') : $item->getTranslation('excerpt');
                                            $permalink = ($item->hasMain()) ? $item->main->permalink : $item->permalink;
                                            $variant_name = ($item->hasMain()) ? $item->getVariantName(key_by: 'name') : null;
                                        @endphp

                                        <!-- Cart Item -->
                                            <div class="border-bottom pb-3 mb-3">
                                                <div class="d-flex">
                                                    <div class="flex-shrink-0">
                                                        <div class="avatar avatar-lg mr-3">
                                                            <a href="{{ $permalink }}" target="_blank">
                                                                <img class="avatar-img border" src="{{ $item->getThumbnail(['w'=>100,'h'=>100]) }}" alt="{{ $name }}">
                                                                <sup class="avatar-status bg-primary text-white">{{ $item->purchase_quantity }}</sup>
                                                            </a>
                                                        </div>
                                                    </div>

                                                    <div class="flex-grow-1">
                                                        <h6 class="clearfix mb-1">
                                                            <div class="badge badge-soft-info float-right">
                                                                {{ \FX::formatPrice($item->purchase_quantity * $item->total_price) }}
                                                            </div>

                                                            <a href="{{ $permalink }}" target="_blank">
                                                                {{ $name }}
                                                            </a>
                                                        </h6>

                                                        @if($has_variations)
                                                            <div class="d-grid">
                                                                @if($variant_name->isNotEmpty())
                                                                    @foreach($variant_name as $attribute_name => $attribute_value)
                                                                        <div class="text-body lh-13">
                                                                            <span class="small">{{ $attribute_name }}:</span>
                                                                            <span class="small">{{ $attribute_value }}</span>
                                                                        </div>
                                                                    @endforeach
                                                                @endif
                                                            </div>
                                                        @else
                                                            <span class="clamp text-12 mb-2" data-clamp-lines="2">{{ $excerpt }}</span>
                                                        @endif

                                                    </div>
                                                </div>
                                            </div>
                                            <!-- End Cart Item -->
                                    @endforeach



                                        <!-- Subtotal Calculation -->
                                        <div class="border-bottom pb-2 mb-3">
                                            <div class="d-grid gap-3">
                                                <dl class="row mb-1">
                                                    <dt class="col-sm-6">{{ translate('Items') }} ({{ $total_items_count }})</dt>
                                                    <dd class="col-sm-6 text-right mb-0 "><strong>{{ $originalPrice['display'] }}</strong></dd>
                                                </dl>

                                                <dl class="row mb-1">
                                                    <dt class="col-sm-6">{{ translate('Discount') }}</dt>
                                                    <dd class="col-sm-6 text-right text-success mb-0"><strong>-{{ $discountedAmount['display'] }}</strong></dd>
                                                </dl>

                                                {{-- TODO: Add Shipping Cost (and shipping  and VAT cost. Is discount calculated when VAT is included in price or not? --}}

                                                <span class="divider divider-third-right py-2"></span>

                                                <dl class="row mb-1">
                                                    <dt class="col-sm-6">{{ translate('Subtotal') }}</dt>
                                                    <dd class="col-sm-6 text-right mb-0 "><strong>{{ $subtotalPrice['display'] }}</strong></dd>
                                                </dl>

                                            </div>
                                        </div>
                                        <!-- End Subtotal Calculation -->

                                        <!-- Shipping Method Selector -->
                                        <div class="border-bottom pb-3 mb-3">
                                            <div class="d-grid gap-3">
                                                <!-- Check -->
                                                <div class="form-check pointer">
                                                    <input class="form-check-input" type="radio" name="deliveryRadioName" id="deliveryRadio1Eg2"
                                                           x-bind:checked="selected_shipping_method === 0"
                                                           @click="selected_shipping_method=0">
                                                    <label class="form-check-label text-dark pointer" for="deliveryRadio1Eg2">
                                                        Free - Standard delivery
                                                        <span class="d-block text-muted small">Shipment may take 10+ business days</span>
                                                    </label>
                                                </div>
                                                <!-- End Check -->

                                                <!-- Check -->
                                                <div class="form-check pointer mt-2">
                                                    <input class="form-check-input" type="radio" name="deliveryRadioName" id="deliveryRadio2Eg2"
                                                           x-bind:checked="selected_shipping_method === 1"
                                                           @click="selected_shipping_method=1">
                                                    <label class="form-check-label text-dark pointer" for="deliveryRadio2Eg2">
                                                        $9.99 - Express delivery
                                                        <span class="d-block text-muted small">Shipment may take 2-3 business days</span>
                                                    </label>
                                                </div>
                                                <!-- End Check -->
                                            </div>
                                        </div>
                                        <!-- End Shipping Method Selector -->

                                        <!-- Total Calculation -->
                                        <div class="">
                                            <div class="d-grid gap-3">
                                                <dl class="row mb-1">
                                                    <dt class="col-sm-6">{{ translate('Delivery') }}</dt>
                                                    <dd class="col-sm-6 text-right mb-0">Free</dd>
                                                </dl>
                                                <dl class="row mb-0">
                                                    <dt class="col-sm-6 capitalize">{{ translate('Total') }}</dt>
                                                    <dd class="col-sm-6 text-right text-dark mb-0 "><strong>{{ $subtotalPrice['display'] }}</strong></dd>
                                                </dl>
                                            </div>
                                        </div>
                                        <!-- End Total Calculation -->

                                        <div class="d-flex flex-column">
                                            <a href="{{ '#' }}" class="btn btn-primary mt-3">
                                                {{ translate('Place order') }}
                                            </a>
                                            <a href="{{ route('cart') }}" class="d-none align-items-center w-100 justify-content-center text-dark text-12 mt-3">
                                                @svg('heroicon-o-chevron-left', ['class' => 'square-12 mr-1'])
                                                <span>{{ translate('or go back to cart') }}</span>
                                            </a>
                                        </div>
                                @else
                                    <!-- Empty Cart Section -->
                                    <div class="container-fluid space-2">
                                        <div class="text-center mx-md-auto">
                                            <figure class="max-w-10rem max-w-sm-15rem mx-auto mb-3">
                                                @svg('lineawesome-shopping-cart-solid', ['class' => 'text-dark', 'style' => 'width: 72px;'])
                                            </figure>
                                            <div class="mb-5">
                                                <h3 class="h3">{{ translate('Your cart is currently empty') }}</h3>
                                                <p>{{ translate('Before you can checkout you must add some products to your shopping cart.') }}</p>
                                            </div>
                                            <a class="btn btn-primary btn-pill transition-3d-hover px-5" href="{{ route('search') }}">
                                                {{ translate('Start Shopping') }}
                                            </a>
                                        </div>
                                    </div>
                                    <!-- End Empty Cart Section -->
                                @endif

                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Order SUmmary -->
            </div>
        </div>
    </section>
@endsection

@section('modal')
