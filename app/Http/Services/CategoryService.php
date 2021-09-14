<?php

namespace App\Http\Services;

use App\Models\Category;
use Cache;

class CategoryService
{
    public $app;
    public $categories;

    public function __construct($app) {
        $this->app = $app;

        $cache_key = tenant('id') . '_categories';
        $result = Cache::get($cache_key, null);
        $default = [];

        if (empty($categories)) {
            $categories = Category::select('id','parent_id', 'level', 'name', 'icon', 'slug')->get()->keyBy('name')->toArray();
            $result = $this->buildCategoriesTree($categories, 0);
            // Cache the categories if they are found in DB
            if (!empty($result)) {
                Cache::forget($cache_key);
                Cache::put($cache_key, $result);
            }
        }

        $this->categories = !empty($result) ? $result : $default;
    }

    public function getAll() {
        return $this->categories;
    }

    public function buildCategoriesTree($data, $pidKey, $idKey = "parent_id",) {
        
        $tree = function ($elements, $parentId = -1) use (&$tree, $pidKey, $idKey) {
            if($parentId < 0) $parentId = $pidKey;
            $branch = array();
            foreach ($elements as $element) {
    
                if ($element[$idKey] == $parentId) {
    
                    $children = $tree($elements, $element['id']);
                    if ($children) {
                        $element['children'] = $children;
                    }  else {
                        $element['children'] = [];
                    }
                    $branch[] = $element;
                }
    
            }
            return $branch;
        };
    
        $tree = $tree($data);
        return $tree;
    }

}