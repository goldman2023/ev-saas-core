<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Stats extends Model
{
    use HasFactory;

    public static function total_companies()
    {
        $total = Cache::remember('homepage-stats-total-companies', 86400, function () {
            $total = Shop::count();

            return $total;
        });

        return $total;
    }

    public static function total_production_capacity()
    {
        $total = Cache::remember('homepage-stats-production-capacity', 86400, function () {
            $total = 0;

            $companies = Seller::whereIn('user_id', verified_sellers_id())->get();

            foreach ($companies as $company) {
                $single_value = $company->user->seller->get_attribute_value_by_id(15);
                if (is_numeric($single_value)) {
                    $total += $single_value;
                }
            }

            return $total;
        });

        $output = number_format($total, 0, '.', ',');

        return $output;
    }

    public static function total_companies_turnover()
    {
        $companies = Shop::whereIn('user_id', verified_sellers_id())->get();
        $total = Cache::remember('homepage-stats-comapnies-turnover', 120, function () {
            $total_number = 0;

            $companies = Seller::whereIn('user_id', verified_sellers_id())->get();

            foreach ($companies as $company) {
                $single_value = $company->user->seller->get_attribute_value_by_id(35);
                if (is_numeric($single_value)) {
                    $total_number += $single_value;
                }
            }

            return $total_number;
        });

        $output = number_format($total, 0, '.', ',');

        return $output;
    }

    public static function total_production_purchasing()
    {
        $total = Cache::remember('homepage-stats-production-purchasing', 0, function () {
            $total = 0;

            $companies = Seller::whereIn('user_id', verified_sellers_id())->get();

            foreach ($companies as $company) {
                $single_value = $company->get_attribute_value_by_id(22);
                if (is_numeric($single_value)) {
                    $total += $single_value;
                }
            }

            return $total;
        });

        $output = number_format($total, 0, '.', ',');

        return $output;
    }
}
