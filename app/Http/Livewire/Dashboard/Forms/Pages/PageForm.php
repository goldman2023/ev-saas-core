<?php

namespace App\Http\Livewire\Dashboard\Forms\Pages;

use DB;
use FX;
use WE;
use File;
use Theme;
use Purifier;
use Categories;
use Permissions;
use App\Models\Page;
use App\Models\User;
use App\Facades\MyShop;
use App\Models\Address;
use Livewire\Component;
use App\Models\Category;
use App\Enums\StatusEnum;
use App\Enums\PageTypeEnum;
use App\Models\ShopAddress;
use Illuminate\Validation\Rule;
use App\Traits\Livewire\RulesSets;
use App\Enums\AmountPercentTypeEnum;
use App\Traits\Livewire\DispatchSupport;
use Spatie\ValidationRules\Rules\ModelsExist;

class PageForm extends Component
{
    use RulesSets;
    use DispatchSupport;

    public $page;
    public $available_templates;

    public $is_update;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function mount($page = null)
    {
        $this->page = empty($page) ? (new Page())->load(['uploads']) : $page;
        $this->is_update = isset($this->page->id) && ! empty($this->page->id);

        if (! $this->is_update) {
            // If insert
            $this->page->status = StatusEnum::draft()->value;
        }

        try {
            $page_templates = File::allFiles(Theme::path($path = '/views/frontend/page-templates'));
            $this->available_templates = collect($page_templates)->keyBy(fn($item) => str_replace(".blade.php", "", $item->getFilename()) )->map(fn($item) => str_replace(".blade.php", "", $item->getFilename()))->toArray();
        } catch(\Exception $e) {
            $this->available_templates = [];
        }

    }

    protected function rules()
    {
        $rules =  [
            'page.type' => [ 'required' ], //  Rule::in(PageTypeEnum::implodedValues())
            'page.template' => [''],
            'page.name' => 'required|min:2',
            'page.status' => [Rule::in(StatusEnum::toValues('archived'))],
            'page.content' => [''],
            'page.meta_title' => [''],
            'page.meta_description' => [''],
            'page.meta_img' => ['if_id_exists:App\Models\Upload,id,true'],
        ];

        if($this->is_update) {
            $rules['page.slug'] = 'required|unique:App\Models\Page,slug,'.$this->page->id;
        }

        return $rules;
    }

    protected function messages()
    {
        return [
            'page.type.required' => translate('Page type is required.')
        ];
    }

    public function dehydrate()
    {
        $this->dispatchBrowserEvent('init-form');
    }

    public function savePage()
    {
        try {
            $this->validate();
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->dispatchValidationErrors($e);
            $this->page->status = StatusEnum::draft()->value;
            $this->validate();
        }

        try {
            $this->page->save();

            $this->page->syncUploads();

            $this->inform(translate('Page saved successfully!'), '', 'success');
            // $this->emit('refreshPagesAndOpenNewPage', $this->page->id); //
        } catch (\Exception $e) {
            $this->inform(translate('There was an error while saving a page...Please try again.'), $e->getMessage(), 'fail');
        }
    }

    public function removePage()
    {
    //    $address = app($this->currentAddress::class)->find($this->currentAddress->id)->fill($this->currentAddress->toArray());
    //    $address->remove();
    }

    public function render()
    {
        return view('livewire.dashboard.forms.pages.page-form');
    }
}
