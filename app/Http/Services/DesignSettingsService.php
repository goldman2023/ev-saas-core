<?php

namespace App\Http\Services;

use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Brand;
use App\Models\Category;
use Illuminate\View\ComponentAttributeBag;

class DesignSettings
{


    public function getMappedProductCardDesigns() {
        return [
            'product-card' => 'Default',
            'product-card-detailed' => 'Detailed',
            'product-card-detailed2' => 'Detailed2',
        ];
    }


}
