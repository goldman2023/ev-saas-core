<?php

namespace App\Http\Livewire\Dashboard\Tables;

use Livewire\Component;
use DB;
use Carbon;
use App\Enums\TaskTypesEnum;
use App\Models\Task;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Filter;

class TasksTable extends DataTableComponent
{
    public ?int $searchFilterDebounce = 800;

    public string $defaultSortColumn = 'created_at';

    public string $defaultSortDirection = 'desc';

    public bool $columnSelect = true;

    public int $perPage = 25;

    public array $perPageAccepted = [10, 25, 50, 100];

    protected string $pageName = 'tasks';

    protected string $tableName = 'tasks';


    public function exportSelected()
    {
    }

    public function filters(): array
    {
        return [
            'status' => Filter::make('Status')
                ->select([
                    '' => translate('All'),
                    TaskTypesEnum::issue()->value => translate('Issue'),
                    TaskTypesEnum::improvement()->value => translate('Improvement'),
                    TaskTypesEnum::other()->value => translate('Other'),
                    TaskTypesEnum::payment()->value => translate('Payment'),
                    TaskTypesEnum::request()->value => translate('Request'),
                ]),
        ];
    }

    public function query(): Builder
    {
        return Task::query()
            ->when($this->getFilter('search'), fn ($query, $search) => $query->search($search))
            ->when($this->getFilter('status'), fn ($query, $status) => $query->where('status', $status))
            ->when($this->getFilter('type'), fn ($query, $type) => $query->where('type', $type));
    }
    public function columns(): array
    {
        return [
            Column::make('ID','id')
                ->sortable()
                ->excludeFromSelectable(),
            Column::make('Name', 'name')
                ->excludeFromSelectable()
                ->addClass('hidden md:table-cell'),
            Column::make('Type', 'type')
                ->excludeFromSelectable(),
            Column::make('Status', 'status')
                ->excludeFromSelectable(),
            Column::make('Assignee', 'assignee_id')
                ->excludeFromSelectable()
                ->addClass('hidden md:table-cell'),
            Column::make('Creator', 'user_id')
                ->excludeFromSelectable()
                ->addClass('hidden md:table-cell'),
            Column::make('Date', 'created_at')
                ->excludeFromSelectable()
                ->sortable(),
            Column::make('Actions')
                ->excludeFromSelectable(),
        ];
    }
    public function rowView(): string
    {
        return 'frontend.dashboard.tasks.row';
    }
}

