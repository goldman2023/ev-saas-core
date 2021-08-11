<?php


use App\Models\Category;
use App\Models\User;

function shorten_string($string, $wordsreturned)
{
    $retval = $string;
    $string = preg_replace('/(?<=\S,)(?=\S)/', ' ', $string);
    $string = str_replace("\n", " ", $string);
    $array = explode(" ", $string);
    if (count($array) <= $wordsreturned) {
        $retval = $string;
    } else {
        array_splice($array, $wordsreturned);
        $retval = implode(" ", $array) . " ...";
    }
    return $retval;
}

function get_active_theme()
{
    $theme = 'frontend';

    if(get_vendor_mode() === 'single') {
        $theme = 'frontend_mt_front';
    }
    return $theme;
}

function get_site_name() {
    $site_name =  'GunOB';
    if(isset($_SERVER['SERVER_NAME'])) {
        if($_SERVER['SERVER_NAME'] === 'gunob.com') {
            $single_vendor = config('ev-saas.company');
            $site_name = $single_vendor->name;
        }
    }


    return $site_name;
}

/* TODO: Make this tenant aware and also an option for single vendor */
function get_site_logo()
{
    /* TODO: make this single/multi tenant aware */
    if(get_vendor_mode() === 'single') {
        $company = config('ev-saas.company');
        $logo = uploaded_asset($company->logo);
    } else {
        $logo = get_setting('header_logo');
    }
    return $logo;
}

function get_site_colors()
{
    $colors = [
        'primary' => '#000000',
        'secondary' => '#ffffff',
        'success' => 'green',
        'danger' => 'red',
    ];

    return $colors;
}

function get_site_product_scope() {
    $scope = "all";

    return $scope;
}

function get_available_categories($sorted = true) {
    $categories = Category::all();

    if($sorted) {
        $categoriesSorted = $categories->sortBy(function ($category) {
            return $category->products->count() * -1;
        })->take(6);

        $categories = $categoriesSorted;
    }

    return $categories;
}

function get_vendor_mode() {
    $options = [
        'single',
        'multi'
    ];
    if(request()->getHost() === 'gunob.com') {
        $option = $options[0];

    } else {
        $option = $options[1];
    }

    return $option;
}


