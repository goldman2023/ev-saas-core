@extends('documents-templates.global-pdf-layout.pdf-layout')

@push('styles')
<style>

</style>
@endpush

@section('content')

<div class="text-sm py-3">
    <div class="w-full">
        p. {{ $order->billing_first_name }} {{ $order->billing_last_name }}
    </div>
    <div class="w-full flex flex-row gap-x-2">
        <span class="pr-3">Mob. tel.</span>  
        @if(!empty($order->phone_numbers)) 
            @foreach($order->phone_numbers as $number)
                <a href="tel:{{ $number }}" class="py-0.5 px-2 text-12 border rounded-md border-gray-200 text-gray-800">{{ $number }}</a>
            @endforeach
        @endif
    </div>
    <div class="w-full">
        El. Paštas:  {{ $order->email }}
    </div>

    <div class="w-full py-3 text-center">
        <h1 class="w-full text-20 font-bold">KOMERCINIS PASIŪLYMAS Nr. B2T-{{ $order->id }}</h1>
        <div class="w-full leading-0">{{ $order->updated_at->format('Y-m-d') }}</div>
        <div class="w-full leading-0">Kaunas</div>
    </div>

    <div class="w-full pb-4">
        <span class="font-bold">Pavadinimas:</span>  {{ $order->order_items->first()->name }}
    </div>

    <div class="w-full pb-3">
        Techniniai parametrai:
    </div>

    {{-- Add OrderItem attributes here --}}
    <div class="w-full pb-3">
        <span class="font-bold">Ilgis:</span>
        <span class="font-bold">Plotis:</span>
        <span class="font-bold">Bortai:</span>
    </div>

    <div class="w-full pb-3">
        <span class="font-bold">Bendroji masė:</span>
        <span class="font-bold">Ašis:</span>
        <span class="font-bold">Ratai:</span>
    </div>

    {{-- Upload `proposal_notes` wef --}}
    @if(!empty($proposal_notes = $upload->getWEF('proposal_notes', true, 'array')))
        <div class="w-full pb-3">
            <ul class="list-disc pl-5">
                @foreach($proposal_notes as $note)
                    <li>{{ $note }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    
    <div class="w-full pb-6">
        <span class="font-bold">Komplektacija:</span>  {{ $order->order_items->first()->name }}
    </div>

    <div class="w-full pb-4">
        <span class="font-bold">Suma (su PVM):</span>  {{ \FX::formatPrice($order->total_price) }}
    </div>

    <div class="w-full pb-10">
        <span class="font-bold">Papildoma įranga / paslaugos:</span>
    </div>

    <div class="w-full pb-10">
        <span class="font-bold">Su pagarba,<br/>Direktorius</span>
        <span>Eduard Terechov</span>
    </div>

    <div class="w-full">
        <table class="table-auto text-xs" style="border-spacing: 10px 0;">
            <thead>
              <tr>
                <th></th>
                <th></th>
                <th></th>
              </tr>
            </thead>
            <tbody class="">
              <tr>
                <td>UAB “Domantas”</td>
                <td>Įmonės kodas 302635282</td>
                <td>Tel: +370 671 81007</td>
              </tr>
              <tr>
                <td>Pakalnės g-vė 5e, Domeikava, Kauno r.</td>
                <td>Bankas SEB</td>
                <td>E-mail: krovininespriekabos@gmail.com</td>
              </tr>
              <tr>
                <td>LT- 54354 Kauno r.sav., Lithuania</td>
                <td>A/s LT66 7044 0600 0785 7947</td>
                <td>Skype: badutis</td>
              </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection
