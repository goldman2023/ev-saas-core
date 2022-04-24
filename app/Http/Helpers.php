<?php

use App\Facades\TenantSettings;
use App\Models\Currency;
use App\Models\TenantSetting;
use App\Models\Product;
use App\Models\SubSubCategory;
use App\Models\Category;
use App\Models\FlashDealProduct;
use App\Models\FlashDeal;
use App\Models\OtpConfiguration;
use App\Models\Upload;
use App\Models\Translation;
use App\Models\City;
use App\Utility\TranslationUtility;
use App\Utility\CategoryUtility;
use App\Utility\MimoUtility;
use Qirolab\Theme\Theme;
use Twilio\Rest\Client;
use App\Models\Attribute;
use App\Models\Country;
use App\Models\Models\EVLabel;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;


/* IMPORTANT: ALL Helper fuctions added by EIM solutions should be located in: app/Http/Helpers/EIMHelpers */

include('Helpers/EIMHelpers.php');

if (!function_exists('castValueForSave')) {
    function castValueForSave($key, $setting, $data_types) {
        $data_type = $data_types[$key] ?? null;
        $value = $setting['value'] ?? null;
        
        if($data_type === Upload::class || $data_type === Category::class) {
            $value = ctype_digit($value)|| is_numeric($value) ? $value : null;
        } else if($data_type === Currency::class) {
            if(!Currency::where('code', $value)->exists()) {
                $value = 'EUR'; // If currency with $value code does not exist in database, make EUR default
            }
        } else if($data_type === 'int') {
            $value = ctype_digit($value) || is_numeric($value) ? ((int) $value) : $value;
        } else if($data_type === 'boolean') {
            $value = $value ? 1 : 0;
        } else if($data_type === 'array' && $data_type === 'uploads' && is_array($data_type)) {
            $value = json_encode($value);
        }
    
        return $value;
    }
}

if (!function_exists('castValuesForGet')) {
    function castValuesForGet(&$settings, $data_types) {
        if(!empty($settings)) {
            
            foreach($settings as $key => $setting) {
                $data_type = $data_types[$key] ?? null;
                $value = $settings[$key]['value'] ?? null;
                
                try {
                    
                    // This means that there are more sub items inside
                    if(is_array($data_type)) {
                        // If data type is ARRAY, it means that JSON is stored in setting value!
                        // In order to recursively go through it's properties and cast data types, we need to decode it with json_decode first!
                        $settings[$key]['value'] = json_decode($settings[$key]['value'], true);

                        // Check if there are missing sub fields and create them
                        $missing_sub_fields = array_diff_key($data_type, !empty($settings[$key]['value']) ? $settings[$key]['value'] : []);
                        
                        if(!empty($missing_sub_fields)) {
                            foreach($missing_sub_fields as $subkey => $subvalue) {
                                $missing_sub_fields[$subkey] = ''; // reset values to ''
                            }
                        }
 
                        // Merge missing sub fields and existing sub fields (this is imporatant if we add any new tenant setting field!)
                        $settings[$key]['value'] = array_merge(!empty($settings[$key]['value']) ? $settings[$key]['value'] : [], $missing_sub_fields);
                        
                        // Convert Sub Fields values to proper data type
                        castValuesForGet($settings[$key]['value'], $data_type);
                        continue;
                    }

                    if(empty($value)) {
                        if($data_type === 'boolean') {
                            $settings[$key]['value'] = false;
                        } else if($data_type === Currency::class) {
                            $settings[$key]['value'] = Currency::where('code', 'EUR')?->first();
                        }
                        continue;
                    }

                    if(isset($settings[$key]) && !empty($value)) {
                        if($data_type === Upload::class) {
                            $settings[$key]['value'] = Upload::find($value);
                        } else if($data_type === Currency::class) {
                            $settings[$key]['value'] = Currency::where('code', $value)?->first() ?? Currency::where('code', 'EUR')?->first();
                        } else if($data_type === Category::class) {
                            $settings[$key]['value'] = Category::find($value);
                        } else if($data_type === 'uploads') {
                            $uploads = [];
                            if(is_array($value) && !empty($value)) {
                                foreach($value as $upload_id) {
                                    $uploads[] = Upload::find($value);
                                }
                            }
                            $settings[$key]['value'] = collect($uploads);
                        } else if($data_type === 'string') {
                            $settings[$key]['value'] = $value;
                        } else if($data_type === 'int') {
                            $settings[$key]['value'] = ctype_digit($value) ? ((int) $value) : $value;
                        } else if($data_type === 'boolean') {
                            $settings[$key]['value'] = ($value == 0 || $value == "0") ? false : true;
                        } else if($data_type === 'array') {
                            $settings[$key]['value'] = json_decode($value, true);
                        } else if($data_type === 'date') {
                            $settings[$key]['value'] = \Carbon::parse($value)->format('d.m.Y.');
                        } else if($data_type === 'datetime') {
                            $settings[$key]['value'] = \Carbon::parse($value)->format('d.m.Y. H:i');
                        }
                    }       
                } catch(\Throwable $e) {
                    // Set default value is value cannot be parsed due to wrong data type in DB!!!
                    if($data_type === 'boolean') {
                        $settings[$key]['value'] = false;
                    } else if($data_type === Currency::class) {
                        $settings[$key]['value'] = Currency::where('code', 'EUR')?->first();
                    } else {
                        $settings[$key]['value'] = null;
                    }
                }
                
            }

            
        }
        
        return $settings;
    }
}



//highlights the selected navigation on admin panel
if (!function_exists('sendSMS')) {
    function sendSMS($to, $from, $text)
    {
        if (OtpConfiguration::where('type', 'nexmo')->first()->value == 1) {
            $api_key = env("NEXMO_KEY"); //put ssl provided api_token here
            $api_secret = env("NEXMO_SECRET"); // put ssl provided sid here

            $params = [
                "api_key" => $api_key,
                "api_secret" => $api_secret,
                "from" => $from,
                "text" => $text,
                "to" => $to
            ];

            $url = "https://rest.nexmo.com/sms/json";
            $params = json_encode($params);

            $ch = curl_init(); // Initialize cURL
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($params),
                'accept:application/json'
            ));
            $response = curl_exec($ch);
            curl_close($ch);

            return $response;
        } elseif (OtpConfiguration::where('type', 'twillo')->first()->value == 1) {
            $sid = env("TWILIO_SID"); // Your Account SID from www.twilio.com/console
            $token = env("TWILIO_AUTH_TOKEN"); // Your Auth Token from www.twilio.com/console

            $client = new Client($sid, $token);
            try {
                $message = $client->messages->create(
                    $to, // Text this number
                    array(
                        'from' => env('VALID_TWILLO_NUMBER'), // From a valid Twilio number
                        'body' => $text
                    )
                );
            } catch (\Exception $e) {
            }
        } elseif (OtpConfiguration::where('type', 'ssl_wireless')->first()->value == 1) {
            $token = env("SSL_SMS_API_TOKEN"); //put ssl provided api_token here
            $sid = env("SSL_SMS_SID"); // put ssl provided sid here

            $params = [
                "api_token" => $token,
                "sid" => $sid,
                "msisdn" => $to,
                "sms" => $text,
                "csms_id" => date('dmYhhmi') . rand(10000, 99999)
            ];

            $url = env("SSL_SMS_URL");
            $params = json_encode($params);

            $ch = curl_init(); // Initialize cURL
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($params),
                'accept:application/json'
            ));

            $response = curl_exec($ch);

            curl_close($ch);

            return $response;
        } elseif (OtpConfiguration::where('type', 'fast2sms')->first()->value == 1) {

            if (strpos($to, '+91') !== false) {
                $to = substr($to, 3);
            }

            $fields = array(
                "sender_id" => env("SENDER_ID"),
                "message" => $text,
                "language" => env("LANGUAGE"),
                "route" => env("ROUTE"),
                "numbers" => $to,
            );

            $auth_key = env('AUTH_KEY');

            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://www.fast2sms.com/dev/bulkV2",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_SSL_VERIFYHOST => 0,
                CURLOPT_SSL_VERIFYPEER => 0,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => json_encode($fields),
                CURLOPT_HTTPHEADER => array(
                    "authorization: $auth_key",
                    "accept: */*",
                    "cache-control: no-cache",
                    "content-type: application/json"
                ),
            ));

            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);

            return $response;
        } elseif (OtpConfiguration::where('type', 'mimo')->first()->value == 1) {
            $token = MimoUtility::getToken();

            MimoUtility::sendMessage($text, $to, $token);
            MimoUtility::logout($token);
        }
    }
}

//highlights the selected navigation on admin panel
if (!function_exists('areActiveRoutes')) {
    function areActiveRoutes(array $routes, $output = "active")
    {
        foreach ($routes as $route) {
            if (Route::currentRouteName() == $route) return $output;
            if (Route::currentRouteName() == 'attributes.edit') {
                $id = Route::current()->parameters()['id'];
                $attribute = Attribute::findOrFail($id);
                if ($route == 'product.attributes.edit' && $attribute->content_type == Product::class) return $output;
                if ($route == 'seller.attributes.edit' && $attribute->content_type == 'App\Models\Seller') return $output;
            }
        }
    }
}

//highlights the selected navigation on frontend
if (!function_exists('areActiveRoutesHome')) {
    function areActiveRoutesHome(array $routes, $output = "active")
    {
        foreach ($routes as $route) {
            if (Route::currentRouteName() == $route) return $output;
        }
    }
}

//highlights the selected navigation on frontend
if (!function_exists('default_language')) {
    function default_language()
    {
        return config('app.locale');
    }
}

/**
 * Save JSON File
 * @return Response
 */
if (!function_exists('convert_to_usd')) {
    function convert_to_usd($amount)
    {
        $tenant_settings = get_setting('system_default_currency');
        if ($tenant_settings != null) {
            $currency = Currency::find($tenant_settings->value);
            return (floatval($amount) / floatval($currency->exchange_rate)) * Currency::where('code', 'USD')->first()->exchange_rate;
        }
    }
}

if (!function_exists('convert_to_kes')) {
    function convert_to_kes($amount)
    {
        $tenant_settings = get_setting('system_default_currency');
        if ($tenant_settings != null) {
            $currency = Currency::find($tenant_settings->value);
            return (floatval($amount) / floatval($currency->exchange_rate)) * Currency::where('code', 'KES')->first()->exchange_rate;
        }
    }
}

//filter products based on vendor activation system
if (!function_exists('filter_products')) {
    function filter_products($products)
    {
        $verified_sellers = verified_sellers_id();
        if (get_setting('vendor_system_activation') == 1) {
            return $products->where('published', '1')->orderBy('created_at', 'desc')->where(function ($p) use ($verified_sellers) {
                $p->where('added_by', 'admin')->orWhere(function ($q) use ($verified_sellers) {
                    $q->whereIn('user_id', $verified_sellers);
                });
            });
        } else {
            return $products->where('published', '1')->where('added_by', 'admin');
        }
    }
}

//cache products based on category
if (!function_exists('get_cached_products')) {
    function get_cached_products($category_id = null)
    {
        $products = \App\Models\Product::where('published', 1);
        $verified_sellers = verified_sellers_id();
        if (get_setting('vendor_system_activation') == 1) {
            $products =  $products->where(function ($p) use ($verified_sellers) {
                $p->where('added_by', 'admin')->orWhere(function ($q) use ($verified_sellers) {
                    $q->whereIn('user_id', $verified_sellers);
                });
            });
        } else {
            $products = $products->where('added_by', 'admin');
        }

        if ($category_id != null) {
            return Cache::remember('products-category-' . $category_id, 86400, function () use ($category_id, $products) {
                $category_ids = CategoryUtility::children_ids($category_id);
                $category_ids[] = $category_id;
                return $products->whereIn('category_id', $category_ids)->latest()->take(12)->get();
            });
        } else {
            return Cache::remember('products', 86400, function () use ($products) {
                return $products->latest()->get();
            });
        }
    }
}

if (!function_exists('verified_sellers_id')) {
    function verified_sellers_id()
    {
        return App\Models\Seller::where('verification_status', 1)->get()->pluck('user_id')->toArray();
    }
}

//converts currency to home default currency
if (!function_exists('convert_price')) {
    function convert_price($price, $base_currency = null)
    {
        if (($base_currency === \FX::getCurrency()->code) || empty($base_currency)) {
            return $price;
        }

        $code = Cache::remember(tenant('id') . '_system_default_currency', config('cache.stores.redis.ttl_redis_cache', 60), function () {
            return \App\Models\Currency::findOrFail(get_setting('system_default_currency'))->code;
        });

        if (Session::has('currency_code')) {
            $currency = Currency::where('code', Session::get('currency_code', $code))->first();
        } else {
            $currency = Currency::where('code', $code)->first();
        }

        $price = (float) $price / (float) Currency::getDefaultCurrency()->exchange_rate;

        return $price;
    }
}

//formats currency
if (!function_exists('format_price')) {
    function format_price($price)
    {
        if (get_setting('decimal_separator') == 1) {
            $fomated_price = number_format($price, get_setting('no_of_decimals'));
        } else {
            $fomated_price = number_format($price, get_setting('no_of_decimals'), ',', ' ');
        }

        if (get_setting('symbol_format') == 1) {
            return currency_symbol() . $fomated_price;
        }
        return $fomated_price . currency_symbol();
    }
}

//formats price to home default price with convertion
if (!function_exists('single_price')) {
    function single_price($price)
    {
        return format_price(convert_price($price));
    }
}

//Shows Price on page based on low to high
if (!function_exists('home_price')) {
    function home_price($id)
    {
        $product = Product::findOrFail($id);
        $lowest_price = $product->unit_price;
        $highest_price = $product->unit_price;

        if ($product->variant_product) {
            foreach ($product->stocks as $key => $stock) {
                if ($lowest_price > $stock->price) {
                    $lowest_price = $stock->price;
                }
                if ($highest_price < $stock->price) {
                    $highest_price = $stock->price;
                }
            }
        }

        if ($product->tax_type == 'percent') {
            $lowest_price += ($lowest_price * $product->tax) / 100;
            $highest_price += ($highest_price * $product->tax) / 100;
        } elseif ($product->tax_type == 'amount') {
            $lowest_price += $product->tax;
            $highest_price += $product->tax;
        }

        $lowest_price = convert_price($lowest_price);
        $highest_price = convert_price($highest_price);

        if ($lowest_price == $highest_price) {
            return format_price($lowest_price);
        } else {
            return format_price($lowest_price) . ' - ' . format_price($highest_price);
        }
    }
}

//Shows Price on page based on low to high with discount
if (!function_exists('home_discounted_price')) {
    function home_discounted_price($id)
    {
        $product = Product::findOrFail($id);
        $lowest_price = $product->unit_price;
        $highest_price = $product->unit_price;

        if ($product->variant_product) {
            foreach ($product->stocks as $key => $stock) {
                if ($lowest_price > $stock->price) {
                    $lowest_price = $stock->price;
                }
                if ($highest_price < $stock->price) {
                    $highest_price = $stock->price;
                }
            }
        }

        $flash_deals = \App\Models\FlashDeal::where('status', 1)->get();
        $inFlashDeal = false;
        foreach ($flash_deals as $flash_deal) {
            if ($flash_deal != null && $flash_deal->status == 1 && strtotime(date('d-m-Y')) >= $flash_deal->start_date && strtotime(date('d-m-Y')) <= $flash_deal->end_date && FlashDealProduct::where('flash_deal_id', $flash_deal->id)->where('product_id', $id)->first() != null) {
                $flash_deal_product = FlashDealProduct::where('flash_deal_id', $flash_deal->id)->where('product_id', $id)->first();
                if ($flash_deal_product->discount_type == 'percent') {
                    $lowest_price -= ($lowest_price * $flash_deal_product->discount) / 100;
                    $highest_price -= ($highest_price * $flash_deal_product->discount) / 100;
                } elseif ($flash_deal_product->discount_type == 'amount') {
                    $lowest_price -= $flash_deal_product->discount;
                    $highest_price -= $flash_deal_product->discount;
                }
                $inFlashDeal = true;
                break;
            }
        }

        if (!$inFlashDeal) {
            if ($product->discount_type == 'percent') {
                $lowest_price -= ($lowest_price * $product->discount) / 100;
                $highest_price -= ($highest_price * $product->discount) / 100;
            } elseif ($product->discount_type == 'amount') {
                $lowest_price -= $product->discount;
                $highest_price -= $product->discount;
            }
        }

        if ($product->tax_type == 'percent') {
            $lowest_price += ($lowest_price * $product->tax) / 100;
            $highest_price += ($highest_price * $product->tax) / 100;
        } elseif ($product->tax_type == 'amount') {
            $lowest_price += $product->tax;
            $highest_price += $product->tax;
        }

        $lowest_price = convert_price($lowest_price);
        $highest_price = convert_price($highest_price);

        if ($lowest_price == $highest_price) {
            return format_price($lowest_price);
        } else {
            return format_price($lowest_price) . ' - ' . format_price($highest_price);
        }
    }
}

//Shows Base Price
if (!function_exists('home_base_price')) {
    function home_base_price($id, $format = true)
    {
        $product = Product::findOrFail($id);
        $price = $product->unit_price;
        if ($product->tax_type == 'percent') {
            $price += ($price * $product->tax) / 100;
        } elseif ($product->tax_type == 'amount') {
            $price += $product->tax;
        }
        return $format ? format_price(convert_price($price)) : $price;
    }
}

//Shows Base Price with discount
if (!function_exists('home_discounted_base_price')) {
    function home_discounted_base_price($id, $format = true, $both_formats = false)
    {
        $product = Product::findOrFail($id);
        $price = $product->unit_price;

        $flash_deals = \App\Models\FlashDeal::where('status', 1)->get();
        $inFlashDeal = false;
        foreach ($flash_deals as $flash_deal) {
            if ($flash_deal != null && $flash_deal->status == 1 && strtotime(date('d-m-Y')) >= $flash_deal->start_date && strtotime(date('d-m-Y')) <= $flash_deal->end_date && FlashDealProduct::where('flash_deal_id', $flash_deal->id)->where('product_id', $id)->first() != null) {
                $flash_deal_product = FlashDealProduct::where('flash_deal_id', $flash_deal->id)->where('product_id', $id)->first();
                if ($flash_deal_product->discount_type == 'percent') {
                    $price -= ($price * $flash_deal_product->discount) / 100;
                } elseif ($flash_deal_product->discount_type == 'amount') {
                    $price -= $flash_deal_product->discount;
                }
                $inFlashDeal = true;
                break;
            }
        }

        if (!$inFlashDeal) {
            if ($product->discount_type == 'percent') {
                $price -= ($price * $product->discount) / 100;
            } elseif ($product->discount_type == 'amount') {
                $price -= $product->discount;
            }
        }

        if ($product->tax_type == 'percent') {
            $price += ($price * $product->tax) / 100;
        } elseif ($product->tax_type == 'amount') {
            $price += $product->tax;
        }

        if ($both_formats) {
            return [
                'raw' => $price,
                'display' => format_price(convert_price($price))
            ];
        }

        return $format ? format_price(convert_price($price)) : $price;
    }
}

if (!function_exists('currency_symbol')) {
    function currency_symbol()
    {
        $code = Cache::remember('system_default_currency',  config('cache.stores.redis.ttl_redis_cache', 60), function () {
            return \App\Models\Currency::findOrFail(get_setting('system_default_currency'))->code;
        });

        if (Session::has('currency_code')) {


            $currency =  Cache::remember($code . '_cache', 86400, function () use ($code) {
                return Currency::where('code', Session::get('currency_code', $code))->first();
            });
        } else {
            $currency = Currency::where('code', $code)->first();
        }
        return $currency->symbol;
    }
}

if (!function_exists('renderStarRating')) {
    function renderStarRating($rating, $maxRating = 5)
    {
        $html = "<span class = 'rating rating-sm'>";
        $fullStar = "<i class = 'las la-star active'></i>";
        $halfStar = "<i class = 'las la-star half'></i>";
        $emptyStar = "<i class = 'las la-star'></i>";
        $rating = $rating <= $maxRating ? $rating : $maxRating;

        $fullStarCount = (int)$rating;
        $halfStarCount = ceil($rating) - $fullStarCount;
        $emptyStarCount = $maxRating - $fullStarCount - $halfStarCount;

        $html .= str_repeat($fullStar, $fullStarCount);
        $html .= str_repeat($halfStar, $halfStarCount);
        $html .= str_repeat($emptyStar, $emptyStarCount);
        $html .= "</span>";
        echo $html;
    }
}


//Api
if (!function_exists('homeBasePrice')) {
    function homeBasePrice($id)
    {
        $product = Product::findOrFail($id);
        $price = $product->unit_price;
        if ($product->tax_type == 'percent') {
            $price += ($price * $product->tax) / 100;
        } elseif ($product->tax_type == 'amount') {
            $price += $product->tax;
        }
        return $price;
    }
}

if (!function_exists('homeDiscountedBasePrice')) {
    function homeDiscountedBasePrice($id)
    {
        $product = Product::findOrFail($id);
        $price = $product->unit_price;

        $flash_deals = FlashDeal::where('status', 1)->get();
        $inFlashDeal = false;
        foreach ($flash_deals as $flash_deal) {
            if ($flash_deal != null && $flash_deal->status == 1 && strtotime(date('d-m-Y')) >= $flash_deal->start_date && strtotime(date('d-m-Y')) <= $flash_deal->end_date && FlashDealProduct::where('flash_deal_id', $flash_deal->id)->where('product_id', $id)->first() != null) {
                $flash_deal_product = FlashDealProduct::where('flash_deal_id', $flash_deal->id)->where('product_id', $id)->first();
                if ($flash_deal_product->discount_type == 'percent') {
                    $price -= ($price * $flash_deal_product->discount) / 100;
                } elseif ($flash_deal_product->discount_type == 'amount') {
                    $price -= $flash_deal_product->discount;
                }
                $inFlashDeal = true;
                break;
            }
        }

        if (!$inFlashDeal) {
            if ($product->discount_type == 'percent') {
                $price -= ($price * $product->discount) / 100;
            } elseif ($product->discount_type == 'amount') {
                $price -= $product->discount;
            }
        }

        if ($product->tax_type == 'percent') {
            $price += ($price * $product->tax) / 100;
        } elseif ($product->tax_type == 'amount') {
            $price += $product->tax;
        }
        return $price;
    }
}

if (!function_exists('homePrice')) {
    function homePrice($id)
    {
        $product = Product::findOrFail($id);
        $lowest_price = $product->unit_price;
        $highest_price = $product->unit_price;

        if ($product->variant_product) {
            foreach ($product->stocks as $key => $stock) {
                if ($lowest_price > $stock->price) {
                    $lowest_price = $stock->price;
                }
                if ($highest_price < $stock->price) {
                    $highest_price = $stock->price;
                }
            }
        }

        if ($product->tax_type == 'percent') {
            $lowest_price += ($lowest_price * $product->tax) / 100;
            $highest_price += ($highest_price * $product->tax) / 100;
        } elseif ($product->tax_type == 'amount') {
            $lowest_price += $product->tax;
            $highest_price += $product->tax;
        }

        $lowest_price = convertPrice($lowest_price);
        $highest_price = convertPrice($highest_price);

        return $lowest_price . ' - ' . $highest_price;
    }
}

if (!function_exists('homeDiscountedPrice')) {
    function homeDiscountedPrice($id)
    {
        $product = Product::findOrFail($id);
        $lowest_price = $product->unit_price;
        $highest_price = $product->unit_price;

        if ($product->variant_product) {
            foreach ($product->stocks as $key => $stock) {
                if ($lowest_price > $stock->price) {
                    $lowest_price = $stock->price;
                }
                if ($highest_price < $stock->price) {
                    $highest_price = $stock->price;
                }
            }
        }

        $flash_deals = FlashDeal::where('status', 1)->get();
        $inFlashDeal = false;
        foreach ($flash_deals as $flash_deal) {
            if ($flash_deal != null && $flash_deal->status == 1 && strtotime(date('d-m-Y')) >= $flash_deal->start_date && strtotime(date('d-m-Y')) <= $flash_deal->end_date && FlashDealProduct::where('flash_deal_id', $flash_deal->id)->where('product_id', $id)->first() != null) {
                $flash_deal_product = FlashDealProduct::where('flash_deal_id', $flash_deal->id)->where('product_id', $id)->first();
                if ($flash_deal_product->discount_type == 'percent') {
                    $lowest_price -= ($lowest_price * $flash_deal_product->discount) / 100;
                    $highest_price -= ($highest_price * $flash_deal_product->discount) / 100;
                } elseif ($flash_deal_product->discount_type == 'amount') {
                    $lowest_price -= $flash_deal_product->discount;
                    $highest_price -= $flash_deal_product->discount;
                }
                $inFlashDeal = true;
                break;
            }
        }

        if (!$inFlashDeal) {
            if ($product->discount_type == 'percent') {
                $lowest_price -= ($lowest_price * $product->discount) / 100;
                $highest_price -= ($highest_price * $product->discount) / 100;
            } elseif ($product->discount_type == 'amount') {
                $lowest_price -= $product->discount;
                $highest_price -= $product->discount;
            }
        }

        if ($product->tax_type == 'percent') {
            $lowest_price += ($lowest_price * $product->tax) / 100;
            $highest_price += ($highest_price * $product->tax) / 100;
        } elseif ($product->tax_type == 'amount') {
            $lowest_price += $product->tax;
            $highest_price += $product->tax;
        }

        $lowest_price = convertPrice($lowest_price);
        $highest_price = convertPrice($highest_price);

        return $lowest_price . ' - ' . $highest_price;
    }
}

if (!function_exists('brandsOfCategory')) {
    function brandsOfCategory($category_id)
    {
        $brands = [];
        $subCategories = SubCategory::where('category_id', $category_id)->get();
        foreach ($subCategories as $subCategory) {
            $subSubCategories = SubSubCategory::where('sub_category_id', $subCategory->id)->get();
            foreach ($subSubCategories as $subSubCategory) {
                $brand = json_decode($subSubCategory->brands);
                foreach ($brand as $b) {
                    if (in_array($b, $brands)) continue;
                    array_push($brands, $b);
                }
            }
        }
        return $brands;
    }
}

if (!function_exists('convertPrice')) {
    function convertPrice($price)
    {
        $tenant_settings = get_setting('system_default_currency')->first();
        if ($tenant_settings != null) {
            $currency = Currency::find($tenant_settings->value);
            $price = floatval($price) / floatval($currency->exchange_rate);
        }
        $code = Currency::findOrFail(get_setting('system_default_currency'))->code;
        if (Session::has('currency_code')) {
            $currency = Currency::where('code', Session::get('currency_code', $code))->first();
        } else {
            $currency = Currency::where('code', $code)->first();
        }
        $price = floatval($price) * floatval($currency->exchange_rate);
        return $price;
    }
}


function translate($key, $lang = null)
{
    if ($lang == null) {
        $lang = App::getLocale();
    }

    /*
     * TODO: Make Translation Singleton in which we'll get all translations in assoc array:
     * [
     *      lang_key => [`$lang` => ['id' => `$id`, value => `$lang_value`]]
     *      ...
     * ]
     *
     * TODO: Refactor this function to get translation for the $key from assoc array in singleton
     * TODO: If there's none, create it in the DB and regenerate whole assoc array in Cache
     */
    $translation_def = Cache::remember($key . $lang, 60, function () use ($key) {
        return Translation::where('lang', config('app.locale'))->where('lang_key', $key)->first();
    });

    if ($translation_def == null) {
        $translation_def = new Translation;
        $translation_def->lang = config('app.locale');
        $translation_def->lang_key = $key;
        $translation_def->lang_value = $key;
        $translation_def->save();
    }

    //Check for session lang
    $translation_locale = Translation::where('lang_key', $key)->where('lang', $lang)->first();

    if ($translation_locale != null && $translation_locale->lang_value != null) {
        return $translation_locale->lang_value;
    } elseif ($translation_def->lang_value != null) {
        return $translation_def->lang_value;
    } else {
        return $key;
    }
}

function remove_invalid_charcaters($str)
{
    $str = str_ireplace(array("\\"), '', $str);
    return str_ireplace(array('"'), '\"', $str);
}

function getShippingCost($index)
{
    $admin_products = array();
    $seller_products = array();
    $calculate_shipping = 0;

    foreach (Session::get('cart')->where('owner_id', Session::get('owner_id')) as $key => $cartItem) {
        $product = \App\Models\Product::find($cartItem['id']);
        if ($product->added_by == 'admin') {
            array_push($admin_products, $cartItem['id']);
        } else {
            $product_ids = array();
            if (array_key_exists($product->user_id, $seller_products)) {
                $product_ids = $seller_products[$product->user_id];
            }
            array_push($product_ids, $cartItem['id']);
            $seller_products[$product->user_id] = $product_ids;
        }
    }

    //Calculate Shipping Cost
    if (get_setting('shipping_type') == 'flat_rate') {
        $calculate_shipping = get_setting('flat_rate_shipping_cost');
    } elseif (get_setting('shipping_type') == 'seller_wise_shipping') {
        if (!empty($admin_products)) {
            $calculate_shipping = get_setting('shipping_cost_admin');
        }
        if (!empty($seller_products)) {
            foreach ($seller_products as $key => $seller_product) {
                $calculate_shipping += \App\Models\Shop::where('user_id', $key)->first()->shipping_cost;
            }
        }
    } elseif (get_setting('shipping_type') == 'area_wise_shipping') {
        $city = City::where('name', Session::get('shipping_info')['city'])->first();
        if ($city != null) {
            $calculate_shipping = $city->cost;
        }
    }

    $cartItem = Session::get('cart')[$index];
    $product = \App\Models\Product::find($cartItem['id']);

    if ($product->digital == 1) {
        return $calculate_shipping = 0;
    }

    if (get_setting('shipping_type') == 'flat_rate') {
        return $calculate_shipping / count(Session::get('cart'));
    } elseif (get_setting('shipping_type') == 'seller_wise_shipping') {
        if ($product->added_by == 'admin') {
            return get_setting('shipping_cost_admin') / count($admin_products);
        } else {
            return \App\Models\Shop::where('user_id', $product->user_id)->first()->shipping_cost / count($seller_products[$product->user_id]);
        }
    } elseif (get_setting('shipping_type') == 'area_wise_shipping') {
        if ($product->added_by == 'admin') {
            return $calculate_shipping / count($admin_products);
        } else {
            return $calculate_shipping / count($seller_products[$product->user_id]);
        }
    } else {
        return \App\Models\Product::find($cartItem['id'])->shipping_cost;
    }
}

function timezones()
{
    return true;
    // return Timezones::timezonesToArray();
}

if (!function_exists('app_timezone')) {
    function app_timezone()
    {
        return config('app.timezone');
    }
}

if (!function_exists('api_asset')) {
    function api_asset($id)
    {
        if (($asset = \App\Models\Upload::find($id)) != null) {
            return $asset->file_name;
        }
        return "";
    }
}

//return file uploaded via uploader
if (!function_exists('uploaded_asset')) {
    function uploaded_asset($id, $width = 0)
    {
        /*  TODO: Fix this logic to unify images management */
        if (is_numeric($id)) {
            if (($asset = \App\Models\Upload::find($id)) != null) {
                $data = my_asset($asset->file_name);
                /* TODO: This is temporary fix */

                $file = str_replace('tenancy/assets/', '', $data);

                $proxy_image = config('imgproxy.host') . '/insecure/fill/0/0/ce/0/plain/' . $file;

                return $proxy_image;
            }
        } else {
            $proxy_image = config('imgproxy.host') . '/insecure/fill/0/0/ce/0/plain/' . $id . '@webp';

            return $proxy_image;
        }


        return null;
    }
}

if (!function_exists('my_asset')) {
    /**
     * Generate an asset path for the application.
     *
     * @param  string  $path
     * @param  bool|null  $secure
     * @return string
     */
    function my_asset($path, $secure = null)
    {
        if (config('filesystems.default') === 's3') {
            return Storage::disk('s3')->url($path);
        } else {
            return app('url')->asset($path, $secure);
        }
    }
}

if (!function_exists('static_asset')) {
    /**
     * Generate an asset path for the application.
     *
     * @param  string  $path
     * @param  bool|null  $secure
     * @return string
     */
    function static_asset($path, $secure = null, $theme = false, $cache_bust = false)
    {
        $filemtime = '';

        try {
            if ($cache_bust) {
                $filemtime = filemtime(public_path('themes/' . Theme::parent() . '/' . $path));
            }
        } catch (\Exception $e) {
        }
        if ($theme) {
            if (config('app.force_https')) {
                return app('url')->asset('themes/' . Theme::parent() . '/' . $path, true) . ($cache_bust ? '?v=' . $filemtime : '');
            } else {
                return app('url')->asset('themes/' . Theme::parent() . '/' . $path, $secure) . ($cache_bust ? '?v=' . $filemtime : '');
            }
        }

        return app('url')->asset($path, $secure);
    }
}

if (!function_exists('static_asset_root')) {
    /**
     * Generate an asset path for the application.
     *
     * @param  string  $path
     * @param  bool|null  $secure
     * @return string
     */
    function static_assets_root($path, $secure = null, $theme = false)
    {
        if ($theme) {
            return url('themes/' . Theme::parent() . '/' . $path);
        }
        return url('/' . $path);
    }
}



if (!function_exists('isHttps')) {
    function isHttps()
    {
        return !empty($_SERVER['HTTPS']) && ('on' == $_SERVER['HTTPS']);
    }
}

if (!function_exists('getBaseURL')) {
    function getBaseURL()
    {
        if (config('app.force_https') === false) {
            return route('home');
        } else {
            return  secure_url('/');
        }
    }
}


if (!function_exists('getStorageBaseURL')) {
    function getStorageBaseURL()
    {
        if (config('filesystems.default') === 's3') {
            return config('filesystems.disks.s3.subdomain_endpoint') . '/';
        } else {
            return getBaseURL();
        }
    }
}

if (!function_exists('getBucketBaseURL')) {
    function getBucketBaseURL()
    {
        if (config('filesystems.default') === 's3') {
            return config('filesystems.disks.s3.subdomain_endpoint') . '/';
        } else {
            return getBaseURL();
        }
    }
}



if (!function_exists('isUnique')) {
    /**
     * Generate an asset path for the application.
     *
     * @param  string  $path
     * @param  bool|null  $secure
     * @return string
     */
    function isUnique($email)
    {
        $user = \App\Models\User::where('email', $email)->first();

        if ($user == null) {
            return '1'; // $user = null means we did not get any match with the email provided by the user inside the database
        } else {
            return '0';
        }
    }
}

if (!function_exists('get_setting')) {
    /* Het setting deprecated use  get_tenant_setting() instead */
    function get_setting($key, $default = null)
    {
        return TenantSettings::get($key, $default);
    }

    function  get_tenant_setting($key, $default = null)
    {
        return TenantSettings::get($key, $default);
    }
}

function hex2rgba($color, $opacity = false)
{
    $default = 'rgb(0,0,0)';

    //Return default if no color provided
    if (empty($color))
        return $default;

    //Sanitize $color if "#" is provided
    if ($color[0] == '#') {
        $color = substr($color, 1);
    }

    //Check if color has 6 or 3 characters and get values
    if (strlen($color) == 6) {
        $hex = array($color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5]);
    } elseif (strlen($color) == 3) {
        $hex = array($color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2]);
    } else {
        return $default;
    }

    //Convert hexadec to rgb
    $rgb =  array_map('hexdec', $hex);

    //Check if opacity is set(rgba or rgb)
    if ($opacity) {
        if (abs($opacity) > 1)
            $opacity = 1.0;
        $output = 'rgba(' . implode(",", $rgb) . ',' . $opacity . ')';
    } else {
        $output = 'rgb(' . implode(",", $rgb) . ')';
    }

    //Return rgb(a) color string
    return $output;
}

if (!function_exists('isAdmin')) {
    function isAdmin()
    {
        if (Auth::check() && (auth()->user()->isAdmin() || auth()->user()->isStaff())) {
            return true;
        }
        return false;
    }
}

if (!function_exists('isSeller')) {
    function isSeller()
    {
        if (Auth::check() && auth()->user()->isSeller()) {
            return true;
        }
        return false;
    }
}

if (!function_exists('isCustomer')) {
    function isCustomer()
    {
        if (Auth::check() && auth()->user()->isCustomer()) {
            return true;
        }
        return false;
    }
}

if (!function_exists('formatBytes')) {
    function formatBytes($bytes, $precision = 2)
    {
        $units = array('B', 'KB', 'MB', 'GB', 'TB');

        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);

        // Uncomment one of the following alternatives
        $bytes /= pow(1024, $pow);
        // $bytes /= (1 << (10 * $pow));

        return round($bytes, $precision) . ' ' . $units[$pow];
    }
}

// duplicates m$ excel's ceiling function
if (!function_exists('ceiling')) {
    function ceiling($number, $significance = 1)
    {
        return (is_numeric($number) && is_numeric($significance)) ? (ceil($number / $significance) * $significance) : false;
    }
}

if (!function_exists('get_images')) {
    function get_images($given_ids, $with_trashed = false)
    {
        $given_ids = array_filter($given_ids);

        $ids = is_array($given_ids)
            ? $given_ids
            : (is_null($given_ids) ? [] : explode(",", $given_ids));

        if (empty($ids))
            return collect([]);

        return $with_trashed
            ? Upload::withTrashed()->whereIn('id', $ids)->get()
            : Upload::whereIn('id', $ids)->get();
    }
}

//for api
if (!function_exists('get_images_path')) {
    function get_images_path($given_ids, $with_trashed = false)
    {
        $paths = [];
        $images = get_images($given_ids, $with_trashed);
        if (!$images->isEmpty()) {
            foreach ($images as $image) {
                $paths[] = !is_null($image) ? $image->file_name : "";
            }
        }

        return $paths;
    }
}

//for api
if (!function_exists('checkout_done')) {
    function checkout_done($order_id, $payment)
    {
        $order = Order::findOrFail($order_id);
        $order->payment_status = 'paid';
        $order->payment_details = $payment;
        $order->save();





        $order->commission_calculated = 1;
        $order->save();
    }
}

//for api
if (!function_exists('wallet_payment_done')) {
    function wallet_payment_done($user_id, $amount, $payment_method, $payment_details)
    {
        $user = \App\Models\User::find($user_id);
        $user->balance = $user->balance + $amount;
        $user->save();

        $wallet = new Wallet;
        $wallet->user_id = $user->id;
        $wallet->amount = $amount;
        $wallet->payment_method = $payment_method;
        $wallet->payment_details = $payment_details;
        $wallet->save();
    }
}
/**
 * Generate a querystring url for the application.
 *
 * Assumes that you want a URL with a querystring rather than route params
 * (which is what the default url() helper does)
 *
 * @param  string  $path
 * @param  mixed   $qs
 * @param  bool    $secure
 * @return string
 */
if (!function_exists('qs_url')) {
    function qs_url($path = null, $qs = array(), $secure = null)
    {
        $url = app('url')->to($path, $secure);
        if (count($qs)) {

            foreach ($qs as $key => $value) {
                $qs[$key] = sprintf('%s=%s', $key, urlencode($value));
            }
            $url = sprintf('%s?%s', $url, implode('&', $qs));
        }
        return $url;
    }
}

/**
 * used to calculate to percentage difference
 */
if (!function_exists('percentage_change')) {
    function percentage_change($old_value, $new_value)
    {
        $difference = $new_value - $old_value;
        return ceil(($difference / $old_value) * 100);
    }
}

/**
 * get default schema attribute names
 */
if (!function_exists('default_schema_attributes')) {
    function default_schema_attributes($content_type)
    {
        return Attribute::where('content_type', $content_type)->where('is_default', true)->where('is_schema', true)->pluck('name')->toArray();
    }
}


function get_pricing_plans_array()
{
    $pricing_plans = [];
    // Prospect
    $pricing_plans[] = [
        'digital_profile' => ['label' => 'Digital Profile', 'included' => true],
        'verification' => ['label' => 'Verification', 'included' => false],
        'press_releases' => ['label' => 'Press Releases', 'included' => false],
        'content_management' => ['label' => 'Content Management', 'included' => false],
        'visibility' => ['label' => 'Visibility', 'included' => false],
    ];

    // Basic
    $pricing_plans[] = [
        'digital_profile' => ['label' => 'Digital Profile', 'included' => true],
        'verification' => ['label' => 'Verification', 'included' => true],
        'press_releases' => ['label' => 'Press Releases', 'included' => true],
        'content_management' => ['label' => 'Content Management', 'included' => false],
        'visibility' => ['label' => 'Visibility', 'included' => false],
    ];

    // Prime
    $pricing_plans[] = [
        'digital_profile' => ['label' => 'Digital Profile', 'included' => true],
        'verification' => ['label' => 'Verification', 'included' => true],
        'press_releases' => ['label' => 'Press Releases', 'included' => true],
        'content_management' => ['label' => 'Content Management', 'included' => true],
        'visibility' => ['label' => 'Visibility', 'included' => true],
    ];

    return $pricing_plans;
}

function country_name_by_code($code)
{
    if (empty($code)) {
        $code = 'default';
    }

    $country = Country::where('code', '=', $code)->first();
    if ($country == null) {
        return $code;
    }

    return $country->name;
}
