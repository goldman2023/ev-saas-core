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
use Staudenmeir\LaravelAdjacencyList\Eloquent\Collection;

class CategoriesTable extends Component
{
    use RulesSets;
    use DispatchSupport;

    public $all_categories;
    public $search_query;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function mount()
    {
        $this->all_categories = Categories::getAll(true);
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

    public function searchByQuery()
    {
        // TODO: Does not work for some reason...even though it returns correctly formatted categories data -_-
        if(!empty($this->search_query)) {
            $this->all_categories = collect(Categories::getAll(true))
                ->filter(fn($item) => stripos($item?->getTranslation('name') ?? $item->name, $this->search_query) !== false)
                ->recursiveApply('children', ['fn' => 'keyBy', 'params' => ['slug']]);
        } else {
            $this->all_categories = Categories::getAll(true);
        }

        $this->dispatchBrowserEvent('update-categories-count', ['count' => $this->all_categories->count()]);
    }

    public function render()
    {
        return view('livewire.dashboard.forms.categories.table');
    }

}
