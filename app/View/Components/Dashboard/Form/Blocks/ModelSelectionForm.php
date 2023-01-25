<?php

namespace App\View\Components\Dashboard\Form\Blocks;

use Illuminate\View\Component;

class ModelSelectionForm extends Component
{
    public $field;
    public $apiRoute;
    public $defaultModel;
    public $modelClass;
    public $modelWithRelations;
    public $modelTitleProperty;
    public $modelSubtitleProperty;
    public $modalId;
    public $fieldTitle;
    public $modalTitle;
    public $emptySelectedItemTitle;
    public $emptySelectedItemSubtitle;
    public $itemTitlePrefix;
    public $itemTitleSuffix;
    public $itemSubtitlePrefix;
    public $itemSubtitleSuffix;
    public $defaultResults;
    public $customSelectLogic;
    public $customDeselectLogic;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        $modalId = '', 
        $defaultModel = null,
        $modelClass = '',
        $modelWithRelations = [],
        $modelTitleProperty = 'name', // this property of model will be used as Title
        $modelSubtitleProperty = 'slug', // this property of model will be used as Subtitle
        $field = null,
        $apiRoute = '',
        $fieldTitle = '', 
        $modalTitle = '', 
        $emptySelectedItemTitle = '', 
        $emptySelectedItemSubtitle = '',
        $itemTitlePrefix = '',
        $itemTitleSuffix = '',
        $itemSubtitlePrefix = '',
        $itemSubtitleSuffix = '',
        $defaultResults = [],
        $customSelectLogic = '',
        $customDeselectLogic = '',
    )
    {
        $this->field = $field;
        $this->apiRoute = $apiRoute;
        $this->modalId = $modalId;
        $this->defaultModel = $defaultModel;
        $this->modelClass = $modelClass;
        $this->modelWithRelations = $modelWithRelations;
        $this->modelTitleProperty = $modelTitleProperty;
        $this->modelSubtitleProperty = $modelSubtitleProperty;
        $this->fieldTitle = $fieldTitle;
        $this->modalTitle = $modalTitle;
        $this->emptySelectedItemTitle = $emptySelectedItemTitle;
        $this->emptySelectedItemSubtitle = $emptySelectedItemSubtitle;
        $this->itemTitlePrefix = $itemTitlePrefix;
        $this->itemTitleSuffix = $itemTitleSuffix;
        $this->itemSubtitlePrefix = $itemSubtitlePrefix;
        $this->itemSubtitleSuffix = $itemSubtitleSuffix;
        $this->customSelectLogic = $customSelectLogic;
        $this->customDeselectLogic = $customDeselectLogic;

        // Define modelClass
        if(!empty($this->defaultModel)) {
            $this->modelClass = $this->defaultModel::class;
        } else {
            $this->modelClass = $modelClass;
        }
        
        // Fetch Default results
        $this->defaultResults = $defaultResults;
        if(!empty($this->modelClass)) {
            $this->defaultResults = app($this->modelClass);

            if(!empty($this->modelWithRelations)) {
                $this->defaultResults = $this->defaultResults->with($this->modelWithRelations);
            }

            $this->defaultResults = $this->defaultResults->search('')->limit(5)->get()->toArray();
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.dashboard.form.blocks.model-selection-form');
    }

    public function constructTitle($item = null, $prefix = '', $suffix = '') {
        if(empty($item)) $item = $this->defaultModel;
        if(empty($prefix)) $prefix = $this->itemTitlePrefix;
        if(empty($suffix)) $suffix = $this->itemTitleSuffix;

        if(!empty($item)) {
            if(is_array($this->modelTitleProperty) && !empty($this->modelTitleProperty)) {
                return $prefix.array_reduce($this->modelTitleProperty, fn($carry, $prop) => $carry . $item->{$prop} . ' ', '').$suffix;
            } else if(!empty($this->modelTitleProperty) && !empty($item->{$this->modelTitleProperty} ?? null)) {
                return $prefix.$item->{$this->modelTitleProperty}.$suffix;
            }
        }

        return $this->emptySelectedItemTitle;
    }

    public function constructSubtitle($item = null, $prefix = '', $suffix = '') {
        if(empty($item)) $item = $this->defaultModel;
        if(empty($prefix)) $prefix = $this->itemSubtitlePrefix;
        if(empty($suffix)) $suffix = $this->itemSubtitleSuffix;

        if(!empty($item)) {
            if(is_array($this->modelSubtitleProperty) && !empty($this->modelSubtitleProperty)) {
                return $prefix.array_reduce($this->modelSubtitleProperty, fn($carry, $prop) => $carry . $item->{$prop} . ' ', '').$suffix;
            } else if(!empty($this->modelSubtitleProperty) && !empty($item->{$this->modelSubtitleProperty} ?? null)) {
                return $prefix.$item->{$this->modelSubtitleProperty}.$suffix;
            }
        }
        
        return $this->emptySelectedItemSubtitle;
    }
}
