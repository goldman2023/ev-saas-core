<?php

namespace App\Support\Eloquent\Relations;

use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\Collection;

class AllFromModelRelation extends Relation
{
    protected $query;
    protected $model;
    protected $local_scopes;
    protected $return_real;

    public function __construct(mixed $model, $local_scopes = [], $return_real = false)
    {
        if(is_string($model)) {
            $model = app($model);
        }

        $this->model = $model;
        $this->local_scopes = $local_scopes;
        $this->return_real = $return_real;

        parent::__construct($model->query(), $model);
    }

    /**
     * Set the base constraints on the relation query.
     *
     * @return void
     */
    public function addConstraints() {
        if(!empty($this->local_scopes)) {
            foreach($this->local_scopes as $local_scope) {
                $this->query->{$local_scope}();
            }
        }
    }

    /**
     * Set the constraints for an eager load of the relation.
     *
     * @param array $models
     *
     * @return void
     */
    public function addEagerConstraints(array $models) { 

    }

    /**
     * Initialize the relation on a set of models.
     *
     * @param array $models
     * @param string $relation
     *
     * @return array
     */
    public function initRelation(array $models, $relation) { 

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
    public function match(array $models, Collection $results, $relation) { 

    }

    /**
     * Get the results of the relationship.
     * 
     * For calls: $model->{relation}

     * @return mixed
     */
    public function getResults() {
        if($this->return_real) {
            $all_model = app($this->model::class);
            $all_model->id = 0;
            
            return new Collection([
                $all_model
            ]);
        }

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
        if($this->return_real) {
            $all_model = app($this->model::class);
            $all_model->id = 0;
            
            return new Collection([
                $all_model
            ]);
        }

        return $this->query->get($columns);
    }
}