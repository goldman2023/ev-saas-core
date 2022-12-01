@extends('documents_templates.global-pdf-layout.pdf-layout')

@section('content')
<div>p. Linas žvybas
    Mob. tel. 861547303
    El. Paštas: zv.mantas@gmail.com
</div>

<div class="center strong">
    KOMERCINIS PASIŪLYMAS Nr. B2T-{{ $order->id }}
</div>
<div class="center">
    2022-11-4
</div>
<div class="center">
    Kaunas
</div>
<div>
    <strong>Pavadinimas:</strong> {{ $order->get_primary_order_item()->name }} <br>
    <strong>Techniniai parametrai: </strong> <br>
    Ilgis: 4,00 m <br>
    Plotis: 2.00 m <br>
    Bortai: - cm <br>
    Bendroji masė 750 kg (O1 kategorija) <br>
    Ašis STC 2x750kg <br>
    Ratai 4 x 155R13 <br>
</div>

{{-- TODO Add default or custom list with WEF repeater --}}
<ul>
    <li>
        Rėmas gaminamas iš tarpusavyje virinamų profilinių vamzdžių.
    </li>
    <li>
        Priekabų konstrukcija po suvirinimo cinkuojama karštuoju būdu, kas garantuoja ne mažesnį
        kaip 100 μm cinko padengimą bei kokybiškiausią antikorozinę apsaugą.
    </li>
    <li>
        Priekaba komplektuojama su linginė pakaba + amortizatoriai
    </li>

    <li>
        Pagaminta panaudojant KNOTT detales ir mazgus.
    </li>

    <li>
        FRISTOM (Lenkija) apšvietimo įranga.
    </li>
</ul>

Komplektacija: Atraminis ratukas
<div class="strong">
    Suma (su PVM): {{ $order->total_price}}
</div>
<div>
    Papildoma įranga / paslaugos:
    {{-- TODO Add dynamic field here --}}
</div>

Su pagarba,
Direktorius Eduard Terechov
@endsection
