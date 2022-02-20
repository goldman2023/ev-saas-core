<?php

namespace App\Http\Livewire\Dashboard\Tables;

use App\Enums\StatusEnum;
use App\Facades\MyShop;
use App\Models\Product;
use App\Models\Order;
use App\Models\Orders;
use App\Traits\Livewire\DispatchSupport;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Filter;

class ProductsTable extends DataTableComponent
{
    use DispatchSupport;

    public $for = 'me';
    public ?int $searchFilterDebounce = 800;
    public string $defaultSortColumn = 'created_at';
    public string $defaultSortDirection = 'desc';
    public bool $columnSelect = true;
    public int $perPage = 10;
    public array $perPageAccepted = [10, 25, 50];

    public array $filterNames = [
        'status' => 'Status'
    ];

    public array $bulkActions = [

    ];

    protected string $pageName = 'products';
    protected string $tableName = 'products';

    public function mount($for = 'shop') {
        $this->for = $for;

        parent::mount();
    }

    public function filters(): array
    {
        return [
            'status' => Filter::make('Status')
                ->select([
                    '' => translate('All'),
                    StatusEnum::published()->value => translate('Published'),
                    StatusEnum::draft()->value => translate('Draft'),
                    StatusEnum::pending()->value => translate('Pending'),
                    StatusEnum::private()->value => translate('Private'),
                    StatusEnum::archived()->value => translate('Archived'),
                ]),
        ];
    }

    public function columns(): array
    {
        return [
            Column::make('ID')
                ->sortable()
                ->excludeFromSelectable(),
            Column::make('Title')
                ->sortable()
                ->excludeFromSelectable(),
            Column::make('Status', 'status')
                ->excludeFromSelectable(),
            Column::make('Price', 'price')
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
        return Product::query()
            ->when($this->for === 'me', fn($query, $value) => $query->where('user_id', auth()->user()?->id ?? null))
            ->when($this->for === 'shop', fn($query, $value) => $query->where('shop_id', MyShop::getShopID()))
            ->when($this->getFilter('search'), fn ($query, $search) => $query->search($search))
            ->when($this->getFilter('status'), fn ($query, $status) => $query->where('status', $status));
      }

    public function rowView(): string
    {
        return 'frontend.dashboard.products.row';
    }
}
