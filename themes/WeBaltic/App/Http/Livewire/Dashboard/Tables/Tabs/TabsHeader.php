<?php

namespace WeThemes\WeBaltic\App\Http\Livewire\Dashboard\Tables\Tabs;

use Livewire\Component;
use App\Traits\Livewire\DispatchSupport;

class TabsHeader extends Component
{
    use DispatchSupport;

    public $tabsId;
    public $enum;
    public $model;
    public $property;
    public $isWef;

    protected $listeners = [
        'refreshDatatable' => '$refresh',
        'refreshTabsHeader' => '$refresh',
    ];

    public function render()
    {
        return view('livewire.dashboard.tables.tabs.tabs-header');
    }

    public function mount($tabsId = '', $enumClass = '', $modelClass = '', $property = '', $isWef = false)
    {
        $this->tabsId = $tabsId;
        $this->enum = $enumClass;
        $this->model = $modelClass;
        $this->property = $property;
        $this->isWef = $isWef;
    }
}