<?php

namespace App\Http\Livewire\WeEdit\Panels;

use Livewire\Component;
use App\Enums\WeEditLayoutEnum;
use App\Traits\Livewire\WeEdit\HasPages;
use App\Traits\Livewire\DispatchSupport;
use App\Traits\Livewire\RulesSets;
use App\Models\Page;
use App\Models\PagePreview;

class PagesEditor extends Component
{
    // use HasPages;
    use DispatchSupport;

    public $current_page;
    public $current_preview;
    public $all_pages;

    protected $listeners = [
        'addSectionToPageEvent' => 'addSectionToPage'
    ];

    public function rules() {
        return [
            'all_pages.*' => '',
            'current_page.id' => '',
            'current_page.title' => '',
            'current_page.slug' => '',
            'current_page.content' => '',
            'current_preview.id' => '',
            'current_preview.content' => '',
        ];
    }

    public function messages() {
        return [];
    }

    public function mount()
    {
        $this->current_page = Page::where('slug', 'home')->first();
        $this->current_preview = $this->current_page->page_previews()->where('user_id', auth()->user()->id)->orderBy('created_at', 'desc')->get();
        $this->all_pages = Page::all();

        $this->setCurrentPagePreview();
    }

    public function changeCurrentPage($page) {
        $this->current_page = $page;
        
        $this->setCurrentPagePreview();
    }

    public function setCurrentPagePreview() {
        $page_previews = $this->current_page->page_previews()->where('user_id', auth()->user()->id)->orderBy('created_at', 'desc')->get();
  
        if($this->current_preview->isEmpty()) {
            // If previews are empty for current user, create a preview
            $this->current_preview = new PagePreview();
            $this->current_preview->user_id = auth()->user()->id;
            $this->current_preview->page_id = $this->current_page->id;
            $this->current_preview->content = empty($this->current_page->content) ? [] : $this->current_page->content;
            $this->current_preview->save();
        } else {
            // TODO: Add logic for preview handling/creating - is it based on session, time after last_update or what?
            $this->current_preview = $page_previews->first();
        }
    }

    public function reorderCurrentPreviewSections($map) {
        $sorted_list = [];
        if(!empty($map)) {
            $sections = $this->current_preview->content;

            foreach($map as $index => $new_order) {
                $sections[$index]['order'] = $new_order;
            }
        }

        $this->current_preview->content = collect($sections)->sortBy('order')->values()->toArray();
        $this->current_preview->save();
    }

    public function addSectionToPage($section_data) {
        if(isset($section_data['id']) && $section_data['section']) { 
            $this->current_preview->content[] = $section_data['section'];
        }
    }

    public function render()
    {
        return view('livewire.we-edit.panels.pages-editor');
    }
}