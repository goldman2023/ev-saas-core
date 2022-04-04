<?php

namespace App\Http\Livewire\WeEdit\Panels;

use Livewire\Component;
use App\Enums\WeEditLayoutEnum;
use App\Traits\Livewire\WeEdit\HasPages;
use App\Traits\Livewire\DispatchSupport;
use App\Traits\Livewire\RulesSets;
use App\Models\Page;
use App\Models\PagePreview;
use UUID;

class PagesEditor extends Component
{
    // use HasPages;
    use DispatchSupport;

    public $selected_page_slug;

    public $current_page;
    public $current_preview;
    public $all_pages;

    protected $listeners = [
        'addSectionToPreviewEvent' => 'addSectionToPreview',
        'refreshPreviewEvent' => 'setCurrentPagePreview'
    ];

    protected $queryString = [
        'selected_page_slug' => ['except' => ''],
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
            'current_preview.content.*' => '',
        ];
    }

    public function messages() {
        return [];
    }

    public function mount()
    {
        $this->current_page = Page::where('slug', !empty($this->selected_page_slug) ? $this->selected_page_slug : 'home')->first();

        $this->current_preview = $this->current_page->page_previews()->where('user_id', auth()->user()->id)->orderBy('created_at', 'desc')->get();
        $this->all_pages = Page::all();

        if(empty($this->selected_page_slug)) {
            $this->selected_page_slug = 'home';
        }

        $this->setCurrentPagePreview();
    }

    protected function setSectionUUID(&$target_section) {
        // Set section UUID only if it doesn't have it
        if(!isset($target_section['uuid'])) {
            $target_section['uuid'] = UUID::generate(4)->string;

            if(!empty($this->current_preview->content)) {
                foreach($this->current_preview->content as $section) {
                    // if there is a sction with same UUID already present in current preview sections, fire this function again (it'll generate another random UUID, and break the loop)
                    // Probability for this is so fucking low that I don't even know why I wrote it :D
                    if(($section['uuid'] ?? '') === $target_section['uuid']) {
                        $this->setSectionUUID($target_section); // this means that
                        break;
                    }
                }
            }
        }
    }

    public function changeCurrentPage($page_id) {
        try {
            $this->current_page = Page::findOrFail($page_id);
            $this->selected_page_slug = $this->current_page->slug;

            $this->setCurrentPagePreview();
        } catch(\Exception $e) {
            $this->dispatchGeneralError($e);
        }
    }

    public function setCurrentPagePreview() {
        $page_previews = $this->current_page->page_previews()->where('user_id', auth()->user()->id)->orderBy('created_at', 'desc')->get();

        if($page_previews->isEmpty()) {
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

        // Set UUID for each section if it doesn't have it.
        if(!empty($this->current_preview->content)) {
            $new_content = $this->current_preview->content;

            foreach($new_content as $key => $section) {
                $this->setSectionUUID($new_content[$key]);
            }

            $this->current_preview->content = $new_content;
            $this->current_preview->save();
        }

        $this->emit('reloadCurrentPreviewEvent', $this->current_preview);
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

        $this->emit('reloadCurrentPreviewEvent', $this->current_preview);
    }

    public function addSectionToPreview($section_data) {
        if(isset($section_data['id']) && $section_data['section']) {
            $section_data['section']['order'] = count($this->current_preview->content);
            $new_content = $this->current_preview->content;
            $this->setSectionUUID($section_data['section']); // set UUID to newly added section
            $new_content[] = $section_data['section'];
            $this->current_preview->content = $new_content; // replace old content with new one (old sections + new section)
            $this->current_preview->save(); // save preview to DB

            $this->emit('reloadCurrentPreviewEvent', $this->current_preview);
        }
    }

    public function deleteSectionFromPreview($index) {

        if(isset($this->current_preview->content[$index])) {
            $new_content = $this->current_preview->content;
            unset($new_content[$index]); // remove given index
            $new_content = array_values($new_content); // reset array indexes

            foreach($new_content as $new_index => $section) {
                $new_content[$new_index]['order'] = $new_index; // set new order to follow resetted indexes, from 0 to X
            }

            $this->current_preview->content = $new_content; // set current preview to have a new content (old sections - section undex given index)
            $this->current_preview->save(); // save preview to DB

            $this->emit('reloadCurrentPreviewEvent', $this->current_preview);
        } else {
            // Send general error that section under sent index does not exist and thus cannot be DELETED
        }
    }

    public function duplicateSection($index) {
        if(isset($this->current_preview->content[$index])) {
            $new_content = $this->current_preview->content;
            $new_content[] = $new_content[$index];

            foreach($new_content as $new_index => $section) {
                $new_content[$new_index]['order'] = $new_index; // set new order to follow resetted indexes, from 0 to X
            }

            $this->current_preview->content = $new_content; // set current preview to have a new content (old sections + duplicated section as the last one)
            $this->current_preview->save(); // save preview to DB

            $this->emit('reloadCurrentPreviewEvent', $this->current_preview);
        } else {
            // Send general error that section under sent index does not exist and thus cannot be DUPLICATED
        }
    }

    public function savePreviewToPage() {
        try {
            $this->setCurrentPagePreview(); // get the latest preview content and use it to replace content if the page
            
            $this->current_page->content = $this->current_preview->content;
            $this->current_page->save();

            $this->inform(translate('Page successfully updated!'), '', 'success');
        } catch(\Exception $e) {
            $this->dispatchGeneralError($e);
        }
    }

    public function render()
    {
        return view('livewire.we-edit.panels.pages-editor');
    }
}
