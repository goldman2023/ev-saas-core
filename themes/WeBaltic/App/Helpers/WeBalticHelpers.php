<?php

function generate_vin_code($item)
{
    $vin_code = 'Z39';
    $vin_code .= 'L';
    if($body_type = $item->getAttr(25)) {
        $body_type = $item->getAttr(25)->attribute_values->first()->values;

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

    if($item->getAttr(6)) {
        $total_weight = $item->getAttr(6)->attribute_values->first()->values;
    } else {
        $total_weight = 0;
    }


    if($total_weight <= 750) {
        $vin_code .= '01';
    } else if($total_weight <= 3500) {
        $vin_code .= '02';
    } else {
        $vin_code .= '03';
    }

    if($item->getAttr(11)) {
        $axel_count = $item->getAttr(11)->attribute_values->first()->values;
    } else {
        $axel_count = 0;
    }

    if($axel_count == 1) {
        $vin_code .= '1';
    } else if($axel_count == 2) {
        $vin_code .= '2';
    } else if($axel_count == 3) {
        $vin_code .= '3';
    }

    $controll_number = 'X';

    $vin_code .= $controll_number;

    /* Production year */
    $year = date('Y');

    if($year == '2022') {
        $vin_code .= 'N';
    }

    if($year == '2023') {
        $vin_code .= 'P';
    }

    if($year == '2024') {
        $vin_code .= 'R';
    }

    if($year == '2025') {
        $vin_code .= 'S';
    }

    if($year == '2026') {
        $vin_code .= 'T';
    }

    /* Manufacturing location */
    $manufacturing_location = 'K';

    $vin_code .= $manufacturing_location;

    /* Serial number */
    $vin_code .= '001';

    return $vin_code;
    // $body_type = $item->;
}
