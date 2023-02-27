<?php

namespace App\Support\Eloquent\Relations;

use App\Models\Attribute;
use App\Models\WeBaseModel;
use App\Models\AttributeValue;
use App\Models\AttributeRelationship;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\Relation;

class CustomAttributesRelation extends Relation
{
    protected $query;
    protected $model;
    protected $parent;

    protected $attributes_cols = [
        'attributes.id as attributes.id', 
        'attributes.name as attributes.name',
        'attributes.slug as attributes.slug',
        'attributes.type as attributes.type',
        'attributes.content_type as attributes.content_type',
        'attributes.filterable as attributes.filterable',
        'attributes.group as attributes.group',
        'attributes.is_schema as attributes.is_schema',
        'attributes.schema_key as attributes.schema_key',
        'attributes.schema_value as attributes.schema_value',
        'attributes.custom_properties as attributes.custom_properties',
        'attributes.created_at as attributes.created_at',
        'attributes.updated_at as attributes.updated_at',
    ];

    protected $attribute_relationships_cols = [
        'attribute_relationships.id as attribute_relationships.id', 
        'attribute_relationships.subject_type as attribute_relationships.subject_type', 
        'attribute_relationships.subject_id as attribute_relationships.subject_id', 
        'attribute_relationships.attribute_id as attribute_relationships.attribute_id', 
        'attribute_relationships.attribute_value_id as attribute_relationships.attribute_value_id', 
        'attribute_relationships.for_variations as attribute_relationships.for_variations', 
        'attribute_relationships.order as attribute_relationships.order', 
        // 'attribute_relationships.created_at as attribute_relationships.created_at', 
        // 'attribute_relationships.updated_at as attribute_relationships.updated_at', 
    ];

    protected $attribute_values_cols = [
        'attribute_values.id as attribute_values.id', 
        'attribute_values.attribute_id as attribute_values.attribute_id', 
        'attribute_values.values as attribute_values.values', 
        'attribute_values.ordering as attribute_values.ordering', 
        // 'attribute_values.created_at as attribute_values.created_at', 
        // 'attribute_values.updated_at as attribute_values.updated_at', 
    ];

    public function __construct($model)
    {
        $this->model = $model;

        parent::__construct(Attribute::query(), $model);
    }

    public function addConstraints()
    {
        $this->query
            ->join('attribute_relationships', function (JoinClause $join) {
                $join->on('attribute_relationships.attribute_id', '=', 'attributes.id')
                    ->where([
                        ['subject_type', '=', $this->model::class],
                        ['subject_id', '=', $this->model->id],
                    ]);
            })
            ->join('attribute_values', function (JoinClause $join) {
                $join->on('attribute_values.id', '=', 'attribute_relationships.attribute_value_id');
            })
            ->where('attributes.content_type', $this->model::class)
            ->select($this->getSelectFields());
    }

    public function addEagerConstraints(array $attributes)
    {
        // Set eager constraints to query just attribute_values for specific $attributes, not all!
        // $this->query
        //     ->where([
        //         ['subject_type', '=', $this->model::class],
        //         ['subject_id', '=', $this->model->id],
        //     ])
        //     ->whereIn(
        //         'attribute_relationships.attribute_id', 
        //         collect($attributes)->pluck('id')
        //     );
        // dd($this->query);
    }

    public function initRelation(array $models, $relation)
    {
        foreach ($models as $model) {
            $model->setRelation(
                $relation, 
                $this->related->newCollection()
            );
        }

        return $models;
    }

    public function match(array $attributes, Collection $attribute_values, $relation)
    {
        // if ($attribute_values->isEmpty()) {
        //     return $attributes;
        // }
        // // dd($attribute_values);

        // foreach ($attributes as $attribute) {
        //     $attribute->setRelation(
        //         $relation, 
        //         $attribute_values->filter(function (AttributeValue $attribute_value) use ($attribute) {
        //             return $attribute_value->attribute_id === $attribute->id;
        //         })
        //     );    
        // }

        return $attributes;
    }

    /**
     * Get the results of the relationship.
     * 
     * For calls: $model->{relation}

     * @return mixed
     */
    public function getResults() {
        return $this->get();
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
        $data = $this->query->getQuery()->get();
        $attributes = new Collection();
        
        if(!empty($data)) {

            foreach($data as $index => $attribute_object) {
                $att_rel = (new AttributeRelationship())->forceFill([
                    'id' => $attribute_object->{'attribute_relationships.id'},
                    'subject_type' => $attribute_object->{'attribute_relationships.subject_type'},
                    'subject_id' => $attribute_object->{'attribute_relationships.subject_id'},
                    'attribute_id' => $attribute_object->{'attribute_relationships.attribute_id'},
                    'attribute_value_id' => $attribute_object->{'attribute_relationships.attribute_value_id'},
                    'for_variations' => $attribute_object->{'attribute_relationships.for_variations'},
                    'order' => $attribute_object->{'attribute_relationships.order'},
                ]);

                $att_val = (new AttributeValue())->forceFill([
                    'id' => $attribute_object->{'attribute_values.id'},
                    'attribute_id' => $attribute_object->{'attribute_values.attribute_id'},
                    'values' => $attribute_object->{'attribute_values.values'},
                    'ordering' => $attribute_object->{'attribute_values.ordering'},
                ]);

                if(!empty($att = $attributes->firstWhere('id', $attribute_object->{'attributes.id'}))) {
                    $att->setRelation(
                        'attribute_relationships', 
                        $att->attribute_relationships->concat([$att_rel])
                    );

                    $att->setRelation(
                        'attribute_values', 
                        $att->attribute_values->concat([$att_val])
                    );
                } else {
                    $att = (new Attribute())->forceFill([
                        'id' => $attribute_object->{'attributes.id'},
                        'name' =>  $attribute_object->{'attributes.name'} ?? null,
                        'slug' =>  $attribute_object->{'attributes.slug'} ?? null,
                        'type' =>  $attribute_object->{'attributes.type'} ?? null,
                        'content_type' =>  $attribute_object->{'attributes.content_type'} ?? null,
                        'filterable' =>  $attribute_object->{'attributes.filterable'} ?? null,
                        'group' =>  $attribute_object->{'attributes.group'} ?? null,
                        'is_schema' =>  $attribute_object->{'attributes.is_schema'} ?? null,
                        'schema_key' =>  $attribute_object->{'attributes.schema_key'} ?? null,
                        'schema_value' =>  $attribute_object->{'attributes.schema_value'} ?? null,
                        'custom_properties' =>  json_decode($attribute_object->{'attributes.custom_properties'} ?? '', true),
                        'created_at' =>  $attribute_object->{'attributes.created_at'} ?? null,
                        'updated_at' =>  $attribute_object->{'attributes.updated_at'} ?? null,
                    ]);

                    $att->setRelation(
                        'attribute_relationships', 
                        new Collection([$att_rel])
                    );

                    $att->setRelation(
                        'attribute_values', 
                        new Collection([$att_val])
                    );

                    $attributes->push($att);
                }
            }
        }

        return $attributes;
    }

    protected function getSelectFields() {
        return array_merge($this->attributes_cols, $this->attribute_relationships_cols, $this->attribute_values_cols);
    }
}