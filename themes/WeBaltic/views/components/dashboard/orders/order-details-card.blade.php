@if(!empty($order_item))
    <div class="w-full">
        @php
            if(!empty($order_item->subject)) {
                $order_item = $order_item->subject;
            }
        @endphp
        <div class="grid grid-cols-3 gap-9">
            <div class="col-span-2 text-center px-9 border border-r-1 border-gray-700">
                {{-- Left Side --}}
                <div class="underline font-medium">
                    UAB Domantas
                </div>
                <div>
                    {{ generate_certificate_number($order_item->getAttrValue('sertifikato-numeris')) }}
                    {{-- e9*2018/858*XXXXX --}}
                </div>
                <div class="border border-gray-700 p-2 rounded mb-1 font-bold">
                    {{-- Z3ELK012XNK000001 --}}
                    {{ generate_vin_code($order) }}
                </div>
                <div>
                    @php

                    if(empty($order_item)) {
                    $total_weight = 'Missing data';
                    } else {
                    if( $order_item->getAttr('priekabos-bendroji-mase')) {
                    $total_weight = $order_item->getAttr('priekabos-bendroji-mase')->attribute_values->first()->values;
                    } else {
                        $total_weight = 'Missing data';
                    }
                    }


                    @endphp
                    {{ $total_weight }} kg
                    {{-- Current way of getting an attribute value --}}
                    {{-- Width: {{
                    json_encode($order->get_primary_order_item()->subject->get_attribute_value_by_id(6)[0]['values']) }}

                    Unit: {{ json_encode($order->get_primary_order_item()->subject->get_attribute_value_by_id(6)[0]) }} --}}
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

                    @endphp

                    @php
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
            {{-- Right side --}}
            <div class="relative">
                <div class="flex justify-end">
                    <img src="{{ get_site_logo() }}" class="h-24 mb-2" />
                </div>
                <div class="text-right flex justify-end">
                <img src="data:image/svg+xml;base64,  {!! base64_encode(QrCode::size(100)->generate('https://tero.lt')) !!}" />

                    {{-- {!! QrCode::size(100)->generate(URL::current()) !!} --}}
                </div>
                <div class="-rotate-90 absolute top-[80px] left-[-80px]" style="margin-left: 15px;">
                    <div class="underline">
                        www.tero.lt
                    </div>
                    <div class="underline">
                        +370 (671) 91007
                    </div>
                </div>
            </div>
        </div>
        {{-- Order VIN Code: {{ $order }} --}}
    </div>
@else
{{-- Empty State... --}}
@endif

