<?php

namespace App\Http\Livewire\WeEdit\Panels;

use Livewire\Component;
use App\Enums\WeEditLayoutEnum;
use App\Traits\Livewire\WeEdit\HasPages;
use App\Models\Page;

class PagesEditor extends Component
{
    use HasPages;

    public function mount()
    {
        $this->current_page = Page::where('slug', 'home')->first();
    }

    public function render()
    {
        return view('livewire.we-edit.panels.pages-editor');
    }
}