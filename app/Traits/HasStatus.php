<?php

namespace App\Traits;

use Closure;
use App\Enums\StatusEnum;

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