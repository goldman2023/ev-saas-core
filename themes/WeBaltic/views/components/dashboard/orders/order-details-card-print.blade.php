@if(!empty($order_item))
    @php
        // TODO: THIS SHOULD BE REMOVED ONCE WE ADD ATTRIBUTE OVERRIDE TO Product OrderItem
        if(!empty($order_item->subject)) {
            $order_item = $order_item->subject;
        }
    @endphp
    <div class="w-full  border-gray-900" style="margin-bottom:0px;">
        <table style="width: 100%;">
            <tr>
                {{-- Left side --}}
                <td style="border: 1px solid black;">
                    <div style="min-width: 70%; padding: 10px 0px; padding-right: 80px;" class="text-center">
                        {{-- Left Side --}}
                        <div class="underline font-medium">
                            UAB Domantas
                        </div>
                        <div>
                            {{ generate_certificate_number($order_item->getAttrValue('sertifikato-numeris')) }}
                        </div>
                        <div style="max-width: 100%; padding: 0;" class="font-bold">
                            {{-- Z3ELK012XNK000001 --}}
                            <div class="border border-gray-700">
                            {{ generate_vin_code($order) }}
                            </div>
                        </div>
                        <div>
                            @php

                            if(empty($order_item)) {
                            $total_weight = 'Missing Weight data';
                            } else {
                                if( $order_item->getAttr('bendroji-mase')) {
                                    $total_weight = $order_item->getAttr('bendroji-mase')->attribute_values->first()->values;
                                } else {
                                    $total_weight = 'Missing Weight data';
                                }
                            }
                            @endphp

                            {{ $total_weight }} kg
                            {{-- Current way of getting an attribute value --}}
                            {{-- Width: {{
                            json_encode($order->get_primary_order_item()->subject->get_attribute_value_by_id(6)[0]['values'])
                            }}

                            Unit: {{ json_encode($order->get_primary_order_item()->subject->get_attribute_value_by_id(6)[0])
                            }} --}}
                            {{-- {{ json_encode($order->order_items[0]->get_attribute_value_by_id[9]) }} --}}
                            <br>

                            @php
                            if(empty($order_item)) {
                            $axel_count = 0;

                            } else {
                            if ($order_item->getAttr('asiu-kiekis')) {
                            $axel_count = $order_item->getAttr('asiu-kiekis')->attribute_values->first()->values;
                            } else {
                            $axel_count = 0;
                            }
                            }

                            if(empty($order_item)) {
                            $lifting_mass = 0;

                            } else {
                            if ($order_item->getAttr('priekabos-bendroji-mase')) {
                            $lifting_mass = $order_item->getAttr('priekabos-bendroji-mase')->attribute_values->first()->values;
                            } else {
                            $lifting_mass = 0;
                            }

                            }

                            @endphp
                            0 - {{ generate_static_mass_on_decoupling($order_item->getAttrValue('sertifikato-numeris')) }} <br>
                            @if($axel_count == 1)
                            1 - {{ $lifting_mass }} kg <br>
                            2 - <br>
                            3 -
                            @endif

                            @if($axel_count == 2)
                            1 - {{ $lifting_mass / 2 }} kg <br>
                            2 - {{ $lifting_mass / 2 }} kg <br>
                            3 -
                            @endif

                            @if($axel_count == 3)
                            1 - {{ $lifting_mass / 3 }} kg <br>
                            2 - {{ $lifting_mass / 3 }} kg <br>
                            3 - {{ $lifting_mass / 3 }} kg
                            @endif

                        </div>
                    </div>
                </td>

                {{-- Right side --}}
                <td>
                    <div class="relative">
                        <div style="text-align: right;" class="flex justify-end">
                            <img src="{{ get_site_logo() }}" class="h-24 mb-2" />
                        </div>
                        <div class="text-right flex justify-end">
                            <img
                                src="data:image/svg+xml;base64,  {!! base64_encode(QrCode::size(100)->generate($order->getPermalink())) !!}" />
                            {{-- {!! QrCode::size(100)->generate(URL::current()) !!} --}}
                        </div>
                        <div style=" -webkit-transform: rotate(-90deg);
                        -moz-transform: rotate(-90deg);
                        -o-transform: rotate(-90deg);
                        text-align: center;
                        -ms-transform: rotate(-90deg);
                        transform: rotate(-90deg); position: absolute; left: -80px; top: 80px;
                        min-width: 250px; ">
                            <div class="underline">
                                www.tero.lt
                            </div>
                            <div class="underline">
                                +370 (671) 91007
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
        </table>
    </div>
@else

@endif

