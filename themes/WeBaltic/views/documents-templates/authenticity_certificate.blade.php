@extends('documents-templates.global-pdf-layout.pdf-layout')

@section('content')
<div class="center">
    UAB “DOMANTAS”
</div>
<div>
    (įmonės, įstaigos pavadinimas)
</div>

<div class="center">
    302635282, Dvarkiemio g-vė 1, Domeikava, Kauno r.
</div>
<div class="small-underline">
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
    Nr. 4143
</div>

<div class="table">
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
            </td>
            <td>
            </td>
            <td>
            </td>
        </tr>
    </table>
</div>





Gamybinė markė (gamintojo prekės pavadinimas)
0.1
TERO
D.1
Tipas/Variantas/Versija
0.2
TERO1 / S / ---
D.2
Komercinis pavadinimas
0.2.1
Spec
D.3
Transporto priemonės identifikavimo numeris
0.10
Z3ELS011XNK000223
E
Tipo patvirtinimo numeris


e9*2018/858*11399*00
K
Tipo patvirtinimo numerio suteikimo data


2022-11-02


Nacionalinis tipo patvirtinimo numeris


--
K.1
Transporto priemonės spalva
40
Pilka
R







Patvirtinu, kad transporto priemonės identifikavimo žymenys atitinka Komisijos reglamento (ES) Nr. 19/2011 dėl
variklinių transporto priemonių ir jų priekabų tipo patvirtinimo, atsižvelgiant į gamintojo identifikavimo plokštelę ir
transporto priemonės identifikavimo numerį reikalavimų, kuriuo įgyvendinamas Europos Parlamento ir Tarybos reglamentas
(EB) Nr. 661/2009 dėl variklinių transporto priemonių, jų priekabų ir joms skirtų sistemų, sudėtinių dalių bei atskirų
techninių mazgų tipo patvirtinimo, atsižvelgiant į jų bendrąją saugą, reikalavimus, o jų išsidėstymo vietos atitinka
nurodytus transporto priemonės atitikties liudijime.










(parašas)


(pareigos, vardas, pavardė)




A.V.
@endsection
