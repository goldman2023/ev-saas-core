<?php

namespace App\Traits;

use App\Enums\StatusEnum;
use Closure;

trait HasStatus
{
    public function scopePublished($query)
    {
        $query->where('status', StatusEnum::published()->value);
    }

    public function scopeDraft($query)
    {
        $query->where('status', StatusEnum::draft()->value);
    }

    public function scopePending($query)
    {
        $query->where('status', StatusEnum::pending()->value);
    }

    public function scopePrivate($query)
    {
        $query->where('status', StatusEnum::private()->value);
    }
}
