<?php

namespace App\Builders;

use App\Events\Eloquent\ItemsQueried;
use App\Models\Category;
use App\Traits\Eloquent\Base\Builder\RetrievedRelationsEvent;
use App\Traits\Eloquent\Base\Builder\EagerLoadPivotRelations;
use Illuminate\Database\Eloquent\Builder;
use App\Models\WeBaseModel as Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Query\Builder as QueryBuilder;

class BaseBuilder extends Builder
{
    use RetrievedRelationsEvent;
    use EagerLoadPivotRelations;

    public function __construct(mixed $query)
    {
        parent::__construct($query);
    }
}
