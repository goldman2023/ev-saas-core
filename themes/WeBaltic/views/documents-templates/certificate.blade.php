@extends('documents-templates.global-pdf-layout.pdf-layout')

@section('content')
<style>
    body {
        font-size: 10px;
        line-height: 10px;
    }
</style>
@php
$product = $order->get_primary_order_item()->subject;

$vehicle_category = "O1";
if($product->getAttrValue('stabdziai') == 'mechanical') {
$vehicle_category = "O2";
}


if ($product->getAttrValue('asiu-kiekis')) {
$axel_count = $product->getAttrValue('asiu-kiekis');
} else {
$axel_count = 0;
}

// $variant = $order->getAttr('variant_custom');
$variant = $order->getWEF('variant_custom', true, 'string');
$version = $order->getWEF('version_custom', true, 'string');
$vehicle_type = "TERO1";
@endphp


<h1 class="text-center text-2xl font-bold w-full">
    {{ translate('CERTIFICATE OF CONFORMITY') }}
</h1>

<p class="text-center text-xl font-medium w-full">
    {{ translate('COMPLETE VEHICLES') }}
</p>
<div style="text-align: left; margin-bottom: 10px;">
<strong>Part 1</strong>
</div>
<p>
    The undersigned: <strong>Director {{ get_setting('company_ceo_name') }}</strong> <br>
    hereby certifies that the vehicle:
</p>
<div>
    0.1. Make: <strong>TERO</strong> <br>
    0.2. Type: <strong>{{ $vehicle_type }}</strong> <br>
    <div style="padding-left: 40px;">
        Variant: S <br>
        Version: - <br>
    </div>
</div>
<div>
    0.2.1 Commercial name(s): <strong>{{ $product->name }}</strong>
</div>
<div>
    0.2.2.1 Allowed Parameter Values for multistage type approval to use the base vehicle emission values
    (insert range where applicable)
</div>
<div style="padding-left: 40px;">
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
    0.4. Vehicle category: <strong> {{ $vehicle_category }} </strong>
</div>
<div>
    0.5. Company name and address of manufacturer: <br>
</div>
<div style="padding-left: 40px;" class="font-bold">
    {{ get_tenant_setting('company_name') }}

    <div>
        {{ get_tenant_setting('company_address') }}
    </div>
    <div>
        {{ get_tenant_setting('company_city') }}, {{ get_tenant_setting('company_country') }}
    </div>
</div>

<div>
    0.6. Location and method of attachment of the statutory plates:
    <strong>identification plate is placed bellow the engraved VIN</strong>
    <div style="padding-left: 40px;">
    Location of the vehicle identification number: <strong>on vertical part of the drawbar</strong>
    </div>
</div>
<div>
    0.9. Name and address of the manufacturer's representative (if any)
</div>
<div>
    0.10. Vehicle identification number: <strong>{{ generate_vin_code($order) }} </strong>
</div>
<div class="margin-bottom: 20px;">
    0.11. Date of manufacture of the vehicle:
    <strong>
    @if($order->getWEF('cycle_step_date_manufacturing'))
        {{ $order->getWEF('cycle_step_date_manufacturing') }}
    @else
        {{ translate('Date pending') }}
    @endif
    </strong>
    <br>
    {{-- TODO: add manufacturing date, based on order delivery date. --}}
    conforms in all respects to the type described in approval
    <strong>
        @if($product->getAttrValue('sertifikato-numeris'))
            {{ $product->getAttrValue('sertifikato-numeris') }}
        @else
            <span class="text-red-500">Missing</span>
        @endif
    </strong>
    <br>
    <div>
        granted on: <strong>{{ $order->created_at }}</strong>
    </div>
    and can be permanently registered in Member States having right/ left hand traffic and using metric/
    imperial
    units for the
    speedometer and metric/imperial units for the odometer (if applicable)
</div>
<table style="width: 100%; margin-top: 40px;">
    <tr>
        <td style="width: 25%;">
            <div style="padding-top: 5px; border-top: 1px dotted black">
                <strong>(Date/ Data)</strong>
            </div>
        </td>
        <td style="width: 25%;">
        </td>
        <td style="width: 25%;">
            <div style="padding-top: 5px; border-top: 1px dotted black">
                <strong>(Signature)</strong>
            </div>
        </td>
        <td style="width: 25%;">
        </td>
    </tr>
</table>
<div class="page-break"></div>
<div style="width: 100%;">
<table style="width: 100%; margin-bottom 20px;">
    <tr>
        <td style="width: 33%;">
            <strong>Part 2</strong>
        </td>
        <td style="width: 33%;">
            <h3 class="text-center">VEHICLE CATEGORIES {{ $vehicle_category }}</h3>
        </td>
        <td style="width: 33%;">
        </td>
    </tr>
</table>
</div>
<div>
    <strong>
        General construction characteristics
    </strong>
</div>
<div>
    1. Number of axles: <strong>{{ $axel_count }}</strong> and wheels: <strong>{{ $axel_count * 2 }}</strong>
</div>
<div>
    1.1. Number and position of axles with twin wheels: N/A
</div>
<div style="margin-top: 5px;">
    <strong>Main dimensions</strong>
</div>
<div>
    4. Wheelbase: <strong>{{ $product->getAttrValue('wheelbase') }} mm </strong>
</div>
<div>
    4.1. Axle spacing:
    {{-- TODO: clarify this --}}
    <strong>0-1: 2200 mm, {{ ($product->getAttrValue('kraunamo-pavirsiaus-ilgis') / 2) - 350 }}</strong>
</div>
<div>
    5. Length: <strong>{{ $product->getAttrValue('kraunamo-pavirsiaus-ilgis') }} mm </strong>
</div>

<div>
    6. Width: <strong>{{ $product->getAttrValue('kraunamo-pavirsiaus-plotis') }} mm </strong>
</div>
<div>
    7. Height: <strong>{{ $product->getAttrValue('bendras-aukstis') }} mm </strong>
</div>
<div>
    10. Distance between the centre of the coupling device and the rear end of the vehicle :
    {{-- TODO: How to calculate this --}}
    <strong>4300 mm</strong>
</div>
<div>
    11. Length of the loading area: <strong>{{ $product->getAttrValue('kraunamo-pavirsiaus-ilgis') }} mm </strong>
</div>
<div>
    12. Rear overhang: <strong>{{ $product->getAttrValue('rear-overhang') }} mm </strong>
</div>
<div style="margin-top: 5px;">
    <strong>Masses</strong>
</div>
<div>
    13. Mass in running order: <strong>{{ $product->getAttrValue('priekabos-bendroji-mase') }} kg</strong>
</div>

<div>
    13.1. Distribution of this mass amongst the axles:
</div>
<div style="padding-left: 40px; font-weight: 700;">

    @php
    if ($product->getAttrValue('priekabos-bendroji-mase')) {
    $lifting_mass = $product->getAttrValue('priekabos-bendroji-mase');
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
    {{-- TODO: add all this for other parts, make sure padding is constent --}}
    <div style="padding-left: 40px;">
       <strong> {{ $product->getAttrValue('bendra-krova') }} kg </strong>
    </div>
</div>

<div>
    16.2. Technically permissible mass on each axle:
    <div style="font-weight: 700; padding-left: 40px;">
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
</div>

<div>
    16.3. Technically permissible mass on each axle group: <strong>... kg</strong>
</div>

<div>
    17. Intended registration/in service maximum permissible masses in national/international traffic
</div>

<div>
    17.1. Intended registration/in service maximum permissible laden mass:
    <strong>{{ $product->getAttrValue('bendra-krova') }} kg </strong>
</div>

<div>
    17.2. Intended registration/in service maximum permissible laden mass on each axle:
</div>
<div style="font-weight: 700; padding-left: 40px;">
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

<div style="font-weight: 700; padding-left: 40px;">
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
    19. Technically permissible maximum static mass on the coupling point of a semi-trailer or centre-axle trailer :
    <div style="padding-left: 40px;">
        <strong>75 kg</strong>
    </div>
</div>
<div style="margin-top: 5px;">
    <strong>Maximum speed</strong>
</div>
<div>
    29. Maximum speed: <strong>{{ $product->getAttrValue('maksimalus-greitis') }} km/h </strong>
</div>
<div style="margin-top: 5px;">
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
    33. Drive axle(s) fitted with air suspension or equivalent: <strong>no</strong>
</div>
<div>
    35. Tyre/wheel combination(h) : <strong>{{ $product->getAttrValue('padangos') }}</strong>
</div>
<div style="margin-top: 5px;">
    <strong>Brakes</strong>
</div>
<div>
    36. Trailer brake connections: <strong>{{ $product->getAttrValue('stabdziai') }}</strong>

</div>
<div style="margin-top: 5px;">
    <strong>
        Bodywork
    </strong>
</div>
<div>
    38. Code for bodywork: {{ $product->getAttrValue('kebulo-tipas') }}
</div>
<div style="margin-top: 5px;">
    <strong>
        Coupling device
    </strong>
</div>
<div>
    {{-- TODO: Select coupling device --}}
    44. Number of the approval certificate or approval mark of coupling device (if fitted):
    {{-- TODO: what is this? --}}
    <strong>{{ $product->getAttrValue('coupling-device') }}</strong>
</div>
<div>
    45.1. Characteristics values:
    <div style="padding-left: 40px; font-weight: 700;">
    D: 7.19 kN, V: - S: 75 kg, U: -
    </div>
</div>
<div style="margin-top: 5px;">
    <strong>
        Miscellaneous
    </strong>
</div>
<div>
    50. Type-approved in accordance with the design requirements for transporting dangerous goods of UN
    Regulation No 105 of the Economic Commission for Europe of the United Nations:
    <strong>no</strong>
</div>

<div>
    51. For special purpose vehicles: designation in accordance with point 5 of Part A of Annex I to
    Regulation (EU) 2018/858
    of the European Parliament and of the Council: N/A
</div>
<div>
    52. Remarks: {{ $order->getWEF('certificate_remarks') }}
</div>
<div style="position: absolute; bottom: 0px; right: 0px; width: 50px;">
    <img src="data:image/svg+xml;base64, {!! base64_encode(QrCode::size(100)->generate($order->getPermalink())) !!}" />
</div>

@endsection
