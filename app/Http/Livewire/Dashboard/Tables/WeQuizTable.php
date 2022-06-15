<?php

namespace App\Http\Livewire\Dashboard\Tables;

use App\Enums\StatusEnum;
use App\Facades\MyShop;
use App\Models\Order;
use App\Models\Orders;
use App\Models\Page;
use App\Models\WeQuiz;
use App\Traits\Livewire\DispatchSupport;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Filter;

class WeQuizTable extends DataTableComponent
{
    use DispatchSupport;

    public ?int $searchFilterDebounce = 800;

    public string $defaultSortColumn = 'created_at';

    public string $defaultSortDirection = 'desc';

    public bool $columnSelect = true;

    public int $perPage = 25;

    public array $perPageAccepted = [10, 25, 50, 100];

    public array $bulkActions = [

    ];

    protected string $pageName = 'pages';

    protected string $tableName = 'pages';

    public function filters(): array
    {
        return [
            
        ];
    }

    public function columns(): array
    {
        return [
            Column::make('ID')
                ->sortable()
                ->excludeFromSelectable(),
            Column::make('Title', 'name')
                ->sortable()
                ->excludeFromSelectable(),
            Column::make('Created', 'created_at')
                ->sortable(),
            Column::make('Last Update', 'updated_at')
                ->sortable(),
            Column::make('Actions')
                ->excludeFromSelectable(),
        ];
    }

    public function query(): Builder
    {
        // TODO: Remove my() scope and user different appraoch. Also think about relating WeQuizz with shop or something like that too...
        return WeQuiz::query()->my()
            ->when($this->getFilter('search'), fn ($query, $search) => $query->search($search));
    }

    public function rowView(): string
    {
        return 'frontend.dashboard.we-quiz.row-quiz';
    }
}
