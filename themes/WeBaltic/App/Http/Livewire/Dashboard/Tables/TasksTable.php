<?php

namespace WeThemes\WeBaltic\App\Http\Livewire\Dashboard\Tables;

use DB;
use Carbon;
use App\Models\Task;
use Livewire\Component;
use App\Enums\TaskStatusEnum;
use Illuminate\Database\Eloquent\Builder;
use WeThemes\WeBaltic\App\Enums\TaskTypesEnum;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Filter;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use App\Traits\Livewire\DispatchSupport;

class TasksTable extends DataTableComponent
{
    use DispatchSupport;

    public $status;
    public $type;
    public $tableId;

    public ?int $searchFilterDebounce = 800;

    public string $defaultSortColumn = 'created_at';

    public string $defaultSortDirection = 'desc';

    public bool $columnSelect = true;

    public int $perPage = 25;

    public array $perPageAccepted = [10, 25, 50, 100];

    protected string $pageName = 'tasks';

    protected string $tableName = 'tasks';

    public function mount($type = null, $status = null, $tableId = null)
    {
        $this->type = $type;
        $this->status = $status;
        $this->tableId = $tableId;

        parent::mount();
    }

    public function filters(): array
    {
        return [
            'type' => Filter::make('Type')
                ->select([
                    '' => translate('All'),
                    TaskTypesEnum::printing()->value => translate('Printing'),
                    TaskTypesEnum::delivery()->value => translate('Delivery'),
                ]),
            'status' => Filter::make('Status')
                ->select([
                    '' => translate('All'),
                    TaskStatusEnum::scoping()->value => translate('Scoping'),
                    TaskStatusEnum::backlog()->value => translate('Backlog'),
                    TaskStatusEnum::in_progress()->value => translate('In Progress'),
                    TaskStatusEnum::review()->value => translate('Review'),
                    TaskStatusEnum::done()->value => translate('Done'),
                ]),
        ];
    }

    public function query(): Builder
    {
        return Task::query()
            ->when(!empty($this->status), fn ($query, $value) => $query->where('status', $this->status ?? null))
            ->when(!empty($this->type), fn ($query, $value) => $query->where('type', $this->type ?? null))

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

