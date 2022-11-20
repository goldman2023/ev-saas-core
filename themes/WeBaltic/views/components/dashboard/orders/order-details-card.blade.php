<div>
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
                Z3ELK012XNK000001
            </div>
            <div>
                750 kg
                {{-- Current way of getting an attribute value --}}
                Width: {{ json_encode($order->get_primary_order_item()->subject->get_attribute_value_by_id(6)[0]['values']) }}

                Unit: {{ json_encode($order->get_primary_order_item()->subject->get_attribute_value_by_id(6)[0]) }}
                {{-- {{ json_encode($order->order_items[0]->get_attribute_value_by_id[9]) }} --}}
                <br>
                0 - 100 kg <br>
                1 - 375 kg <br>
                2 - 375 kg <br>
                3 -
            </div>
        </div>
        {{-- Right side --}}
        <div class="relative">
            <div class="flex justify-end">
            <img src="{{ get_site_logo() }}" class="h-24 mb-2" />
            </div>
            <div class="text-right flex justify-end">
                {!! QrCode::size(100)->generate(URL::current()) !!}
            </div>
            <div class="-rotate-90 absolute top-[80px] left-[-80px]">
            <div class="underline">
                www.tero-trailer.eu
            </div>
            <div class="underline">
                +370 (671) 91007
            </div>
            </div>
        </div>
    </div>
    {{-- Order VIN Code: {{ $order }} --}}
</div>
