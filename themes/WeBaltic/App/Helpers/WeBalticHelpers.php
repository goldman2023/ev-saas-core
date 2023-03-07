<?php

use App\Facades\WEF;
use App\Models\OrderItem;
use App\Models\AttributeValue;

function get_attribute_value_wefs_by_attribute($attribute = null) {
    if(empty($attribute)) return [];

    return match ($attribute->slug) {
        // Define wefs for attributes b specifying attribute-slug as key and wanted wefs
        'sertifikato-numeris' => array_intersect_key(WEF::getWEFDataTypes(AttributeValue::class), array_flip(['modifikacija', 'max_grazulo_svoris', 'bendroji_mase'])),
        'kebulo-tipas' => array_intersect_key(WEF::getWEFDataTypes(AttributeValue::class), array_flip(['variantas', 'kebulo_kodas'])),
        // Attribute WEFs are taken from ThemeFunctionServiceProvider of a current theme -> hook is: `add_filter('attribute_values.wef.data-types')`
        default => []
    };
}

function generate_vin_code($item)
{
    // Since each OrderItem has copies of attributes of each linked product or "custom product", we should get the attributes from OrderItem itself - that's the main source of truth

    $order_item = $item->get_primary_order_item()->subject;

    if (empty($order_item)) {
        $order_item = $item->get_primary_order_item();
    }
    if (empty($order_item)) {
        return null;
    }

    $vin_code = 'Z3E';
    $vin_code .= 'L';
    if ($body_type = $order_item?->getAttr('kebulo-tipas')) {
        $body_type = $order_item->getAttr('kebulo-tipas')->attribute_values->first()->values;
    } else {
        $body_type = 'X';
    }

    /* Map body type to 5th VIN Code symbol */
    if (str_contains($body_type, 'DC02')) {
        $vin_code .= 'K';
    }

    if (str_contains($body_type, 'DC01')) {
        $vin_code .= 'P';
    }

    if (str_contains($body_type, 'DC03')) {
        $vin_code .= 'F';
    }

    if (str_contains($body_type, 'DC04')) {
        $vin_code .= 'V';
    }

    if (str_contains($body_type, 'DC99')) {
        $vin_code .= 'S';
    }

    if ($order_item->getAttr('priekabos-bendroji-mase')) {
        $total_weight = $order_item->getAttr('priekabos-bendroji-mase')->attribute_values->first()->values;
    } else {
        $total_weight = 0;
    }


    /* Total Weight */
    if ($total_weight <= 750) {
        $vin_code .= '01';
    } else if ($total_weight <= 3500) {
        $vin_code .= '02';
    } else {
        $vin_code .= '03';
    }

    /* Axel Count */
    if ($order_item->getAttr('asiu-kiekis')) {
        $axel_count = $order_item->getAttr('asiu-kiekis')->attribute_values->first()->values;
    } else {
        $axel_count = 0;
    }

    if ($axel_count == 1) {
        $vin_code .= '1';
    } else if ($axel_count == 2) {
        $vin_code .= '2';
    } else if ($axel_count == 3) {
        $vin_code .= '3';
    }

    /* Controll number placeholder before encoding real value */
    $controll_number = '0';

    $vin_code .= $controll_number;

    /* Production year */
    $year = date('Y');

    if ($year == '2022') {
        $vin_code .= 'N';
    }

    if ($year == '2023') {
        $vin_code .= 'P';
    }

    if ($year == '2024') {
        $vin_code .= 'R';
    }

    if ($year == '2025') {
        $vin_code .= 'S';
    }

    if ($year == '2026') {
        $vin_code .= 'T';
    }

    /* Manufacturing location */
    $manufacturing_location = 'K';

    $vin_code .= $manufacturing_location;

    /* Keliu inspekcijos kodas */
    // $vin_code .= '020';


    /* Serial number */
    $vin_code .= generate_serial_number($order_item, $item);

    if (strlen($vin_code) == 17) {
        $controll_number = vin_control_number($vin_code);
        $vin_code[8] = $controll_number;
    } else {
        return 'Incomplete Data';
    }

    return $vin_code;
}

function vin_control_number($vin)
{
    // Convert VIN to uppercase
    $vin = strtoupper($vin);

    // Define VIN weights
    $weights = array(
        'A' => 1, 'B' => 2, 'C' => 3, 'D' => 4, 'E' => 5, 'F' => 6, 'G' => 7,
        'H' => 8, 'J' => 1, 'K' => 2, 'L' => 3, 'M' => 4, 'N' => 5, 'P' => 7,
        'R' => 9, 'S' => 2, 'T' => 3, 'U' => 4, 'V' => 5, 'W' => 6, 'X' => 7,
        'Y' => 8, 'Z' => 9
    );

    $multiplier = [
        8,
        7,
        6,
        5,
        4,
        3,
        2,
        10,
        'x',
        9,
        8,
        7,
        6,
        5,
        4,
        3,
        2
    ];

    // Initialize control number
    $control_number = 0;

    // Loop through VIN characters
    for ($i = 0; $i < 17; $i++) {
        // Get weight of current character
        $weight = isset($weights[$vin[$i]]) ? $weights[$vin[$i]] : $vin[$i];
        $multiply_result = 0;
        // Multiply weight by character position
        if($multiplier[$i] != 'x') {
            // $weight = $weight * $multiplier[$i];
            $multiply_result = $weight * $multiplier[$i];
            // echo "Doing calculation";
            // var_dump($weight . " * " . $multiplier[$i]);
            // echo "<br>";
        }

        // Add to control number
        // var_dump("Total Weight: " . $weight);
        // var_dump("Multiply result: " . $multiply_result);
        $control_number += $multiply_result;
    }

    // Get remainder of control number divided by 11
    $remainder = $control_number % 11;
    // var_dump("Controll Number" . $remainder);

    // If remainder is 10, return "X" as control number
    if ($remainder == 10) {
        return "X";
    } else {
        return (string) $remainder;
    }
}

function generate_serial_number($order_item, $order)
{
    if (empty($order_item)) {
        $serial_number = 0;
    } else {
        $serial_number = $order->id;
    }

    // dd($order_item);
    // if(empty($order_item)) {
    //     $order_item->
    // }
    $serial_number = sprintf("%06d", $serial_number + 1); // 001234
    $order_item->setWEF('serial_order_number', $serial_number, 'string'); // set WEF

    return $serial_number;
}

function define_livewire_dynamic_actions()
{
    $list = [];

    $list = [
        'regenerate_document' => function (&$form) {
            return lda_regenerate_document($form);
        },
    ];

    return $list;
}

function generate_static_mass_on_decoupling($certificate)
{
    $string = $certificate;

    try {
        if($certificate) {
            $string = explode(')', (explode('(', $string)[1]))[0];
        } else {
            $string = null;
        }
    } catch(\Throwable $e) {
        $string = null;
    }

    return $string;
}

function generate_certificate_number($certificate) {
    try {
        $string = $certificate;
        $string = explode(')', (explode('(', $string)[0]))[0];
    } catch(\Throwable $e) {
        $string = $certificate;
    }

    return $string;
}

function generate_axle_permissable_mass() {

}

function get_customer_visible_documents_tags() {
    return ['proposal', 'contract', 'certificate'];
}

function get_order_cycle_status_color($cycle_status) {
    switch($cycle_status) {
        case 0:
            return 'badge-danger';
        case 1:
            return 'badge-warning';
        case 2:
            return 'badge-info';
        case 10:
            return 'badge-success';
        case 11:
            return 'badge-success';
        default:
            return 'badge-dark';
    }
}
