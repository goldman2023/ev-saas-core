@extends('documents-templates.global-pdf-layout.pdf-layout')

@section('content')
<style>
    td {
        vertical-align: top;
    }
</style>
<h1 class="text-center text-2xl font-bold w-full">
    SUTARTIS Nr. {{ $order->created_at->format('Y-m-j') }}
</h1>
<div>
    Kaunas, du tūkstančiai dvidešimtų antrųjų metų lapkričio mėnesio 3 diena
</div>
{{ get_setting('company_name') }} (Į/k {{ get_setting('company_code') }}) veikiantis, toliau vadinama "Gamintojas” iš
vienos pusės, ir
{{ $order->billing_first_name }} {{ $order->billing_last_name }}
@isset($order->billing_company_code)
({{ $order->billing_company_code }})
@endisset
toliau vadinama "Užsakovu" iš kitos pusės, sudarėme šią sutartį:


<div class="strong">
    1. Sutarties objektas
</div>

<p>
    Gamintojas įsipareigoja Užsakovui pagaminti automobilinę priekabą, pagal kom. pasiūlymą B2T-{{ $order->id }} kuris
    yra
    neatskiriama šios sutarties dalis
    Užsakovo užsakytų darbų bendra vertė:
</p>

{{-- TODO: Add pricing breakdown table here --}}
<table>
    <tr>
        <td>
            PVM
        </td>
        <td>
            Suma
        </td>
    </tr>

    <tr>
        <td>
        </td>
        <td>
        </td>
    </tr>
</table>


<div class="strong">
    2. Atsiskaitymo tvarka
</div>
<div>
    2.1. Užsakovas įsipareigoja apmokėti už lengvojo automobilio priekabą pagal žemiau nurodyta schemą:
</div>
<div>
    2.1.1. Avansas 30% sumos, 750,00- Eur (septyni šimtai penkiasdešimt eurų ir 00) sutarties pasirašymo metu.
</div>
<div>
    2.1.3. O likusia sumą t.y. 1750,00 -Eur (vienas tūkstantis septyni šimtai penkiasdešimt eurų ir 00 ct.) priekabos
    atsiemimo metu.
</div>
<div class="strong">
    3. Šalių teisės ir pareigos
</div>

<div>
    3.1. Gamintojas įsipareigoja pagaminti priekabą per 45 kalendorinių dienų po abipusio sutarties patvirtinimo bei
    avanso
    gavimo dienos.
</div>
<div>

    3.2. Užsakovas įsipareigoją vykdyti šioje sutartyje numatytus mokestinius įsipareigojimus.
</div>
<div>
    3.3. Užsakovui pažeidus mokėjimo terminus, Gamintojas turi teisę pareikalauti 0.02% delspinigių nuo nesumokėtos
    sumos už
    kiekvieną uždelstą dieną;
</div>
<div>
    3.4. Gamintojui pažeidus užsakymo gamybos terminus, Užsakovas turi teisę pareikalauti 0.02% delspinigių už kiekvieną
    uždelstą darbo dieną nuo sutarties sumos;
</div>

<div class="strong">
    4. Kitos sąlygos
</div>

<div>
    4.1. Sutarties objektas yra patvirtintas abiejų šalių raštiškų susitarimu pasirašant šią sutartį.
</div>
<div>
    4.2. Visi rašytiniai pranešimai, vienos iš Šalių skirti kitai Šaliai, laikomi atlikti tinkamu būdu, jei buvo
    adresuoti
    šios sutarties 8 straipsnyje nurodytais adresais. Nepranešusi apie adreso pasikeitimą Šalis, atsako už visus su
    nepranešimu susijusius nuostolius.
</div>
<div class="strong">

    5. Sutarties galiojimo, nutraukimo ir papildymo tvarka
</div>
<div>
    5.1. Ši sutartis surašyta dviem vienodą juridinę galią turinčiais egzemplioriais, po vieną kiekvienai šaliai.
</div>

<div>
    5.2. Sutarties sąlygų keitimas atliekamas abiem šalims pasirašant priedus prie sutarties, keičiantį priede numatytus
    šios sutarties punktus.
</div>

<div class="strong">
    6. Nenugalima jėga (Force majeure)
</div>
<div>
    6.1. Šalis atleidžiama nuo atsakomybės už šios sutarties nevykdymą, jeigu ji įrodo, kad Sutartis neįvykdyta dėl
    aplinkybių, kurių ji negalėjo kontroliuoti bei protingai numatyti sutarties sudarymo metu, ir kad negalėjo užkirsti
    kelio šių aplinkybių ar jų pasekmių atsiradimui. Nenugalimos jėgos aplinkybės reglamentuojamos pagal Lietuvos
    Respublikos Civilinį Kodeksą.
</div>

<div>
    7. Baigiamosios nuostatos
</div>

<div>
    7.1. Jei bet kuris kompetetingos jurisdikcijos teismas pripažins kurią nors šios Sutarties nuostatą negaliojančia ar
    neįgivendinama, kitos šios Sutarties nuostatos išliks visiškai galiojančios. Bet kuri šios Sutarties nuostata, kuri
    yra
    pripažinta negaliojančia ar neįgyvendinama tik iš dalies tam tikru laipsniu, išliks galiojanti ta apimtimi, kiek ji
    nėra
    pripažinta negaliojančia ar neįgyvendinama. Tokiu atveju Šalys susitaria, kad minėta nuostata Šalių raštišku
    susitarimu
    turi būti nedelsiant pakeista į naują nuostatą, kuri pagal prasmę ir turinį būtų artimiausia negaliojančiai ar
    neįgivendinamai nuostatai.
</div>

<div>
    7.2. Visi ginčai dėl šios sutarties sprendžiami derybų būdu. Nepavykus išspręsti ginčo derybų būdu, ginčai
    sprendžiami
    Kauno miesto apylinkės teisme (jei ieškinio suma - iki 29 000 €), arba Kauno miesto apygardos teisme (jei ieškinio
    suma - virš 29 000 €) įstatymų numatyta tvarka.
</div>

<div>
    Priedai prie sutarties: <br>
    Komercinis pasiūlymas Nr. B2T-{{ $order->id}}
</div>

<div class="strong">
    8. Šalių juridiniai adresai ir rekvizitai
</div>

<div>
    <table style="">
        <tr>
            <td>
                Užsakovas:
            </td>

            <td>
                Gamintojas:
            </td>
        </tr>

        <tr>
            {{-- TODO: Add customer data --}}
            <td>
                {{ $order->billing_company }} <br>
                {{ $order->billing_first_name }} {{ $order->billing_first_name }}
                <br>
                {{-- TODO: add company address/vat here --}}
                {{ $order->billing_address }}, {{ $order->billing_city }}, {{ $order->billing_country }} <br>
            </td>
            <td>
                {{ get_setting('company_name') }} <br>
                Įm. k. {{ get_setting('company_code') }}, {{ get_setting('company_vat') }} <br>
                {{ get_setting('company_address') }}, {{ get_setting('company_city') }}, {{
                get_setting('company_postal_code') }} <br>
                <br>
                SEB bankas <br>
                El paštas: <br>
                A/s LT66 7044 0600 0785 7947 <br>
                Tel.: <br>
                Mob. tel. 8 (671) 81007 <br>
                El. paštas: eduardas@baltictrailer.eu <br>
                Direktorius <br>
                {{ get_setting('company_ceo_name') }} <br>
                A.V.<br>
            </td>
        </tr>
    </table>
</div>


@endsection
