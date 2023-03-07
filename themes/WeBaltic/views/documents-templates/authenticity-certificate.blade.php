@extends('documents-templates.global-pdf-layout.pdf-layout')

@section('content')
<div class="center strong">
    {{ get_setting('company_name') }}
</div>
<div class="center">
    (įmonės, įstaigos pavadinimas)
</div>

<div class="center" style="border-bottom: 1px solid black;">
    {{ get_setting('company_code') }}, {{ get_setting('company_address') }}, {{ get_setting('company_city') }}, {{ get_setting('company_postal_code') }}
</div>
<div class="small-underline center">
    (įmonės kodas, adresas)
</div>
<div class="center h1">
    <h1>
        PAŽYMA
        APIE TRANSPORTO PRIEMONĖS TAPATUMO DUOMENIS
    </h1>
    (M, N ir O kategorijų transporto priemonei)
</div>
<div class="date">
    {{ $order->updated_at }}
</div>
<div>
    (data)
</div>

<div class="strong center">
    Nr. {{ $order->id }}
</div>

<div class="table" style="margin-bottom: 50px;">
    <table>
        {{-- Table Header --}}
        <tr>
            <th>
                Transporto priemonės duomenys:
            </th>
            <th>
                Skirsnis atitikties liudijime
            </th>
            <th>
            </th>
            <th>
                Skiltis RL
            </th>
        </tr>
        {{-- Data --}}
        <tr>
            <td>
                Gamybinė markė (gamintojo prekės pavadinimas)
            </td>
            <td>
                0.1
            </td>
            <td>
                TERO
            </td>
            <td>
                D.1
            </td>
        </tr>

        <tr>
            <td>
                Tipas/Variantas/Versija
            </td>
            <td>
                0.2
            </td>
            <td>
                {{-- TODO - Calculate this? --}}
                TERO1 / S / ---
            </td>
            <td>
                D.2
            </td>
        </tr>

        <tr>
            <td>
                Komercinis pavadinimas
            </td>
            <td>
                0.2.1
            </td>
            <td>
                {{-- TODO - Calculate this? --}}
                Spec
            </td>
            <td>
                D.3
            </td>
        </tr>

        <tr>
            <td>
                Transporto priemonės identifikavimo numeris
            </td>
            <td>
                0.10
            </td>
            <td>
                {{ generate_vin_code($order) }}
            </td>
            <td>
                E
            </td>
        </tr>

        <tr>
            <td>
                Tipo patvirtinimo numeris
            </td>
            <td>

            </td>
            <td>
                {{-- TODO: Show certificate number --}}
                {{ generate_vin_code($order) }}
            </td>
            <td>
                K
            </td>
        </tr>

        <tr>
            <td>
                Tipo patvirtinimo numerio suteikimo data
            </td>
            <td>

            </td>
            <td>
                {{-- TODO: Show certificate number --}}
                2022-11-02
            </td>
            <td>

            </td>
        </tr>

        <tr>
            <td>
                Nacionalinis tipo patvirtinimo numeris
            </td>
            <td>

            </td>
            <td>
                --
            </td>
            <td>
                K.1
            </td>
        </tr>

        <tr>
            <td>
                Transporto priemonės spalva
            </td>
            <td>

            </td>
            <td>
               Pilka
            </td>
            <td>
                R
            </td>
        </tr>
    </table>
</div>
<div style="margin-bottom: 30px; border-top: 1px solid black;">
<strong>
Patvirtinu, kad transporto priemonės identifikavimo žymenys atitinka Komisijos reglamento (ES) Nr. 19/2011 dėl
variklinių transporto priemonių ir jų priekabų tipo patvirtinimo, atsižvelgiant į gamintojo identifikavimo plokštelę ir
transporto priemonės identifikavimo numerį reikalavimų, kuriuo įgyvendinamas Europos Parlamento ir Tarybos reglamentas
(EB) Nr. 661/2009 dėl variklinių transporto priemonių, jų priekabų ir joms skirtų sistemų, sudėtinių dalių bei atskirų
techninių mazgų tipo patvirtinimo, atsižvelgiant į jų bendrąją saugą, reikalavimus, o jų išsidėstymo vietos atitinka
nurodytus transporto priemonės atitikties liudijime.

</strong>
</div>

(parašas)


(pareigos, vardas, pavardė)




A.V.
@endsection
