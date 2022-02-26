<?php

namespace App\Http\Livewire\WeEdit\Panels;

use Livewire\Component;
use App\Enums\WeEditLayoutEnum;
use App\Traits\Livewire\WeEdit\HasPages;
use App\Traits\Livewire\DispatchSupport;
use App\Traits\Livewire\RulesSets;
use App\Models\Page;

class PagesEditor extends Component
{
    // use HasPages;
    use DispatchSupport;

    public $current_page;
    public $all_pages;

    protected $rules = [
        'all_pages.*' => '',
        'current_page.id' => '',
        'current_page.title' => '',
        'current_page.slug' => '',
        'current_page.content' => '',
    ];

    public function messages() {
        return [];
    }

    public function mount()
    {
        $this->current_page = Page::where('slug', 'home')->first()->toArray();
        $this->all_pages = Page::all()->toArray();
    }

    public function changeCurrentPage($page) {
        $this->current_page = $page;
    }

    public function reorderCurrentPageSections($keys) {
        $sorted_list = [];
        if(!empty($keys)) {
            foreach($keys as $key) {
                $sorted_list[$key] = $this->current_page['content'][$key];
            }
        }

        Page::where('id', $this->current_page['id'])->update(['content' => $sorted_list]);
        $this->current_page = Page::where('id', $this->current_page['id'])->first()->toArray();
    }

    public function render()
    {
        return view('livewire.we-edit.panels.pages-editor');
    }
}