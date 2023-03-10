@extends('documents-templates.global-pdf-layout.pdf-layout')

@php
$order_item = $order->get_primary_order_item();
@endphp

@section('content')
<div class="text-sm py-3">
    <div class="w-full">
        {{ $order->billing_first_name }} {{ $order->billing_last_name }}
    </div>
    @if(!empty($order->phone_numbers))
    <div class="w-full flex flex-row gap-x-2">
        <span class="pr-3">Mob. tel.</span>

        @foreach($order->phone_numbers as $number)
        <a href="tel:{{ $number }}" class="py-0.5 px-2 text-12 border rounded-md border-gray-200 text-gray-800">
            {{ $number }}
        </a>
        @endforeach
    </div>
    @endif

    <div class="w-full">
        El. Paštas: {{ $order->email }}
    </div>

    <div class="w-full py-3 text-center">
        <h1 class="w-full text-lg font-bold">KOMERCINIS PASIŪLYMAS Nr. B2T-{{ $order->id }}</h1>
        <div class="w-full leading-0">{{ $order->updated_at->format('Y-m-d') }}</div>
        <div class="w-full leading-0">Kaunas</div>
    </div>

    <div class="w-full pb-4">
        <span class="font-bold">Pavadinimas:</span> {{ $order->order_items->first()->name }}
    </div>

    <div class="w-full pb-3 font-bold">
        Techniniai parametrai:
    </div>

    {{-- Add OrderItem attributes here --}}
    <div class="w-full pb-3">
        <div class="w-full"><strong>Ilgis:</strong> {{ $order_item->getAttrValue('kraunamo-pavirsiaus-ilgis') }} mm
        </div>
        <div class="w-full"><strong>Plotis: </strong> {{ $order_item->getAttrValue('kraunamo-pavirsiaus-plotis') }} mm
        </div>
        <div class="w-full"><strong>Bortai: </strong> {{ $order_item->getAttrValue('bortu-aukstis') }} mm </div>
    </div>

    <div class="w-full pb-3">
        <div class="w-full"><strong>Bendroji masė: </strong> {{ $order_item->getAttrValue('priekabos-bendroji-mase') }}
            kg
            @php
            $vehicle_category = "O1";
            if($order_item->getAttrValue('stabdziai') == 'mechanical') {
            $vehicle_category = "O2";
            }
            @endphp
           <span style="text-decoration: underline;"> ({{ $vehicle_category }} Kategorija) </span>
        </div>
        <div class="w-full"><strong>Ašis: </strong> {{ $order_item->getAttrValue('asiu-kiekis') }}</div>
        <div class="w-full"><strong>Ratai: </strong> {{ $order_item->getAttrValue('padangos') }}</div>
    </div>



    <div class="w-full pb-6">
        <span class="font-bold">Komplektacija:</span>
        Atraminis ratukas
    </div>

    <div class="w-full pb-4">
        <span class="font-bold">Suma (su PVM):</span> {{ \FX::formatPrice($order->total_price) }}
    </div>

    <div class="w-full pb-10">
        <span class="font-bold">Papildoma įranga / paslaugos:</span>
        {{-- TODO: Can we add some defaults here? --}}
        {{-- Upload `proposal_notes` wef --}}
        @isset($upload)
        @if(!empty($proposal_notes = $upload->getWEF('proposal_notes', true, 'array')))
        <div class="w-full pb-3">
            <ul class="list-disc pl-5">
                @foreach($proposal_notes as $note)
                <li>{{ $note }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        @endisset

    </div>



    <div class="w-full pb-10">
        <span class="font-bold">Su pagarba,<br />Direktorius</span>
        <span>{{ get_setting('company_ceo_name') }}</span>
    </div>

    <div class="w-full">
        <table class="table-auto text-xs" style="width: 100%;">
            <thead>
                <tr>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody class="">
                <tr>
                    <td class="pr-2 font-bold">{{ get_setting('company_name') }}</td>
                    <td class="pr-2">Įmonės kodas {{ get_setting('company_number') }}</td>
                    <td class="pr-2">Tel: {{ get_primary_phone_number() }}</td>
                </tr>
                <tr>
                    <td class="pr-2">{{ get_setting('company_address') }}, {{ get_setting('company_city') }}, <br> {{
                        get_setting('company_postal_code') }}</td>
                    <td class="pr-2">{{ get_setting('company_bank_name') }}</td>
                    <td class="pr-2">E-mail: {{ get_setting('company_email') }} </td>
                </tr>
                <tr>

                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection
