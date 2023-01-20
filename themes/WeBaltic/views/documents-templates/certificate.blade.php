@extends('documents-templates.global-pdf-layout.pdf-layout')

@section('content')
<style>
    body {
        font-size: 12px;
    }
</style>
@php
$product = $order->get_primary_order_item()->subject;

$vehicle_category = "O1";
if($product->getAttrValue('stabdziai') == 'mechanical') {
$vehicle_category = "O2";
}


if ($product->getAttr('asiu-kiekis')) {
$axel_count = $product->getAttr('asiu-kiekis')->attribute_values->first()->values;
} else {
$axel_count = 0;
}
@endphp

<div class="logo">
    <img src="{{ get_site_logo() }}" style="width: 100px; " />
</div>
<h1 class="text-center text-2xl font-bold w-full">
    CERTIFICATE OF CONFORMITY
</h1>

<p class="text-center text-xl font-medium w-full">
    COMPLETE VEHICLES
</p>

<strong>Part 1</strong>
<p>
    The undersigned: <strong>Director Eduard Terechov</strong> <br>
    hereby certifies that the vehicle:
</p>

0.1. Make: <strong>TERO</strong> <br>
0.2. Type: <strong>TERO1</strong> <br>
Variant: S <br>
Version: - <br>
<div>
0.2.1 Commercial name(s): Spec
</div>
<div>
0.2.2.1 Allowed Parameter Values for multistage type approval to use the base vehicle emission values
(insert range where applicable)
</div>
<div>
Final Vehicle actual mass: <strong>{{ $product->getAttrValue('priekabos-nuosava-mase') }} kg </strong>
</div>
<div>
    Final Vehicle technically permissible maximum laden mass (in kg):
    <strong>{{ $product->getAttrValue('priekabos-bendroji-mase') }} kg </strong>
</div>
<div>
    Frontal area for final vehicle (in cm2): <strong> N/A </strong>
</div>
<div>
    Rolling resistance (kg/t): <strong>N/A</strong>

</div>

<div>
    Cross-sectional area of air entrance of the front grille (in cm2): <strong>N/A</strong>

</div>
<div>
    0.2.3. Identifiers: <strong>N/A </strong>
</div>
<div>
    0.2.3.1. Interpolation family’s identifier: <strong>N/A</strong>
</div>
<div>
    0.2.3.2. ATCT family’s identifier: <strong>N/A</strong>
</div>
<div>
    0.2.3.3. PEMS family’s identifier : <strong>N/A</strong>
</div>
<div>
    0.2.3.4. Roadload family’s identifier: <strong>N/A</strong>
</div>
<div>
    0.2.3.5. Roadload Matrix family’s identifier (if applicable): <strong>N/A</strong>
</div>
<div>
    0.2.3.6. Periodic regeneration family’s identifier: <strong>N/A </strong>
</div>

<div>
    0.2.3.7. Evaporative test family’s identifier: <strong>N/A </strong>
</div>
<div>
    {{-- If product has brakes, category is O2 --}}
    0.4.  Vehicle category: <strong> {{ $vehicle_category }} </strong>
</div>
<div>
    0.5.  Company name and address of manufacturer: <br>
</div>
<div style="padding-left: 40px;" class="font-bold">
    {{ get_tenant_setting('company_name') }}

    <div>
        {{ get_tenant_setting('company_address') }}
    </div>
    <div>
        {{ get_tenant_setting('company_city') }},   {{ get_tenant_setting('company_country') }}
    </div>
</div>

<div>
    0.6. Location and method of attachment of the statutory plates: <strong>identification plate is placed bellow
        the</strong>
    <br>
    engraved VIN Location of the vehicle identification number: <strong>on vertical part of the drawbar</strong>
</div>
<div>
    0.9. Name and address of the manufacturer&#39;s representative (if any)
</div>
<div>
    0.10.  Vehicle identification number: <strong>{{ generate_vin_code($order) }} </strong>
</div>
<div>
    0.11.  Date of manufacture of the vehicle:
    conforms in all respects to the type described in approval
    <strong>
        @if($product->getAttrValue('sertifikato-numeris'))
        {{ $product->getAttrValue('sertifikato-numeris') }}
        @else
        <span class="text-red-500">Missing</span>
        @endif
    </strong>
    <div>
    granted on: <strong>{{ $order->created_at }}</strong>
    </div>
    and can be permanently registered in Member States having right/ left hand traffic and using metric/
    imperial
    units for the
    speedometer and metric/imperial units for the odometer (if applicable)
</div>

<div class="page-break"></div>
<strong>Part 2</strong>

<h3 class="text-center">VEHICLE CATEGORIES {{ $vehicle_category }}</h3>


<p>
    <div>
        <strong>
            General construction characteristics
        </strong>
    </div>
    <div>
    1. Number of axles: 1 and wheels: 2
    </div>
    <div>
    1.1. Number and position of axles with twin wheels: N/A
    </div>
<div>
    <strong>Main dimensions</strong>
</div>
<div>
    4. Wheelbase: <strong>{{ $product->getAttrValue('wheelbase') }} mm </strong>
</div>
<div>
    4.1. Axle spacing: 0-1: 2200 mm, {{ ($product->getAttrValue('kraunamo-pavirsiaus-ilgis') / 2) - 350 }}
</div>
<div>
    5. Length: <strong>{{ $product->getAttrValue('kraunamo-pavirsiaus-ilgis') }} mm </strong>
</div>

<div>
    6. Width: <strong>{{ $product->getAttrValue('kraunamo-pavirsiaus-plotis') }} mm </strong>
</div>
<div>
    7. Height: 540 mm
</div>
<div>
    10. Distance between the centre of the coupling device and the rear end of the vehicle : 4300 mm
</div>
<div>
    11. Length of the loading area: 3000 mm
</div>
<div>
    12. Rear overhang: <strong>{{ $product->getAttrValue('rear-overhang') }} mm </strong>
</div>
<div>
    <strong>Masses</strong>
</div>

<div>
    13. Mass in running order: <strong>{{ $product->getAttrValue('priekabos-bendroji-mase') }} kg</strong>
</div>

<div>
    13.1. Distribution of this mass amongst the axles:
</div>
<div style="font-weight: 700;">

    @php
    if ($product->getAttr('priekabos-bendroji-mase')) {
    $lifting_mass = $product->getAttr('priekabos-bendroji-mase')->attribute_values->first()->values;
    } else {
    $lifting_mass = 0;
    }
    @endphp

    @if($axel_count == 1)
    1: {{ $lifting_mass }} kg, 2: - kg, 3: - kg
    @endif

    @if($axel_count == 2)
    1: {{ $lifting_mass/2 }} kg, 2: {{ $lifting_mass/2 }} kg, 3: - kg
    @endif

    @if($axel_count == 3)
    1: {{ $lifting_mass/3 }} kg, 2: {{ $lifting_mass/3 }} kg, 3: {{ $lifting_mass/3 }} kg
    @endif

</div>

<div>
    13.2. Actual mass of the vehicle: <strong>{{ $product->getAttrValue('priekabos-bendroji-mase') }} kg </strong>
</div>

<div>
    16. Technically permissible maximum masses:
</div>

<div>
    16.1. Technically perm. maximum laden mass:
    {{ $product->getAttrValue('bendra-krova') }} kg
</div>

<div>
    16.2. Technically permissible mass on each axle:
    <span style="font-weight: 700;">
        @if($axel_count == 1)
        1: {{ $lifting_mass }} kg, 2: - kg, 3: - kg
        @endif

        @if($axel_count == 2)
        1: {{ $lifting_mass/2 }} kg, 2: {{ $lifting_mass/2 }} kg, 3: - kg
        @endif

        @if($axel_count == 3)
        1: {{ $lifting_mass/3 }} kg, 2: {{ $lifting_mass/3 }} kg, 3: {{ $lifting_mass/3 }} kg
        @endif
    </span>
</div>

<div>
    16.3. Technically permissible mass on each axle group: ..... kg
</div>

<div>
    17. Intended registration/in service maximum permissible masses in national/international traffic
</div>

<div>
    17.1. Intended registration/in service maximum permissible laden mass: <strong>{{
        $product->getAttrValue('bendra-krova') }} kg </strong>
</div>

<div>
    17.2. Intended registration/in service maximum permissible laden mass on each axle:
</div>
<div style="font-weight: 700;">
    @if($axel_count == 1)
    1: {{ $lifting_mass }} kg, 2: - kg, 3: - kg
    @endif

    @if($axel_count == 2)
    1: {{ $lifting_mass/2 }} kg, 2: {{ $lifting_mass/2 }} kg, 3: - kg
    @endif

    @if($axel_count == 3)
    1: {{ $lifting_mass/3 }} kg, 2: {{ $lifting_mass/3 }} kg, 3: {{ $lifting_mass/3 }} kg
    @endif
</div>
<div>
    17.3. Intended registration/in service maximum permissible laden mass on each axle group:
</div>

<div style="font-weight: 700;">
    @if($axel_count == 1)
    1: {{ $lifting_mass }} kg, 2: - kg, 3: - kg
    @endif

    @if($axel_count == 2)
    1: {{ $lifting_mass/2 }} kg, 2: {{ $lifting_mass/2 }} kg, 3: - kg
    @endif

    @if($axel_count == 3)
    1: {{ $lifting_mass/3 }} kg, 2: {{ $lifting_mass/3 }} kg, 3: {{ $lifting_mass/3 }} kg
    @endif
</div>
<div>
    19. Technically permissible maximum static mass on the coupling point of a semi-trailer or centre-axle
    trailer :
    . 75 kg
</div>
<div>
    <strong>Maximum speed</strong>
</div>
<div>
    29. Maximum speed: <strong>{{ $product->getAttrValue('maksimalus-greitis') }} km/h </strong>
</div>
<div>
    <strong>
        Axles and suspension
    </strong>
</div>
<div>
    30.1. Track of each steered axle: <strong>N/A</strong>
</div>
<div>
    30.2. Track of all other axles: <strong>N/A</strong>
</div>
<div>
    31. Position of lift axle(s): <strong>N/A</strong>
</div>
<div>
    32. Position of loadable axle(s): <strong>N/A</strong>
</div>
<div>
    33. Drive axle(s) fitted with air suspension or equivalent: no
</div>
<div>
    35. Tyre/wheel combination(h) : <strong>{{ $product->getAttrValue('padangos') }}</strong>
</div>
<div>
    <strong>Brakes</strong>
</div>
<div>
    36. Trailer brake connections: <strong>{{ $product->getAttrValue('stabdziai') }}</strong>

</div>
<div>
    <strong>
        Bodywork
    </strong>
</div>
<div>
    38. Code for bodywork: {{ $product->getAttrValue('kebulo-tipas') }}
</div>
<div>
    <strong>
        {{ translate('Coupling device') }}
    </strong>
</div>
<div>
    44. Number of the approval certificate or approval mark of coupling device (if fitted): E4 55R-01 0232
</div>
<div>
    45.1. Characteristics values:

    D: 7.19 kN, V: - S: 75 kg, U: -
</div>
<div>
    <strong>
        {{ translate('Miscellaneous') }}
    </strong>
</div>
<div>
    50. Type-approved in accordance with the design requirements for transporting dangerous goods of UN
    Regulation No 105
    of the Economic Commission for Europe of the United Nations:
    yes/class(es): .... no
</div>

<div>
    51. For special purpose vehicles: designation in accordance with point 5 of Part A of Annex I to
    Regulation (EU) 2018/858
    of the European Parliament and of the Council: N/A
</div>
<div>
    52. Remarks: ....
</div>
<div style="position: absolute; bottom: 20px; right: 20px;">
    <img src="data:image/svg+xml;base64, {!! base64_encode(QrCode::size(100)->generate($order->getPermalink())) !!}" />
</div>

@endsection
