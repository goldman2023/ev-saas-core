<?php

namespace App\Http\Livewire\Dashboard\Tables;

use Carbon;
use App\Enums\StatusEnum;
use App\Facades\MyShop;
use App\Models\BlogPost;
use App\Models\Order;
use App\Models\Orders;
use App\Models\Plan;
use App\Traits\Livewire\DispatchSupport;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Filter;

class LicensesTable extends DataTableComponent
{
    use DispatchSupport;

    public $for = 'me';
    public ?int $searchFilterDebounce = 800;
    public string $defaultSortDirection = 'desc';
    public bool $columnSelect = true;
    public int $perPage = 10;
    public array $perPageAccepted = [10, 25];

    public array $filterNames = [
        // 'type' => 'License Type'
    ];

    public array $bulkActions = [

    ];

    protected string $pageName = 'licenses';
    protected string $tableName = 'licenses';

    public function mount($for = 'me') {
        $this->for = $for;

        parent::mount();
    }

    public function filters(): array
    {
        return [
            // 'type' => Filter::make('Type')
            //     ->select([
            //         '' => translate('All'),
            //         StatusEnum::published()->value => translate('Published'),
            //         StatusEnum::draft()->value => translate('Draft'),
            //         StatusEnum::pending()->value => translate('Pending'),
            //         StatusEnum::private()->value => translate('Private'),
            //     ]),
        ];
    }

    public function columns(): array
    {

        $columns = [];

        return [
            Column::make('ID', 'license_id')
                ->excludeFromSelectable(),
            Column::make('Name', 'license_name')
                ->excludeFromSelectable(),
            Column::make('Type', 'license_type')
                ->excludeFromSelectable(),
            Column::make('Serial Number', 'serial_number')
                ->excludeFromSelectable(),
            Column::make('Ending In', 'ending')
                ->excludeFromSelectable(),
            // Column::make('Updated', 'end_date')
            //     ->excludeFromSelectable(),
            Column::make('Actions')
                ->excludeFromSelectable(),
        ];
    }

    public function query(): Builder
    {
        if($this->for === 'me') {
            return auth()->user()->plan_subscriptions()->with('license')->getQuery()
                    // ->getQuery()->where('end_date', '>', now())->orWhere('end_date', null)
                    ->when($this->getFilter('search'), fn ($query, $search) => $query->search($search));
                    // ->when($this->getFilter('status'), fn ($query, $status) => $query->where('status', $status));
        }
      }

    public function rowView(): string
    {
        return 'frontend.dashboard.plans.row-license';
    }
}
