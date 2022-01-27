<?php

namespace App\Traits;


use App\Builders\BaseBuilder;
use App\Models\Brand;
use App\Models\ProductTranslation;
use App\Models\ProductVariation;

trait TranslationTrait
{
    /************************************
     * Abstract Trait Methods *
     ************************************/
    abstract public function getTranslationModel(): ?string;

    /**
     * Boot the trait
     *
     * @return void
     */
    protected static function bootTranslationTrait()
    {
        static::addGlobalScope('withTranslations', function (mixed $builder) {
            // Eager Load Translations
            $builder->with(['translations']);
        });

        // When model data is retrieved, populate model stock data!
        static::relationsRetrieved(function ($model) {
            if(!$model->relationLoaded('translations')) {
                $model->load('translations');
            }
        });
    }

    /**
     * Initialize the trait
     *
     * @return void
     */
    public function initializeTranslationTrait(): void
    {

    }


    /************************************
     * Translations Relation Functions *
     ************************************/
    public function translations() {
        return $this->hasMany($this->getTranslationModel());
    }

    /************************************
     * Other Translations Functions *
     ************************************/
    public function getTranslation($field = '', $lang = false) {
        $lang = ($lang === false) ? \App::getLocale() : $lang;

        $translation = $this->translations->firstWhere('lang', $lang);

        return !empty($translation) ? ($translation->{$field} ?? '') : ($this->{$field} ?? '');
    }
}
