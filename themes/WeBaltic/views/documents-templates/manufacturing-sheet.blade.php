@extends('documents-templates.global-pdf-layout.pdf-layout-no-logo')
@section('content')

@php
$product = $order->get_primary_order_item()->subject;

if(empty($product)) {
    $product = $order->get_primary_order_item();
}


if ($product->getAttr('asiu-kiekis')) {
    $axel_count = $product->getAttr('asiu-kiekis')->attribute_values->first()->values;
} else {
    $axel_count = 0;
}

$vehicle_category = "O1";
if($product->getAttrValue('stabdziai') == 'mechanical') {
    $vehicle_category = "O2";
}
@endphp
<style>
    table {
        border-collapse: collapse;
        width: 100%;
        text-align: left;
        table-layout: fixed;
    }

    td {
        /* width: 25%; */
    }

    th,
    td {
        border: 1px solid;
        padding: 5px;
    }
</style>
<table>
    <thead>
        <tr>
            <th colspan="8">
                {{ translate('Assembly Sheet') }}
            </th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td colspan="2">{{ translate('Order no:') }}</td>
            <td colspan="2">{{ $order->id }}</td>
            <td colspan="2">{{ translate('Commercial offer no:') }}</td>
            <td colspan="2">{{ $order->id }}</td>
        </tr>
        <tr>
            <td colspan="2">{{ translate('Date of assembly start') }}</td>
            <td colspan="2">
                {{ $order->getWEF('cycle_step_date_assembly') }}
            </td>
            <td colspan="4"></td>
        </tr>
        <tr>
            <td colspan="2">Assembled:</td>
            <td colspan="2"> </td>
            <td>Assembler:</td>
            <td colspan="3">{{ $order->getWEF('assembler') }}</td>
        </tr>
        <tr>
            <td colspan="2">Inspected:</td>

            <td>Inspector:</td>
            <td colspan="5">{{ $order->getWEF('inspected_by') }}</td>
        </tr>
        <tr>
            <td colspan="8"><strong>{{ translate('Technical characteristics of trailer') }}:</strong></td>
        </tr>
        <tr>
            <td colspan="2">Trailer Category:</td>
            <td colspan="2">{{ $vehicle_category }}</td>
            <td rowspan="2" colspan="2">{{ translate('Number of axles') }}:</td>
            <td colspan="2">O - {{ $axel_count }} axle</td>
        </tr>
        <tr>
            <td colspan="2">{{ translate('Length') }}:</td>
            <td colspan="2">{{ $product->getAttrValue('kraunamo-pavirsiaus-ilgis') }} mm</td>
            <td colspan="2"></td>
        </tr>
        <tr>
            <td colspan="2">{{ translate('Width') }}:</td>
            <td colspan="2">{{ $product->getAttrValue('kraunamo-pavirsiaus-plotis') }} mm</td>
            <td colspan="2"></td>
            <td colspan="2"></td>
        </tr>
        <tr>
            <td colspan="2">Model:</td>
            <td colspan="2"></td>
            <td colspan="2">Chasis type:</td>
            <td colspan="2">{{ $product->getAttrValue('pakaba') }}</td>
        </tr>
        <tr>
            <td colspan="2">Lights:</td>
            <td colspan="2">O - Multipoint 2</td>
            <td colspan="2">Axle make:</td>
            <td colspan="2"></td>
        </tr>
        <tr>
            <td colspan="2">Coupling:</td>
            <td>{{ $product->getAttrValue('coupling-device') }}</td>
            <td>O - 750 kg</td>
            <td colspan="2">Axle model:</td>
            <td colspan="2"></td>
        </tr>
        <tr>
            <td rowspan="2" colspan="2"> {{ $product->getAttrValue('coupling-device') }} </td>
            <td></td>
            <td>O - 750 kg</td>
            <td rowspan="2" colspan="2">Wheels:</td>
            <td rowspan="2" colspan="2">{{ $product->getAttrValue('padangos') }} </td>
        </tr>
        <tr>
            <td>KNOTT</td>
            <td>O - 750 kg</td>
        </tr>
        <tr>
            <td colspan="8">Comments: <br>
                {{ $order->getWEF('inspected_by') }}
            </td>
        </tr>
    </tbody>
</table>
@endsection
