<?php

namespace App\Traits\Observers;

use App\Models\Attribute;
use App\Models\AttributeRelationship;
use App\Models\AttributeValue;
use App\Models\Product;
use AttributesService;
use Illuminate\Database\Eloquent\Collection;

trait AttributesManipulation
{    
    /**
     * removeModelCustomAttributes
     *
     * Invokes deleteCustomAttributes() method inside provided $model if exists
     * 
     * @param  mixed $model
     * @return void
     */
    public function removeModelCustomAttributes(&$model) { 
        if(method_exists($model, 'deleteCustomAttributes')) {
            $model->deleteCustomAttributes();
        }
    }
}
