<?php

namespace App\Traits;

use App\Enums\StatusEnum;
use App\Support\Eloquent\Casts\JsonData;
use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Closure;

trait HasContentColumn
{
    // This function can be overriden with corresponding json column name depending on model's table structure
    public function getContentColumnName()
    {
        return 'content';
    }

    // This function can be overriden with corresponding json column name depending on model's table structure
    public function getContentStructureCoreMetaName()
    {
        return 'content_structure';
    }

    /**
     * Initialize the trait
     *
     * @return void
     */
    public function initializeHasDataColumn(): void
    {
        $this->fillable = array_unique(
            array_merge($this->fillable, [
                $this->getContentColumnName()
            ])
        );
    }

    /*
     * Get content_structure core meta
     */
    public function getContentStructure() {
        return $this->getCoreMeta($this->getContentStructureCoreMetaName());
    }

    /*
     * Set content_structure core meta
     */
    public function setContentStructure($value = null, $default = null) {
        $this->saveCoreMeta($this->getContentStructureCoreMetaName(), empty($value) ? $default : $value);
    }
}
