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
    public $current_preview;
    // public $all_pages;

    protected $listeners = [
        'addSectionToPageEvent' => 'addSectionToPage'
    ];

    protected $rules = [
        // 'all_pages.*' => '',
        'current_page.id' => 'nullable',
        'current_page.title' => 'nullable',
        'current_page.slug' => 'nullable',
        'current_page.content' => 'nullable',
        'current_preview.id' => 'nullable',
        'current_preview.content' => 'nullable',
    ];

    public function messages() {
        return [];
    }

    public function mount()
    {
        $this->current_page = Page::where('slug', 'home')->first();
        // dd($this->current_page);
        $this->current_preview = $this->current_page->page_previews()->where('user_id', auth()->user()->id)->orderBy('created_at', 'desc')->get();
        // $this->all_pages = Page::all();
    }

    public function changeCurrentPage($page) {
        $this->current_page = $page;
        $page_previews = $this->current_page->page_previews()->where('user_id', auth()->user()->id)->orderBy('created_at', 'desc')->get();

        if(empty($page_previews)) {
            // If previews are empty for current user, create a preview
            $this->current_preview = new PagePreview();
            $this->current_preview->user_id = auth()->user()->id;
            $this->current_preview->page_id = $this->current_page->id;
            $this->current_preview->content = $this->current_page->content;
            $this->current_preview->save();
        } else {
            $this->current_preview = $page_previews->first();
        }
    }

    public function reorderCurrentPreviewSections($keys) {
        $sorted_list = [];
        if(!empty($keys)) {
            foreach($keys as $key) {
                $sorted_list[$key] = $this->current_preview->content[$key];
            }
        }

        Page::where('id', $this->current_preview->id)->update(['content' => $sorted_list]);
        $this->current_page = Page::where('id', $this->current_page->id)->first();
    }

    public function addSectionToPage($section_data) { 
        if(isset($section_data['id']) && $section_data['section']) { 
            $this->current_page->content[$section_data['id']] = $section_data['section'];
        }
    }

    public function render()
    {
        return view('livewire.we-edit.panels.pages-editor');
    }
}