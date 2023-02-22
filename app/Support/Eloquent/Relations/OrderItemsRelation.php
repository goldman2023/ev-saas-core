<?php

namespace App\Support\Eloquent\Relations;

use App\Models\WeBaseModel;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\Relation;

class OrderItemsRelation extends HasMany
{
    protected $query;
    protected $model;
    protected $parent;

    public function __construct($model, $related, $foreignKey = null, $localKey = null)
    {
        $instance = tap(new $related, function ($instance) use($model) {
            if (! $instance->getConnectionName()) {
                $instance->setConnection($model->connection);
            }
        });

        $foreignKey = $foreignKey ?: $model->getForeignKey();

        $localKey = $localKey ?: $model->getKeyName();

        return parent::__construct($instance->newQuery(), $model, $instance->getTable().'.'.$foreignKey, $localKey);
    }

    /**
     * Get the results of the relationship.
     * 
     * For calls: $model->{relation}

     * @return mixed
     */
    public function getResults() {
        $order_items_full = $this->query->with(['descendants'])->get();
        $order_items = new \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection();

        if(!empty($order_items_full)) {
            foreach($order_items_full as $index => $item) {
                if(empty($item->parent_id)) {
                    $order_items->push($item);
                }
            }
        }

        return $order_items;
    }

    /**
     * Execute the query as a "select" statement.
     *
     * For calls: $model->{relation}()->get()
     * 
     * @param  array  $columns
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function get($columns = ['*'])
    {
        $order_items_full = $this->query->with(['descendants'])->get($columns);
        $order_items = new \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection();

        if(!empty($order_items_full)) {
            foreach($order_items_full as $index => $item) {
                if(empty($item->parent_id)) {
                    $order_items->push($item);
                }
            }
        }

        return $order_items;
    }
}