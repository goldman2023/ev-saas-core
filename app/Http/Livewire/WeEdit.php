<?php

namespace App\Http\Livewire;

use App\Models\Page;
use Livewire\Component;
use App\Enums\WeEditLayoutEnum;

class WeEdit extends Component
{
    public $page;
    public $we_edit_data;
    public $sections;

    public $we_menu;
    public $selected_page;

    public function mount() 
    {
        $this->we_menu = [
            [
                'title' => translate('Pages'),
                'icon' => 'heroicon-o-document',
                'template' => 'we-edit.pages.editor'
            ],
            [
                'title' => translate('Menus'),
                'icon' => 'heroicon-o-menu',
                'template' => 'we-edit.pages.menu'
            ],
            [
                'title' => translate('Templates'),
                'icon' => 'heroicon-o-archive'
            ],
            [
                'title' => translate('Site structure'),
                'icon' => 'heroicon-o-globe-alt'
            ]
        ];
    }

    public function render()
    {
        $this->selected_page = $this->we_menu[0]['template'];
        $this->page = Page::where('slug', 'home')->first();
        $this->sections =  $this->page->content;
        $this->we_edit_data = $this->getEditData();

        return view('livewire.we-edit.we-edit');
    }

    public function getEditData()
    {
        $available_pages = Page::all();
        $positions['x'] = 0;
        $positions['y'] = 200;
        $count = 0;
        foreach ($available_pages as $page) {
            $count++;
            $page['data'] = ['label' => $page->title];
            $page->type = 'default';
            $page->type = 'system';
            $page['position'] = ['x' =>  $positions['x'], 'y' => $positions['y']];
            $positions['x'] += 200;
        }
        $menu_flow = [];

        $pages = [];


        $weEditData = [
            'pages' => json_encode($pages),
            'available_pages' => json_encode($available_pages),
            'menu_flow' => json_encode($menu_flow)
        ];
        
        return $weEditData;
    }
}
