<?php

namespace App\Builders;

use Illuminate\Database\Eloquent\Builder;
use App\Models\EVBaseModel as Model;
use Illuminate\Database\Query\Builder as QueryBuilder;

class BaseBuilder extends Builder
{
    public function __construct(QueryBuilder $query)
    {
        parent::__construct($query);
    }

    /**
     * Eager load the relationships for the models.
     *
     * @param  array  $models
     * @return array
     */
    public function eagerLoadRelations(array $models)
    {
        $models = parent::eagerLoadRelations($models);

        // Fire a custom event when all relations are retrieved
        foreach ($models as $model) {
            if ($model instanceof Model) {
                $model->fireModelEvent('relationsRetrieved');
            }
        }

        return $models;
    }
}
