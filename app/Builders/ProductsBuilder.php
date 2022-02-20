<?php

namespace App\Builders;

use App\Models\FlashDeal;
use App\Models\Product;
use App\Models\ProductStock;
use App\Models\SerialNumber;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder as QueryBuilder;

use App\Traits\Eloquent\Cacher;
use Illuminate\Support\Collection;
use Vendor;

class ProductsBuilder extends BaseBuilder
{
    use Cacher;

    protected string $stocks_table_name;
    protected string $serial_numbers_table_name;
    protected string $flash_deals_table_name;

    // Regarding `double scopes apply` issue, check the fix here: https://github.com/GeneaLabs/laravel-model-caching/pull/358
    // Point is to check if scopes are already applied before applying them again!

    public function __construct(QueryBuilder $query)
    {
        parent::__construct($query);

        $this->stocks_table_name = with(new ProductStock)->getTable();
        $this->serial_numbers_table_name = with(new SerialNumber())->getTable();
        $this->flash_deals_table_name = with(new FlashDeal())->getTable();

        // Register Product GlobalScopes

        // Determine scope based on user role
        // If admin: select products that are both published and not published
        // If vendor/user: select products which are published


        if(Vendor::isVendorSite()) {
            $this->withGlobalScope('single_vendor', function (Builder $builder) {
                $builder->where('shop_id', '=' , Vendor::getVendorShop()->id ?? null);
            });
        }

        // Eager load all Product Traits:
        //$this->with();

        // Cacher is initially disabled! Where you want to use cached data, chain `->fromCache()` to the builder query!
        //$this->enableCacher();
    }

    /**
     * TODO: This one is not used for now, but logic may be useful in future...
     * Based on given tables, gets the column names and adds proper aliases to each column.
     * It can also ignore specified columns for each table.
     *
     * @param  array  $tables
     * @return ProductsBuilder
     */
    public function unfoldSelectColumns(...$tables) {
        $selectRawArray = [];

        if($tables) {
            foreach($tables as $table) {
                if(!empty($table['name'] ?? null)) {
                    $all_table_columns = array_diff($this->getModel()->getConnection()->getSchemaBuilder()->getColumnListing($table['name']), $table['ignore'] ?? []) ;
                    if($all_table_columns) {
                        array_walk($all_table_columns, fn(&$item, $key) => $item = $table['name'].'.'.$item." AS '".($table['name'].'.'.$item)."'");
                        $selectRawArray = array_merge($selectRawArray, $all_table_columns);
                    }
                }
            }
        }


        $this->selectRaw(implode(',', $selectRawArray));

        return $this;
    }

    // * TODO: This one is not used for now, but logic may be useful in future...
    protected function filterByKeyPrefix($prefix, $item, $cast_type = 'object', $remove_prefix = true): mixed
    {
        if(is_object($item)) {
            $item = (array) $item;
        } else if($item instanceof Collection) {
            $item = $item->toArray();
        } else if(!is_array($item)) {
            return $item;
        }

        $filtered = array_filter(
            $item,
            function($key) use($prefix) {
                return str_starts_with($key, $prefix);
            },
            ARRAY_FILTER_USE_KEY
        );

        if($remove_prefix) {
            foreach($filtered as $key => $value) {
                $needle = "$prefix.";
                $newKey = substr_replace($key, '', strpos($key, $needle), strlen($needle)); // remove first occurence of $needle (`$prefix.`)

                if(!isset($filtered[$newKey]) && $key !== $newKey) {
                    $filtered[$newKey] = $value;
                    unset($filtered[$key]);
                }
            }
        }

        settype($filtered, $cast_type);

        return $filtered;
    }
}
