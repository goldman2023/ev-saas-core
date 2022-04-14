<?php

namespace App\Http\Livewire\WeEdit\Forms;

use App\Enums\StatusEnum;
use Livewire\Component;
use App\Traits\Livewire\DispatchSupport;
use App\Enums\WeEditLayoutEnum;
use App\Models\PagePreview;
use App\Models\Page;
use Illuminate\Validation\Rule;
use Symfony\Component\DomCrawler\Crawler;
use Illuminate\Container\Container;
use Illuminate\Support\Str;
use Illuminate\View\Compilers\ComponentTagCompiler;
use Masterminds\HTML5;

class PageForm extends Component
{
    use DispatchSupport;

    public $page;

    protected $listeners = [
        
    ];

    public function mount()
    {
        $this->page = Page::first();
    }

    public function rules() {
        return [
            'page.name' => 'required|min:2',
            'page.status' => [Rule::in(StatusEnum::toValues('archived'))],
        ];
    }

    public function messages() {
        return [];
    }

    public function dehydrate() {
        // $this->dispatchBrowserEvent('');
    }

    public function setPage($page_id) {
        try {
            $this->page = Page::findOrFail($page_id);
        } catch(\Exception $e) {
            $this->page = new Page();
            $this->page->status = StatusEnum::draft()->value;
        }
    }

    public function savePage() {
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
        } catch(\Exception $e) {
            $this->inform(translate('There was an error while saving a page...Please try again.'), $e->getMessage(), 'fail');
        }
    }

    
    public function render()
    {
        return view('livewire.we-edit.forms.page-form');
    }
}