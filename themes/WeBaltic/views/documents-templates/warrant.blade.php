@extends('documents-templates.global-pdf-layout.pdf-layout')

@section('content')
<div>
    VĮ Regitrai,
</div>
<div class="center strong">
    Įgaliojimas
</div>
<div class="center">
    {{ date('Y' )}} m. _______________ d.
</div>
<div class="center">
    Kaunas,
</div>

<div class="center" style="">
    {{ get_setting('company_name') }}, įmonės kodas {{ get_setting('company_code') }}, registruota adresu {{ get_setting('company_address') }}, {{ get_setting('company_city') }}
    atstovaujama direktoriaus {{ get_setting('company_ceo_name') }}, įgalioja
</div>


<div class="table" style="width: 100%; margin-top: 40px; margin-bottom: 50px;">
    <table>
        {{-- Table Header --}}
        <tr>
            <th>
               Pareigos, Vardas Pavardė
            </th>
            <th>
                Asmens kodas
            </th>
            <th>
                Parašo pavyzdys
            </th>

        </tr>
        {{-- Data --}}
        <tr>
            <td style="padding: 20px;">
            </td>
            <td style="padding: 20px;">
            </td>
            <td style="padding: 20px;">
            </td>

        </tr>

        <tr>
            <td style="padding: 20px;">
            </td>
            <td style="padding: 20px;">
            </td>
            <td style="padding: 20px;">
            </td>
        </tr>
    </table>
</div>

<div>
    Pateikti perleidomo deklaraciją priekabai/oms kurių VIN numeris/iai yra
</div>
<div style="margin-bottom: 30px; border-bottom: 1px solid black;">
    {{ generate_vin_code($order) }}
</div>

<div>
    Įgaliojimas galioja iki: {{ $order->created_at }}
</div>

<div style="margin-top: 40px;">
(parašas)


(pareigos, vardas, pavardė)




A.V.
</div>
@endsection
