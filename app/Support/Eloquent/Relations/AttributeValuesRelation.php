<?php

namespace App\Support\Eloquent\Relations;

use App\Models\WeBaseModel;
use App\Models\AttributeValue;
use App\Models\AttributeRelationship;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\Relation;

class AttributeValuesRelation extends Relation
{
    protected $query;
    protected $model;
    protected $parent;

    public function __construct($model, $hasMany = null, $hasManyThrough = null)
    {
        if($model->is_predefined) {
            $relation = $model->hasMany(AttributeValue::class, 'attribute_id', 'id')
                ->orderByRaw("CASE WHEN ordering = 0 THEN 0 ELSE 1 END DESC") // If ordering is 0, then put it after all other...
                ->orderBy('ordering', 'ASC');
        } else {
            $relation = $model->hasManyThrough(AttributeValue::class, AttributeRelationship::class, 'attribute_id', 'id', 'id', 'attribute_value_id');
        }

        $this->query = $relation->getQuery();

        parent::__construct($this->query, $model);
    }

    public function addConstraints()
    {

    }

    public function addEagerConstraints(array $attributes)
    {
        // Set eager constraints to query just attribute_values for specific $attributes, not all!
        $this->query
            ->whereIn(
                'attribute_values.attribute_id', 
                collect($attributes)->pluck('id')
            );
        // dd($this->query);
    }

    public function initRelation(array $attributes, $relation)
    {
        foreach ($attributes as $attribute) {
            $attribute->setRelation(
                $relation, 
                $this->related->newCollection()
            );
        }

        return $attributes;
    }

    public function match(array $attributes, Collection $attribute_values, $relation)
    {
        if ($attribute_values->isEmpty()) {
            return $attributes;
        }
        dd($attribute_values);

        foreach ($attributes as $attribute) {
            $attribute->setRelation(
                $relation, 
                $attribute_values->filter(function (AttributeValue $attribute_value) use ($attribute) {
                    return $attribute_value->attribute_id === $attribute->id;
                })
            );    
        }

        return $attributes;
    }

    /**
     * Get the results of the relationship.
     * 
     * For calls: $model->{relation}

     * @return mixed
     */
    public function getResults() {
        return $this->query->get();
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
        return $this->query->get($columns);
    }
}