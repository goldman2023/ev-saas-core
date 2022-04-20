<?php

namespace App\Http\Livewire\WeEdit\Forms;

use App\Enums\WeEditLayoutEnum;
use App\Models\PagePreview;
use App\Traits\Livewire\DispatchSupport;
use Illuminate\Container\Container;
use Illuminate\Support\Str;
use Illuminate\View\Compilers\ComponentTagCompiler;
use Livewire\Component;
use Masterminds\HTML5;
use Symfony\Component\DomCrawler\Crawler;

class HtmlSectionEdit extends SectionEdit
{
    public function render()
    {
        return view('livewire.we-edit.forms.html-section-edit');
    }

    // Overriden
    protected function parseCustomFields()
    {
        return null;
    }
}
