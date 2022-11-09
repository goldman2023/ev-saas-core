<?php

namespace App\Traits;

use Route;

trait TemporaryTrait
{
    /**
     * Initialize the trait
     *
     * @return void
     */
    public function initializeTemporaryTrait(): void
    {
        $this->casts = array_unique(
            array_merge($this->casts, [
                'is_temp' => 'boolean',
            ])
        );
    }

    public function isTemp()
    {
        return $this->is_temp === true;
    }
}
