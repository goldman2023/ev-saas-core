<?php

namespace App\Traits\Livewire;

use Categories;

trait HasCategories
{
    public $categories;

    public $selected_categories;

    public function initCategories(&$model = null)
    {
        $this->categories = Categories::getAll();

        if (! empty($model)) {
            $this->selected_categories = $model->selected_categories('slug_path');
        } else {
            $this->selected_categories = collect([]);
        }
    }

    protected function setCategories(&$model = null)
    {
        if (! empty($this->selected_categories) && ! empty($model)) {
            $categories_idx = collect([]);

            foreach ($this->selected_categories as $selected) {
                // $selected is a slug_path of the category
                $cat = Categories::getBySlugPath($selected);

                if ($cat) {
                    $categories_idx->push($cat['id']);
                }
            }

            $model->categories()->sync($categories_idx->toArray());
        } else {
            $model->categories()->sync([]); // remove all categories relations!
        }
    }

    public function levelSelectedCategories()
    {
        $data = [];

        if ($this->selected_categories) {
            foreach ($this->selected_categories as $selected) {
                $level = count(explode('.', $selected)) - 1;
                if (! isset($data[$level])) {
                    $data[$level] = [];
                }

                $data[$level][] = $selected;
            }
        }

        return $data;
    }
}
