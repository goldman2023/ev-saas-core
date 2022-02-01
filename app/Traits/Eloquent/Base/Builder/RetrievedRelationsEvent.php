<?php

namespace App\Traits\Eloquent\Base\Builder;

use App\Builders\CteBuilder;
use App\Models\EVBaseModel as Model;

trait RetrievedRelationsEvent
{
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

//        ItemsQueried::dispatch(new Collection($models));

        return $models;
    }
}
