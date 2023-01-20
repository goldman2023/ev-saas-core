<div class="w-full">
    <div class="grid grid-cols-3 gap-9">
        <div class="col-span-2 text-center px-9 border border-r-1 border-gray-700">
            {{-- Left Side --}}
            <div class="underline font-medium">
                UAB Domantas
            </div>
            <div>
                e9*2018/858*XXXXX
            </div>
            <div class="border border-gray-700 p-2 rounded mb-1 font-bold">
                {{-- Z3ELK012XNK000001 --}}
                {{ generate_vin_code($order) }}
            </div>
            <div>
                @php

                if(empty($product)) {
                $total_weight = 'Missing data';
                } else {
                if( $product->getAttr('priekabos-nuosava-mase')) {
                $total_weight = $product->getAttr('priekabos-nuosava-mase')->attribute_values->first()->values;
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
                if(empty($product)) {
                $axel_count = 0;

                } else {
                if ($product->getAttr('asiu-kiekis')) {
                $axel_count = $product->getAttr('asiu-kiekis')->attribute_values->first()->values;
                } else {
                $axel_count = 0;
                }
                }



                @endphp

                @php
                if(empty($product)) {
                $lifting_mass = 0;

                } else {
                if ($product->getAttr('priekabos-bendroji-mase')) {
                $lifting_mass = $product->getAttr('priekabos-bendroji-mase')->attribute_values->first()->values;
                } else {
                $lifting_mass = 0;
                }

                }

                @endphp

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
               <img src="data:image/svg+xml;base64,  {!! base64_encode(QrCode::size(100)->generate($order->getPermalink())) !!}" />
                {{-- {!! QrCode::size(100)->generate(URL::current()) !!} --}}
            </div>
            <div class="-rotate-90 absolute top-[80px] left-[-80px]">
                <div class="underline">
                    www.tero.lt
                </div>
                <div class="underline">
                    +370 (671) 91007
                </div>
            </div>
        </div>
    </div>
</div>
