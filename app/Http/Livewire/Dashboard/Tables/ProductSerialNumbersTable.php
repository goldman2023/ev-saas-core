<?php

namespace App\Http\Livewire\Dashboard\Tables;

use App\Enums\SerialNumberStatusEnum;
use App\Facades\MyShop;
use App\Models\Order;
use App\Models\Orders;
use App\Models\Product;
use App\Models\SerialNumber;
use App\Traits\Livewire\DispatchSupport;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Filter;

class ProductSerialNumbersTable extends DataTableComponent
{
    use DispatchSupport;

    public $product;

    public ?int $searchFilterDebounce = 800;

    public string $defaultSortColumn = 'created_at';

    public string $defaultSortDirection = 'desc';

    public bool $columnSelect = true;

    public int $perPage = 10;

    public array $perPageAccepted = [10, 25, 50];

    public array $filterNames = [
        'status' => 'Status',
        'archived' => 'Archived',
    ];

    public array $bulkActions = [

    ];

    public function mount($product)
    {
        $this->product = $product;
        parent::mount();
    }

    protected string $pageName = 'product_serial_numbers';

    protected string $tableName = 'product_serial_numbers';

    public function filters(): array
    {
        return [
            'status' => Filter::make('Status')
                ->select([
                    '' => translate('All'),
                    SerialNumberStatusEnum::in_stock()->value => SerialNumberStatusEnum::in_stock()->label,
                    SerialNumberStatusEnum::out_of_stock()->value => SerialNumberStatusEnum::out_of_stock()->label,
                    SerialNumberStatusEnum::reserved()->value => SerialNumberStatusEnum::reserved()->label,
                ]),
            'archived' => Filter::make('Archived')
                ->select([
                    'no' => 'No',
                    'yes' => 'Yes',
                ]),
        ];
    }

    public function columns(): array
    {
        return [
            Column::make('Serial Number')
                ->sortable()
                ->excludeFromSelectable(),
            Column::make('Status', 'status')
                ->excludeFromSelectable(),
            Column::make('Last update', 'updated_at'),
            Column::make('Created at', 'created_at'),
            Column::make('Actions'),
        ];
    }

    public function query(): Builder
    {
        return SerialNumber::where([
            ['subject_type', $this->product::class],
            ['subject_id', $this->product->id],
        ])
            ->when($this->getFilter('search'), fn ($query, $search) => $query->search($search))
            ->when($this->getFilter('status'), fn ($query, $status) => $query->where('status', $status))
            ->when($this->getFilter('archived'), fn ($query, $archived) => ($archived === 'yes') ? $query->onlyTrashed() : $query);
    }

    public function rowView(): string
    {
        return 'frontend.dashboard.serial-numbers.serial-number-row';
    }

    public function archiveSerialNumber($serial_number_id)
    {
        $serialNumber = SerialNumber::find($serial_number_id);

        try {
            if (empty($serialNumber)) {
                throw new \Exception('');
            }

            $serialNumber->delete();

            $this->inform('Serial number successfully archived!', '', 'success');

            $this->emit('refreshDatatable');
            $this->emit('refreshForm');
        } catch (\Exception $e) {
            $this->inform('There was an error while archiving a serial number...Please try again.', $e->getMessage(), 'fail');
        }
    }
}
