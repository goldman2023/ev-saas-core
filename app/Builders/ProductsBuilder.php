<?php

namespace App\Builders;

use App\Models\FlashDeal;
use App\Models\Product;
use App\Models\ProductStock;
use App\Models\SerialNumber;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder as QueryBuilder;

use Illuminate\Support\Collection;
use Vendor;

class ProductsBuilder extends Builder
{
    public const FULL_FETCH_SCOPE_IDENTIFIER = 'FULL_FETCH';
    protected string $stocks_table_name;
    protected string $serial_numbers_table_name;
    protected string $flash_deals_table_name;

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
        if(!auth()->check() || (auth()->check() && auth()->user()->isCustomer())) {
            $this->withGlobalScope('published', function (Builder $builder) {
                $builder->where('published', 1);
            });
        }

        if(Vendor::isVendorSite()) {
            $this->withGlobalScope('single_vendor', function (Builder $builder) {
                $builder->where('shop_id', '=' , Vendor::getVendorShop()->id ?? null);
            });
        }

        // Always inner join ProductStock 1:1 relationship with Product Model and sort keys
        /*$this->withGlobalScope(self::FULL_FETCH_SCOPE_IDENTIFIER, function (Builder $builder) {
            $table_name = $builder->getModel()->getTable();

            $builder->unfoldSelectColumns(
                ['name' => $table_name, 'ignore' => ['deleted_at']],
                ['name' => $this->stocks_table_name, 'ignore' => ['created_at','updated_at']],
            );

            // Join Product<->Stock 1:1 Relationship
            $builder->leftJoin($this->stocks_table_name, $table_name.'.id', '=', $this->stocks_table_name.'.subject_id')
                ->where(function($query) {
                    $query->where($this->stocks_table_name.'.subject_type', '=', Product::class)
                        ->orWhere($this->stocks_table_name.'.subject_type', '=', '')
                        ->orWhereNull($this->stocks_table_name.'.subject_type');
                });

            // Join Product<->Stock 1:1 Relationship
        });*/

    }

    /**
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

    /**
     * Create a collection of models from plain arrays.
     *
     * @param  array  $items
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function hydrate(array $items)
    {
        return parent::hydrate($items);
        // If FULL_FETCH_SCOPE is removed, use standard hydrate() from Eloquent/Builder
        if(in_array(self::FULL_FETCH_SCOPE_IDENTIFIER, $this->removedScopes(), true)) {
            return parent::hydrate($items);
        }

        /*$instance = $this->newModelInstance();

        return $instance->newCollection(array_map(function ($item) use ($items, $instance) {
            $model = $instance->newFromBuilder($this->filterByKeyPrefix($this->getModel()->getTable(), $item, 'object', true));

            dd($this->filterByKeyPrefix($this->getModel()->getTable(), $item, 'object', true));

            // Hydrate Stock data

            if (count($items) > 1) {
                $model->preventsLazyLoading = Model::preventsLazyLoading();
            }

            return $model;
        }, $items));*/
    }

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
