@extends('documents-templates.global-pdf-layout.pdf-layout')

@section('content')


<div class="watermark">
</div>
<div class="logo">
    <img src="{{ get_site_logo() }}" style="width: 100px; " />
</div>
<h1 style="width:100%; text-align: center">
    CERTIFICATE OF CONFORMITY
</h1>

<p style="text-align: center;">
    COMPLETE VEHICLES
</p>

<strong>Part 1</strong>
<p>
    The undersigned: Director Eduard Terechov
    hereby certifies that the vehicle:
</p>

0.1. Make: TERO <br>
0.2. Type: TERO1 <br>
Variant: S <br>
Version: - <br>
0.2.1 Commercial name(s): Spec
0.2.2.1 Allowed Parameter Values for multistage type approval to use the base vehicle emission values
(insert range where applicable)
Final Vehicle actual mass: 410 kg
Final Vehicle technically permissible maximum laden mass (in kg): 750 kg
Frontal area for final vehicle (in cm2): N/A
Rolling resistance (kg/t): N/A
Cross-sectional area of air entrance of the front grille (in cm2): N/A
0.2.3. Identifiers: N/A
0.2.3.1. Interpolation family’s identifier: N/A
0.2.3.2. ATCT family’s identifier: N/A
0.2.3.3. PEMS family’s identifier : N/A
0.2.3.4. Roadload family’s identifier: N/A
0.2.3.5. Roadload Matrix family’s identifier (if applicable): N/A
0.2.3.6. Periodic regeneration family’s identifier: N/A
0.2.3.7. Evaporative test family’s identifier
0.4.  Vehicle category: O1
0.5.  Company name and address of manufacturer: <br>
<div style="padding-left: 40px;">
    {{ get_tenant_setting('company_name') }}

    <div>
        {{ get_tenant_setting('company_address') }}
    </div>
    <div>
        {{ get_tenant_setting('company_city') }}
    </div>
</div>
0.6. Location and method of attachment of the statutory plates: identification plate is placed bellow the
engraved VIN
Location of the vehicle identification number: on vertical part of the drawbar
0.9. Name and address of the manufacturer&#39;s representative (if any)
0.10.  Vehicle identification number: Z3ELS011XNK000114
0.11.  Date of manufacture of the vehicle:
conforms in all respects to the type described in approval e9*2018/858*11399*00
granted on: 02.11.2022
and can be permanently registered in Member States having right/ left hand traffic and using metric/
imperial
units for the
speedometer and metric/imperial units for the odometer (if applicable)
<div class="page-break"></div>
<strong>Part 2</strong>

<h3 class="text-center">VEHICLE CATEGORIES O1</h3>
<div class="watermark">
</div>

<p>
    General construction characteristics
    1. Number of axles: 1 and wheels: 2
    1.1. Number and position of axles with twin wheels: N/A
<div>
    <strong>Main dimensions</strong>
</div>
4. Wheelbase: 1780 mm
4.1. Axle spacing: 0-1: 2200 mm,
5. Length: 3000 mm
6. Width: 2540 mm
7. Height: 540 mm
10. Distance between the centre of the coupling device and the rear end of the vehicle : 4300 mm
11. Length of the loading area: 3000 mm
12. Rear overhang: 1000 mm
<div>
    <strong>Masses</strong>
</div>
13. Mass in running order: 410 kg
13.1. Distribution of this mass amongst the axles:
1: 400 kg, 2: - kg, 3: - kg
13.2. Actual mass of the vehicle: ...kg
16. Technically permissible maximum masses:
16.1. Technically perm. maximum laden mass:
750 kg
16.2. Technically permissible mass on each axle:
1: 750 kg, 2: .....kg, 3: ....kg
16.3. Technically permissible mass on each axle group: ..... kg
17. Intended registration/in service maximum permissible masses in national/international traffic
17.1. Intended registration/in service maximum permissible laden mass: 750 kg
17.2. Intended registration/in service maximum permissible laden mass on each axle:

1: 750 kg, 2: - kg, 3: - kg

17.3. Intended registration/in service maximum permissible laden mass on each axle group:

1: 750kg, 2: - kg, 3: - kg

19. Technically permissible maximum static mass on the coupling point of a semi-trailer or centre-axle
tràiler :
. 75 kg
<div>
    <strong>Maximum speed</strong>
</div>
29. Maximum speed: 140 km/h
Axles and suspension
30.1. Track of each steered axle: N/A
30.2. Track of all other axles: N/A
31. Position of lift axle(s): N/A
32. Position of loadable axle(s): N/A
33. Drive axle(s) fitted with air suspension or equivalent: yes/no
35. Tyre/wheel combination(h) : 155R13
<div>
    <strong>Brakes</strong>
</div>
36. Trailer brake connections mechanical/electric/pneumatic/hydraulic /
Bodywork
38. Code for bodywork: DC99

<div>
    <strong>
        {{ translate('Coupling device') }}
    </strong>
</div>

44. Number of the approval certificate or approval mark of coupling device (if fitted): E4 55R-01 0232
45.1. Characteristics values:

D: 7.19 kN, V: - S: 75 kg, U: -
<div>
    <strong>
        {{ translate('Miscellaneous') }}
    </strong>
</div>

50. Type-approved in accordance with the design requirements for transporting dangerous goods of UN
Regulation No 105
of the Economic Commission for Europe of the United Nations:
yes/class(es): .... no

51. For special purpose vehicles: designation in accordance with point 5 of Part A of Annex I to
Regulation (EU) 2018/858
of the European Parliament and of the Council: N/A
52. Remarks: ....
</p>

@endsection
