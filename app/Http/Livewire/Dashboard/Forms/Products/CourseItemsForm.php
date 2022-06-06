<?php

namespace App\Http\Livewire\Dashboard\Forms\Products;

use App\Enums\CourseItemTypes;
use App\Enums\StatusEnum;
use App\Models\CoreMeta;
use App\Models\Product;
use App\Models\CourseItem;
use App\Traits\Livewire\CanDelete;
use App\Traits\Livewire\DispatchSupport;
use App\Traits\Livewire\HasCategories;
use App\Traits\Livewire\RulesSets;
use App\Traits\Livewire\HasCoreMeta;
use App\Traits\Livewire\HasAttributes;
use Categories;
use DB;
use EVS;
use FX;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;
use Livewire\Component;
use MyShop;
use Purifier;
use Spatie\ValidationRules\Rules\ModelsExist;
use Str;
use Spatie\Activitylog\Facades\CauserResolver;

class CourseItemsForm extends Component
{
    use DispatchSupport;
    use RulesSets;
    use HasCategories;
    use CanDelete;
    use HasCoreMeta;
    use HasAttributes;

    public $product;
    public $course_items;
    public $current_item;

    protected $listeners = ['refreshCourseItemsForm' => '$refresh'];
    
    protected function rules()
    {
        return [
            'current_item' => 'exclude',
            'current_item.id' => 'nullable',
            'current_item.thumbnail' => ['if_id_exists:App\Models\Upload,id,true'],
            'current_item.cover' => ['if_id_exists:App\Models\Upload,id,true'],
            'current_item.gallery' => [], // 'if_id_exists:App\Models\Upload,id,true'
            'current_item.parent_id' => 'nullable',
            'current_item.type' => ['required', Rule::in(CourseItemTypes::toValues())],
            'current_item.free' => 'boolean',
            'current_item.name' => 'required',
            'current_item.excerpt' => 'nullable',
            'current_item.content' => 'nullable',
            'current_item.order' => 'nullable',
            'current_item.accessible_after' => 'nullable',
            'current_item.meta_title' => 'nullable',
            'current_item.meta_description' => 'nullable',
        ];
    }

    protected function messages()
    {
        return [
            'current_item.thumbnail.if_id_exists' => translate('Please select a valid thumbnail image from the media library'),
            'current_item.cover.if_id_exists' => translate('Please select a valid cover image from the media library'),
            'current_item.pdf.if_id_exists' => translate('Please select a valid specification document from the media library'),
            'current_item.name.required' => translate('Course item name is required'),
        ];
    }

    public function mount($product)
    {
        $this->product = $product;
        $this->course_items = $this->product->course_items->toTree()->filter(fn($item) => $item->parent_id === null);

        $this->addCourseItem();
    }

    public function saveCourseItem() {
        try {
            $this->validate();
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->dispatchValidationErrors($e);
            $this->validate();
        }

        DB::beginTransaction();

        if(is_array($this->current_item)) {
            $item = !empty($this->current_item['id'] ?? null) ? CourseItem::find($this->current_item['id']) : new CourseItem();
            $item->forceFill($this->current_item);
            $this->current_item = $item;
        }

        try {
            if (empty($this->current_item->parent_id)) {
                $this->current_item->parent_id = null;
            }
            
            $this->current_item->product_id = $this->product->id;
            $this->current_item->save();
            // $this->current_item->syncUploads();

            DB::commit();

            $this->inform('Course item successfully saved!', '', 'success');

            $this->emit('refreshCourseItemsForm');
            // $this->refreshCourseItems();
        } catch (\Exception $e) {
            DB::rollBack();

            $this->dispatchGeneralError(translate('There was an error while saving a course item...Please try again.'));
            $this->inform('There was an error while saving a course item...Please try again.', $e->getMessage(), 'fail');
        }
    }

    protected function refreshCourseItems() {
        $this->course_items = $this->product->course_items()->toTree()->filter(fn($item) => $item->parent_id === null);
    }

    public function addCourseItem() {
        $this->current_item = new CourseItem();
        $this->current_item->product_id = $this->product->id;
        $this->current_item->type = 'wysiwyg';
        $this->current_item->free = false;
        $this->current_item->order = 0;
    }

    public function selectCourseItem($course_item_id) {
        $this->current_item = CourseItem::find($course_item_id);
    }

    public function dehydrate()
    {
        $this->dispatchBrowserEvent('init-form');
    }

    public function render()
    {
        return view('livewire.dashboard.forms.products.course-items-form');
    }
}