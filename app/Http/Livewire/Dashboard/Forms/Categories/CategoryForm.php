<?php

namespace App\Http\Livewire\Dashboard\Forms\Categories;

use App\Facades\MyShop;
use App\Models\Address;
use App\Models\Category;
use App\Models\ShopAddress;
use App\Traits\Livewire\DispatchSupport;
use App\Traits\Livewire\RulesSets;
use Categories;
use DB;
use EVS;
use Livewire\Component;
use Purifier;
use Spatie\ValidationRules\Rules\ModelsExist;

class CategoryForm extends Component
{
    use RulesSets;
    use DispatchSupport;

    public $category;
    public $is_update;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function mount($category = null)
    {
        $this->category = empty($category) ? (new Category())->load(['uploads']) : $category;

        $this->is_update = isset($this->category->id) && ! empty($this->category->id);

    }

    protected function rules()
    {
        return [
            'category.id' => [],
            'category.featured' => [],
            'category.meta_title' => [],
            'category.meta_description' => [],
            'category.name' => 'required',
            'category.description' => [],
            'category.thumbnail' => ['if_id_exists:App\Models\Upload,id,true'],
            'category.cover' => ['if_id_exists:App\Models\Upload,id,true'],
            'category.icon' => ['if_id_exists:App\Models\Upload,id,true'],
            'category.meta_img' => ['if_id_exists:App\Models\Upload,id,true'],
            'category.parent_id' => ['if_id_exists:App\Models\Category,id,true'],
        ];
    }

    protected function messages()
    {
        return [
            'category.thumbnail.if_id_exists' => translate('Selected thumbnail does not exist in Media Library. Please select again.'),
            'category.cover.if_id_exists' => translate('Selected cover does not exist in Media Library. Please select again.'),
            'category.icon.if_id_exists' => translate('Selected icon does not exist in Media Library. Please select again.'),
            'category.parent_id.if_id_exists' => translate('Selected parent category does not exist. Please select again.'),
            'category.meta_img.if_id_exists' => translate('Selected meta image does not exist in Media Library. Please select again.'),
            'category.name.required' => translate('Category name is required'),
            'category.name.min' => translate('Minimum category name length is :min'),
        ];
    }

    public function dehydrate()
    {
        $this->dispatchBrowserEvent('initCategoryForm');
    }

//    public function updatingCategory(&$category) {
    ////        if(!($category instanceof Category) && is_array($category)) {
    ////            $category = (new Category())->forceFill($category);
    ////        }
//    }

    public function render()
    {
        return view('livewire.dashboard.forms.categories.category-form');
    }

    public function saveCategory()
    {

        try {
            $this->validate();
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->dispatchValidationErrors($e);
            $this->validate();
        }

        DB::beginTransaction();

        try {
            if (empty($this->category->parent_id)) {
                $this->category->parent_id = null;
            }
            $this->category->level = \Categories::getCategoryLevel($this->category);
            if (empty($this->category->featured)) {
                $this->category->featured = false;
            }
            $this->category->save();
            $this->category->syncUploads();

            DB::commit();

            Categories::clearCache(); // clear cache after category is added/updated

            if ($this->is_update) {
                $this->inform('Category successfully updated!', '', 'success');
            } else {
                $this->inform('Category successfully created!', '', 'success');
            }
        } catch (\Exception $e) {
            DB::rollBack();

            if ($this->is_update) {
                $this->dispatchGeneralError(translate('There was an error while updating a category...Please try again.'));
                $this->inform('There was an error while updating a category...Please try again.', '', 'fail');
            } else {
                $this->dispatchGeneralError(translate('There was an error while creating a category...Please try again.'));
                $this->inform('There was an error while creating a category...Please try again.', '', 'fail');
            }
        }
    }

    public function removeCategory()
    {
        DB::beginTransaction();

        try {
            $this->category->delete();

            DB::commit();

            $this->inform(translate('Category successfully deleted!'), '', 'success');
        } catch (\Exception $e) {
            $this->dispatchGeneralError(translate('There was an error while trying to remove category and it\'s relationships: ').$e->getMessage());
            $this->inform(translate('There was an error while trying to remove category and it\'s relationships: '), $e->getMessage(), 'danger');
        }
    }
}
