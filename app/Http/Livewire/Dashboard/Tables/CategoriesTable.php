<?php

namespace App\Http\Livewire\Dashboard\Tables;

use App\Facades\MyShop;
use App\Models\ShopAddress;
use App\Traits\Livewire\RulesSets;
use Categories;
use App\Models\Category;
use App\Models\Order;
use App\Models\Orders;
use App\Traits\Livewire\DispatchSupport;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Filter;
use Livewire\Component;

class CategoriesTable extends Component
{
    use RulesSets;
    use DispatchSupport;

    public $categories;
    public $search_query;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function mount()
    {
        $this->categories = Categories::getAll();
    }

    protected function rules()
    {
        return [
            'categories.*' => [],
            'categories.*.*' => [],
            'search_query' => []
        ];
    }

    protected function messages()
    {
        return [];
    }

    public function updatedSearchQuery()
    {
        // TODO: Does not work for some reason...even though it returns correctly formatted categories data -_-
        if(!empty($this->search_query)) {
            $this->categories = Categories::getAll(true)->filter(fn($item) => stripos($item?->getTranslation('name') ?? $item->name, $this->search_query) !== false)
                ->toTree()
                ->recursiveApply('children', ['fn' => 'keyBy', 'params' => ['slug']]);
        } else {
            $this->categories = Categories::getAll();
        }
    }

    public function render()
    {
        return view('livewire.dashboard.forms.categories.table');
    }

}
