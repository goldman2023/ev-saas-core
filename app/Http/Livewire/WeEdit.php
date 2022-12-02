<?php

namespace App\Http\Livewire;

use App\Enums\WeEditLayoutEnum;
use App\Models\Page;
use Livewire\Component;
use WeBuilder;

class WeEdit extends Component
{
    public $page;

    public $we_edit_data;

    public $sections;

    public $we_menu;

    public $selected_container;

    public $selected_page_slug;

    public function mount()
    {
        $this->we_menu = [
            [
                'title' => translate('Pages'),
                'slug' => 'pages',
                'icon' => 'heroicon-o-document',
                'template' => 'we-edit.pages.editor',
            ],
            [
                'title' => translate('Menus'),
                'slug' => 'menus',
                'icon' => 'heroicon-o-bars-3',
                'template' => 'we-edit.pages.menu',
            ],
            [
                'title' => translate('Templates'),
                'slug' => 'templates',
                'icon' => 'heroicon-o-archive-box',
                'template' => 'we-edit.pages.templates',
            ],
            [
                'title' => translate('Site structure'),
                'slug' => 'site-structure',
                'icon' => 'heroicon-o-globe-alt',
                'template' => 'we-edit.pages.structure',

            ],
        ];

        $this->selected_container = $this->we_menu[0];

        $this->we_edit_data = $this->getEditData();
    }

    public function render()
    {
        if(isset($_GET['selected_page_slug'])) {
            $this->selected_page_slug = $_GET['selected_page_slug'];
        } else {
            $this->selected_page_slug = 'home';
        }

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
            $page->type = 'wenode';
            $page->type = 'system';
            $page['position'] = ['x' =>  $positions['x'], 'y' => $positions['y']];
            $positions['x'] += 200;
        }
        $menu_flow = [];

        $pages = [];

        $weEditData = [
            'pages' => json_encode($pages),
            'available_pages' => json_encode($available_pages),
            'menu_flow' => json_encode($menu_flow),
        ];

        return $weEditData;
    }
}
