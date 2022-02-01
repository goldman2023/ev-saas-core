<?php

namespace App\Http\Livewire\Dashboard\Forms\Categories;

use App\Facades\MyShop;
use App\Models\Address;
use App\Models\Category;
use App\Models\ShopAddress;
use App\Traits\Livewire\DispatchSupport;
use DB;
use EVS;
use Categories;
use Purifier;
use Spatie\ValidationRules\Rules\ModelsExist;
use Livewire\Component;
use App\Traits\Livewire\RulesSets;

class CategoryForm extends Component
{
    use RulesSets;
    use DispatchSupport;

    public $category;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function mount($category = null)
    {
        $this->category = empty($category) ? new Category() : $category;
    }

    protected function rules()
    {
        return [
            'category.*' => [],
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

    public function saveCategory() {
        $is_update = isset($this->category->id) && !empty($this->category->id);

        try {
            $this->validate();
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->dispatchValidationErrors($e);
            $this->validate();
        }

        DB::beginTransaction();

        try {
            // Update address
            if(empty($this->category->parent_id)) {
                $this->category->parent_id = null;
            }
            $this->category->level = \Categories::getCategoryLevel($this->category);
            $this->category->save();
            $this->category->syncUploads();

            DB::commit();

            Categories::clearCache(); // clear cache after category is added/updated

            if($is_update) {
                $this->toastify('Category successfully updated!', 'success');
            } else {
                $this->toastify('Category successfully created!', 'success');
            }
        } catch(\Exception $e) {
            DB::rollBack();

            if($is_update) {
                $this->dispatchGeneralError(translate('There was an error while updating a category...Please try again.'));
            } else {
                $this->dispatchGeneralError(translate('There was an error while creating a category...Please try again.'));
            }

        }
    }

    public function removeCategory() {
//        $address = app($this->currentAddress::class)->find($this->currentAddress->id)->fill($this->currentAddress->toArray());
//        $address->remove();
    }
}
