<?php

namespace App\Http\Livewire\Dashboard\Forms\Pages;

use App\Enums\AmountPercentTypeEnum;
use App\Enums\StatusEnum;
use App\Facades\MyShop;
use App\Models\Address;
use App\Models\Category;
use App\Models\Page;
use App\Models\ShopAddress;
use App\Models\User;
use App\Traits\Livewire\DispatchSupport;
use App\Traits\Livewire\RulesSets;
use Categories;
use DB;
use EVS;
use FX;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Permissions;
use Purifier;
use Spatie\ValidationRules\Rules\ModelsExist;

class PageForm extends Component
{
    use RulesSets;
    use DispatchSupport;

    public $page;

    public $is_update;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function mount($page = null)
    {
        $this->page = empty($page) ? new Page() : $page;
        $this->is_update = isset($this->page->id) && ! empty($this->page->id);

        if (! $this->is_update) {
            // If insert
            $this->page->status = StatusEnum::draft()->value;
        }
    }

    protected function rules()
    {
        return [
            'page.name' => 'required|min:2',
            'page.status' => [Rule::in(StatusEnum::toValues('archived'))],
            'page.meta_title' => [''],
            'page.meta_img' => ['if_id_exists:App\Models\Upload,id,true'],
        ];
    }

    protected function messages()
    {
        return [];
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

            $this->inform(translate('Page saved successfully!'), '', 'success');

            $this->emit('refreshPagesAndOpenNewPage', $this->page->id); //
        } catch (\Exception $e) {
            $this->inform(translate('There was an error while saving a page...Please try again.'), $e->getMessage(), 'fail');
        }
    }

    public function removePage()
    {
//        $address = app($this->currentAddress::class)->find($this->currentAddress->id)->fill($this->currentAddress->toArray());
//        $address->remove();
    }

    public function render()
    {
        return view('livewire.dashboard.forms.pages.page-form');
    }
}
