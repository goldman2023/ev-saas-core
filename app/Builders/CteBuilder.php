<?php

namespace App\Builders;

use App\Traits\Eloquent\Base\Builder\RetrievedRelationsEvent;
use Staudenmeir\LaravelAdjacencyList\Eloquent\Builder as CTEEloquentBuilder;

class CteBuilder extends CTEEloquentBuilder
{
    use RetrievedRelationsEvent;
}
