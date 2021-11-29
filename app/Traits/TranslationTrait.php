<?php

namespace App\Traits;


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
        // When model data is retrieved, populate model stock data!
        static::retrieved(function ($model) {
            if(!isset($model->translations)) {
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
        //$this->append(['brand_id']);
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
