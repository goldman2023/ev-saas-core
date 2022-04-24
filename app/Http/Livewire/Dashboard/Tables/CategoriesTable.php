<?php

namespace App\Http\Livewire\Dashboard\Tables;

use App\Enums\StatusEnum;
use App\Facades\MyShop;
use App\Models\Category;
use App\Traits\Livewire\DispatchSupport;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Filter;

class CategoriesTable extends DataTableComponent
{
    use DispatchSupport;

    public ?int $searchFilterDebounce = 800;

    public string $defaultSortColumn = 'created_at';

    public string $defaultSortDirection = 'desc';

    public bool $columnSelect = true;

    public int $perPage = 25;

    public array $perPageAccepted = [10, 25, 50, 100];

    public array $filterNames = [
        'featured' => 'Featured',
    ];

    public array $bulkActions = [

    ];

    protected string $pageName = 'categories';

    protected string $tableName = 'categories';

    public function mount()
    {
        parent::mount();
    }

    public function filters(): array
    {
        return [
            'featured' => Filter::make('Featured')
                ->select([
                    '' => translate('All'),
                    1 => translate('Yes'),
                    0 => translate('No'),
                ]),
            'date_created' => Filter::make('Date created')
                ->date([
                    'max' => now()->format('Y-m-d'),
                ]),
        ];
    }

    public function columns(): array
    {
        return [
            Column::make('ID')
                ->sortable()
                ->excludeFromSelectable(),
            Column::make('Name')
                ->sortable()
                ->excludeFromSelectable(),
            Column::make('Featured', 'featured')
                ->excludeFromSelectable(),
            Column::make('Children', 'descendants_count')
                ->sortable(),
            Column::make('Created', 'created_at'),
            Column::make('Actions')
                ->excludeFromSelectable(),
        ];
    }

    public function query(): Builder
    {
        return Category::query()->withCount(['products', 'shops', 'descendants'])
            ->when($this->getFilter('search'), fn ($query, $search) => $query->search($search))
            ->when($this->getFilter('featured'), fn ($query, $featured) => $query->where('featured', $featured))
            ->when($this->getFilter('date_created'), fn ($query, $date) => $query->whereDate('created_at', '=', $date));
    }

    public function rowView(): string
    {
        return 'frontend.dashboard.categories.row';
    }
}
