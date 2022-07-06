<?php

namespace App\Traits\Eloquent\Base\Builder;

use App\Builders\CteBuilder;
use App\Models\WeBaseModel as Model;

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
        if (tenant()) {
            $models = parent::eagerLoadRelations($models);
        
            // Fire a custom event when all relations are retrieved
            foreach ($models as $model) {
                
                if ($model instanceof Model) {
                    $model->fireModelEvent('relationsRetrieved');
                }
            }
        } else {
            $models = [];
        }
        
        return $models;
    }
}
