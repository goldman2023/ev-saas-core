<div style="width:100%;">
    <table style="width: 100%; margin-bottom: 20px;">
        <tr>
            <td style="width: 70%;">
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
                        0 - 100 kg <br>
                        1 - 375 kg <br>
                        2 - 375 kg <br>
                        3 -
                    </div>
                </div>
            </td>
            <td style="width: 30%;">
                {{-- Right side --}}
                <div>
                    <div class="flex justify-end">
                        <img src="{{ get_site_logo() }}" class="h-24 mb-2" />
                    </div>
                    <div class="text-right flex justify-end">

                        {!! QrCode::size(100)->generate('http://baltic.ev-saas.localhost:8000/dashboard/tasks', public_path('qr-1.svg')) !!}
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
            </td>
        </tr>
    </table>
    {{-- Order VIN Code: {{ $order }} --}}
</div>
