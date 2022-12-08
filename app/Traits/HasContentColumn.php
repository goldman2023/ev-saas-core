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
    public static function getContentColumnName()
    {
        return 'content';
    }

    // This function can be overriden with corresponding json column name depending on model's table structure
    public static function getContentStructureCoreMetaName()
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
        $this->fillable = array_values(array_unique(
            array_merge($this->fillable, [
                self::getContentColumnName()
            ])
        ));
    }

    /**
     * Boot the trait
     *
     * @return void
     */
    public function bootHasDataColumn(): void
    {
        static::retrieved(function($model) {
            $model->fillable = array_values(array_unique(
                array_merge($model->fillable, [
                    self::getContentColumnName()
                ])
            ));

            dd($model->fillable);
        });
    }

    /*
     * Get content_structure core meta
     */
    public function getContentStructure() {
        return $this->getCoreMeta(self::getContentStructureCoreMetaName());
    }

    /*
     * Set content_structure core meta
     */
    public function setContentStructure($value = null, $default = null) {
        $this->saveCoreMeta(self::getContentStructureCoreMetaName(), empty($value) ? $default : $value);
    }
}
