<?php


use App\Models\Category;
use App\Models\User;
use Qirolab\Theme\Theme;
use App\Models\Models\EVLabel;
use Illuminate\Support\Facades\Cache;

function castCollectionItemsTo($data = null, $dataType = 'object', $casts = null) {
    if(!empty($data)) {
        if(!$data instanceof \Illuminate\Support\Collection) {
            $data = collect($data);
        }

        $data = $data->map(function ($item, $index) use ($dataType, $casts) {
            settype($item, $dataType);

            if(!empty($casts) && (is_object($item) || is_array($item))) {
                foreach($casts as $key => $cast) {
                    if(is_object($item)) {
                        settype($item->{$key}, $cast);
                    } else if(is_array($item)) {
                        settype($item[$key], $cast);
                    }
                }
            }

            return $item;
        });
    }

    return $data;
}

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
    return Theme::active();
}

function get_site_name()
{
    $site_name =  get_setting('website_name');
    if (isset($_SERVER['SERVER_NAME'])) {
        if ($_SERVER['SERVER_NAME'] === 'gunob.com') {

            $site_name = 'MT Baltic';
        }
    }


    return $site_name;
}

/* TODO: Make this tenant aware and also an option for single vendor */
function get_site_logo()
{
    /* TODO: make this single/multi tenant aware */
    if (get_vendor_mode() === 'single') {
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

function get_site_product_scope()
{
    $scope = "all";

    return $scope;
}

function get_available_categories($sorted = true)
{
    $categories = Category::all();

    if ($sorted) {
        $categoriesSorted = $categories->sortBy(function ($category) {
            return $category->products->count() * -1;
        })->take(6);

        $categories = $categoriesSorted;
    }

    return $categories;
}

function get_vendor_mode()
{
    $options = [
        'single',
        'multi'
    ];
    if (request()->getHost() === 'gunob.com') {
        $option = $options[0];
    } else {
        $option = $options[1];
    }

    return $option;
}

/**
 * Gets the available cart types(components) for current tenant theme
 *
 * Returns available cart types for the current theme.
 * This function is used to determine which cart from the theme client wants to use on site.
 * Note: Only carts from current tenant theme can be displayed
 *
 * @param string $type - full/adhoc/mini cart types
 *
 * @return array $cart_templates - name of the cart blade file inside a specific theme
 */
function get_theme_cart_templates($type = 'full')
{
    if (in_array($type, ['full', 'adhoc', 'mini'])) {
        $carts_path = Theme::path('views/components/tenant/cart/' . $type);
    } else {
        return [];
    }

    $cart_templates = [];
    $files = array_diff(scandir($carts_path), array('.', '..'));

    if (empty($files)) {
        // TODO: Get global carts if no carts are present in chosen tenant theme
    }

    foreach ($files as $filename) {
        $path = $carts_path . '/' . $filename;

        $base_filename = str_replace('.blade.php', '', $filename);
        if ($base_filename === 'mini-cart') {
            continue;
        }

        $tokens = token_get_all(file_get_contents($path));
        $file_comments = [];

        foreach ($tokens as $token) {

            if (isset($token[0]) && isset($token[1])) {
                if ($token[0] == T_COMMENT || $token[0] == T_DOC_COMMENT) {
                    $file_comments[] = $token[1];
                    break;
                }
            }
        }

        if ($file_comments) {
            $_to_string = trim(current($file_comments), "\**/");
            foreach (explode(PHP_EOL, $_to_string) as $item) {
                $itemData = explode(":", $item);

                if (count($itemData) === 2 && (trim($itemData[0]) == 'Title' || trim($itemData[0]) == '* Title')) {
                    $cart_templates[$base_filename] = trim($itemData[1]);
                }
            }
        }
    }

    return $cart_templates;
}


function ev_dynamic_translate($key, $global = false, $lang = null)
{
    $ttl = 60;
    $stringKey = ev_dynamic_translate_key($key, $global, $lang);
    $dynamic_label = Cache::remember($stringKey, $ttl, function () use ($stringKey) {
        return EVLabel::where('key', $stringKey)->get();
    });



    /*  TODO: Make sure to upgrade this for multilanguage support */
    if (count($dynamic_label)) {
        $dynamic_label = $dynamic_label[0];
    } else {
        $dynamic_label = new EVLabel();
        $dynamic_label->key = $stringKey;
        $dynamic_label->value = $key;

        $dynamic_label->save();
    }

    return $dynamic_label;
}

function ev_dynamic_attribute($key, $attribute = 1, $global = true, $lang = null)
{
    $stringKey = ev_dynamic_translate_key($key, $global, $lang);
    $ttl = 60;
    $dynamic_attribute = Cache::remember($stringKey, $ttl, function () use ($stringKey) {
        return EVLabel::where('key', $stringKey)->get();
    });

    /*  TODO: Make sure to upgrade this for multilanguage support */
    if (count($dynamic_attribute) > 0) {
        $dynamic_attribute = $dynamic_attribute[0];
    } else {
        $dynamic_attribute = new EVLabel();
        $dynamic_attribute->key = $stringKey;
        $dynamic_attribute->value = $key;

        $dynamic_attribute->save();
    }

    return $dynamic_attribute;
}

function ev_dynamic_translate_key($key, $global = false, $lang = null)
{
    $label_prefix =  Route::currentRouteName();

    if (Route::current()->parameters()) {
        $label_prefix .= '.' . implode(Route::current()->parameters());
    }

    if ($global) {
        $label_prefix = 'global';
    }


    $excluded_prefixes = [
        'admin',
        'stancl.tenancy'
    ];

    foreach ($excluded_prefixes as $excluded) {
        if (str_contains($label_prefix, $excluded)) {
            return $key;
        }
    }

    $stringKey = $label_prefix . '.' . $key;

    return $stringKey;
}

function is_vendor_site() {
    /* TODO: make this dynamic */
    return false;
}
