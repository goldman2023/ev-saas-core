<?php

namespace App\Support\Eloquent\Relations;

use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\Collection;

class EmptyRelation extends Relation
{
    protected $query;

    public function __construct(mixed $model)
    {
        parent::__construct($model->query(), $model);
    }

    /**
     * Set the base constraints on the relation query.
     *
     * @return void
     */
    public function addConstraints() {
        
    }

    /**
     * Set the constraints for an eager load of the relation.
     *
     * @param array $models
     *
     * @return void
     */
    public function addEagerConstraints(?array $models) { 

    }

    /**
     * Initialize the relation on a set of models.
     *
     * @param array $models
     * @param string $relation
     *
     * @return array
     */
    public function initRelation(?array $models, $relation) {
        if(!empty($models)) {
            foreach ($models as $model) {
                $model->setRelation(
                    $relation, 
                    $this->related->newCollection()
                );
            }
        }

        return $models;
    }

    /**
     * Match the eagerly loaded results to their parents.
     *
     * @param array $models
     * @param \Illuminate\Database\Eloquent\Collection $results
     * @param string $relation
     *
     * @return array
     */
    public function match(?array $models, Collection $results, $relation) { 
        return $models;
    }

    /**
     * Get the results of the relationship.
     * 
     * For calls: $model->{relation}

     * @return mixed
     */
    public function getResults() {
        return new Collection();
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
        return new Collection();
    }
}