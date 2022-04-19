<?php

namespace App\Http\Livewire\WeEdit\Forms;

use Livewire\Component;
use App\Traits\Livewire\DispatchSupport;
use App\Enums\WeEditLayoutEnum;
use App\Models\PagePreview;

use Symfony\Component\DomCrawler\Crawler;
use Illuminate\Container\Container;
use Illuminate\Support\Str;
use Illuminate\View\Compilers\ComponentTagCompiler;
use Masterminds\HTML5;

class HtmlSectionEdit extends SectionEdit
{
 
    

    public function render()
    {
        return view('livewire.we-edit.forms.html-section-edit');
    }

    // Overriden
    protected function parseCustomFields() {
        return null;
    }
}