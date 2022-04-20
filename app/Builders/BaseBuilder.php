<?php

namespace App\Builders;

use App\Events\Eloquent\ItemsQueried;
use App\Models\Category;
use App\Models\EVBaseModel as Model;
use App\Traits\Eloquent\Base\Builder\RetrievedRelationsEvent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Query\Builder as QueryBuilder;

class BaseBuilder extends Builder
{
    use RetrievedRelationsEvent;

    public function __construct(mixed $query)
    {
        parent::__construct($query);
    }
}
