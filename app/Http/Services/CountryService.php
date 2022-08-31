<?php

namespace App\Http\Services;

use App\Models\Country;
use Cache;
use Str;

class CountryService
{
    protected $countries;
    public $countries_with_states = ['US', 'CA', 'AU'];

    public function __construct($app)
    {
        $this->setAll();
    }

    public function getAll()
    {
        return $this->countries;
    }

    public function getExcept(?array $except)
    {
        return $this->countries->whereNotIn('code', $except);
    }

    public function getOnly(?array $only)
    {
        return $this->countries->whereIn('code', $only);
    }

    public function getCodesAll($as_array = false)
    {
        $codes = $this->countries->pluck('code');

        return $as_array ? $codes->toArray() : $codes;
    }

    public function getCodesForSelect($as_array = false)
    {
        $codes = $this->countries->keyBy('code')->map(fn($item) => $item->name);

        return $as_array ? $codes->toArray() : $codes;
    }

    public function get($id = null, $code = null)
    {
        if ($id) {
            return $this->countries->firstWhere('id', $id);
        } elseif ($code) {
            return $this->countries->firstWhere('code', $code);
        } else {
            return null;
        }
    }

    protected function setAll()
    {
        $cache_key = tenant('id').'_countries';
        $countries = Cache::get($cache_key, null);

        if (empty($countries)) {
            $countries = Country::where('status', 1)->get();

            // Cache the countries if they are found in DB
            if ($countries->isNotEmpty()) {
                Cache::forget($cache_key);
                Cache::put($cache_key, $countries);
            }
        }

        $this->countries = $countries->isNotEmpty() ? $countries : collect([]);
    }

    function isEU($code) {
        $code = $code instanceof Country ? $code->code : $code;
        
        $eu_code = [
            'AT', 'BE', 'BG', 'CY', 'CZ', 'DE', 'DK', 'EE', 'EL',
            'ES', 'FI', 'FR', 'GR', 'HR', 'HU', 'IE', 'IT', 'LT', 'LU', 'LV',
            'MT', 'NL', 'PL', 'PT', 'RO', 'SE', 'SI', 'SK'
        ];

        return (in_array($code, $eu_code));
    }

    function getCountriesWithStates() {
        return $this->countries_with_states;
    }

    function isCountryWithStates($code) {
        $code = $code instanceof Country ? $code->code : $code;

        return (in_array($code, $this->countries_with_states));
    }

    function validateState($country_code, $state) {
        $country_code = $country_code instanceof Country ? $country_code->code : $country_code;

        if(in_array($country_code, $this->countries_with_states)) {
            if($country_code === 'CA') {
                return in_array($state, array_keys($this->getStatesOfCA()));
            } else if($country_code === 'US') {
                return in_array($state, array_keys($this->getStatesOfUS()));
            } else if($country_code === 'AU') {
                return in_array($state, array_keys($this->getStatesOfAU()));
            }
        }

        return true;
    }

    public function getStatesOfUS() {
        return [
            'AL'=>'ALABAMA',
            'AK'=>'ALASKA',
            'AS'=>'AMERICAN SAMOA',
            'AZ'=>'ARIZONA',
            'AR'=>'ARKANSAS',
            'CA'=>'CALIFORNIA',
            'CO'=>'COLORADO',
            'CT'=>'CONNECTICUT',
            'DE'=>'DELAWARE',
            'DC'=>'DISTRICT OF COLUMBIA',
            'FM'=>'FEDERATED STATES OF MICRONESIA',
            'FL'=>'FLORIDA',
            'GA'=>'GEORGIA',
            'GU'=>'GUAM GU',
            'HI'=>'HAWAII',
            'ID'=>'IDAHO',
            'IL'=>'ILLINOIS',
            'IN'=>'INDIANA',
            'IA'=>'IOWA',
            'KS'=>'KANSAS',
            'KY'=>'KENTUCKY',
            'LA'=>'LOUISIANA',
            'ME'=>'MAINE',
            'MH'=>'MARSHALL ISLANDS',
            'MD'=>'MARYLAND',
            'MA'=>'MASSACHUSETTS',
            'MI'=>'MICHIGAN',
            'MN'=>'MINNESOTA',
            'MS'=>'MISSISSIPPI',
            'MO'=>'MISSOURI',
            'MT'=>'MONTANA',
            'NE'=>'NEBRASKA',
            'NV'=>'NEVADA',
            'NH'=>'NEW HAMPSHIRE',
            'NJ'=>'NEW JERSEY',
            'NM'=>'NEW MEXICO',
            'NY'=>'NEW YORK',
            'NC'=>'NORTH CAROLINA',
            'ND'=>'NORTH DAKOTA',
            'MP'=>'NORTHERN MARIANA ISLANDS',
            'OH'=>'OHIO',
            'OK'=>'OKLAHOMA',
            'OR'=>'OREGON',
            'PW'=>'PALAU',
            'PA'=>'PENNSYLVANIA',
            'PR'=>'PUERTO RICO',
            'RI'=>'RHODE ISLAND',
            'SC'=>'SOUTH CAROLINA',
            'SD'=>'SOUTH DAKOTA',
            'TN'=>'TENNESSEE',
            'TX'=>'TEXAS',
            'UT'=>'UTAH',
            'VT'=>'VERMONT',
            'VI'=>'VIRGIN ISLANDS',
            'VA'=>'VIRGINIA',
            'WA'=>'WASHINGTON',
            'WV'=>'WEST VIRGINIA',
            'WI'=>'WISCONSIN',
            'WY'=>'WYOMING',
            'AE'=>'ARMED FORCES AFRICA \ CANADA \ EUROPE \ MIDDLE EAST',
            'AA'=>'ARMED FORCES AMERICA (EXCEPT CANADA)',
            'AP'=>'ARMED FORCES PACIFIC'
        ];
    }

    public function getStatesOfCA() {
        return [
            "AB" => "Alberta", 
            "BC" => "British Columbia", 
            "ON" => "Ontario", 
            "NL" => "Newfoundland and Labrador", 
            "NS" => "Nova Scotia", 
            "PE" => "Prince Edward Island", 
            "NB" => "New Brunswick", 
            "QC" => "Quebec", 
            "MB" => "Manitoba", 
            "SK" => "Saskatchewan", 
            "NT" => "Northwest Territories", 
            "NU" => "Nunavut",
            "YT" => "Yukon Territory"
        ];
    }

    public function getStatesOfAU() {
        return [
            "NSW" => "New South Wales",
            "VIC" => "Victoria",
            "QLD" => "Queensland",
            "TAS" => "Tasmania",
            "SA" => "South Australia",
            "WA" => "Western Australia",
            "NT" => "Northern Territory",
            "ACT" => "Australian Capital Territory"
        ];
    }
}
