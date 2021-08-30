<?php

namespace App\Forms\Products;

use App\Models\Category;

class ProductForm extends \Laraform
{
    public $model = \App\Models\Product::class;

    /**
     * This is the name of the vue component used to render the form.
     * In order for this to work, component has to be registered/included in themes/{theme}/js/vue.js
     *
     * @var string
     */
    public $component = 'product-form';

    public function schema() {
        // TODO: For multi-language support, implement: https://laraform.io/docs/1.x/basics/internationalization
        return [
            'general_information_title' => [
                'type' => 'meta',
                'defaultValue' => translate('General Information')
            ],
            'name' => [
                'type' => 'text',
                'label' => translate('Product Name'),
                'placeholder' => translate('Product Name'),
                'rules' => ''
            ],
            'category_id' => [
                'type' => 'select',
                'label' => translate('Category'),
                'search' => true,
                'native' => false,
                'items' => $this->getAvailableCategories()
            ],
            'brand_id' => [
                'type' => 'select',
                'label' => translate('Brand'),
                'search' => true,
                'native' => false,
                'items' => $this->getAvailableBrands()
            ],
            'tags' => [
                'type' => 'tags',
                'label' => translate('Tags'),
                'native' => false,
                'create' => true,
                'items' => []
            ],
            'unit' => [
                'type' => 'select',
                'label' => translate('Unit (e.g. kg, pc, l, oz...)'),
                'search' => true,
                'native' => false,
                'items' => $this->getAvailableUnits()
            ],
        ];
    }

    public function buttons() {
        return [[
            'label' => 'Submit'
        ]];
    }

    public function getAvailableCategories() {
        $categories = Category::where('parent_id', 0)
            ->where('digital', 0)
            ->with('childrenCategories')
            ->get();

        $mapped = [];

        $recursion = function($child_category) use (&$recursion, &$mapped) {
            $value = str_repeat('--', $child_category->level);

            $mapped[$child_category->id] = $value." ".$child_category->getTranslation('name');

            if($child_category->categories) {
                foreach ($child_category->categories as $childCategory) {
                    $recursion($childCategory);
                }
            }
        };

        if($categories->isNotEmpty()) {
            foreach($categories as $category) {
                $mapped[$category->id] = $category->getTranslation('name');

                if($category->childrenCategories) {
                    foreach($category->childrenCategories as $childCategory) {
                        $recursion($childCategory);
                    }
                }
            }
        }

        return $mapped;
    }

    public function getAvailableBrands() {
        $brands = \App\Models\Brand::all();
        $mapped = [];

        if($brands->isNotEmpty()) {
            foreach (\App\Models\Brand::all() as $brand) {
                $mapped[$brand->id] = $brand->getTranslation('name');
            }
        }

        return $mapped;
    }

    public function getAvailableUnits() {
        return [
            'pc' => 'Pc',
            'kg' => 'kg',
            'l' => 'litre',
            'oz' => 'oz'
        ];
    }
}
