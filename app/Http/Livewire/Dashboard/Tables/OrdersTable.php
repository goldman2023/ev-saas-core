<?php

namespace App\Http\Livewire\Dashboard\Tables;

use App\Models\Order;
use App\Models\Orders;
use App\Traits\Livewire\DispatchSupport;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Filter;

class OrdersTable extends DataTableComponent
{
    use DispatchSupport;

    public ?int $searchFilterDebounce = 800;
    public string $defaultSortColumn = 'created_at';
    public string $defaultSortDirection = 'desc';
    public bool $columnSelect = true;
    public int $perPage = 25;
    public array $perPageAccepted = [10, 25, 50, 100];

    public array $sortNames = [
        'total' => 'Total',
        'date' => 'Date',
    ];

    public array $filterNames = [
        'payment_status' => 'Payment Status',
        'shipping_status' => 'Shipping Status',
    ];

    public array $bulkActions = [
        'exportSelected' => 'Export',
    ];

    protected string $pageName = 'orders';
    protected string $tableName = 'orders';

    public function exportSelected()
    {
        if ($this->selectedRowsQuery->count() > 0) {
            //return (new UserExport($this->selectedRowsQuery))->download($this->tableName.'.xlsx');
            $this->toastify(translate('Your export will start soon...'), 'info');
            return true;
        }

        // Not included in package, just an example.
        $this->toastify(translate('You did not select any users to export.'), 'danger');
    }

    public function filters(): array
    {
        return [
            'payment_status' => Filter::make('Payment Status')
                ->select([
                    '' => translate('Any'),
                    Order::PAYMENT_STATUS_PAID => translate('Paid'),
                    Order::PAYMENT_STATUS_UNPAID => translate('Unpaid'),
                    Order::PAYMENT_STATUS_PENDING => translate('Pending'),
                    Order::PAYMENT_STATUS_CANCELED => translate('Canceled'),
                ]),
            'shipping_status' => Filter::make('Shipping Status')
                ->select([
                    '' => translate('Any'),
                    Order::SHIPPING_STATUS_DELIVERED => translate('Delivered'),
                    Order::SHIPPING_STATUS_SENT => translate('Sent'),
                    Order::SHIPPING_STATUS_NOT_SENT => translate('Not Sent'),
                ]),
            'viewed' => Filter::make('Viewed')
                ->select([
                    '' => translate('All'),
                    'new' => translate('New'),
                    'viewed' => translate('Viewed')
                ]),
        ];
    }

    public function columns(): array
    {
        return [
            Column::make('Order')
                ->sortable()
                ->excludeFromSelectable()
                ->addClass('hidden md:table-cell'),
            Column::make('Date', 'created_at')
                ->excludeFromSelectable()
                ->sortable(),
            Column::make('Customer')
                ->excludeFromSelectable()
                ->sortable(),
            Column::make('Payment status', 'payment_status')
                ->sortable()
                ->addClass('hidden md:table-cell'),
            Column::make('Shipping status', 'shipping_status')
                ->sortable()
                ->addClass('hidden md:table-cell'),
            Column::make('Total', 'total')
                ->excludeFromSelectable()
                ->sortable(),
            Column::make('Actions')
                ->excludeFromSelectable(),
        ];
    }

    public function query(): Builder
    {
        return Order::query()
            ->when($this->getFilter('search'), fn ($query, $search) => $query->search($search))
            ->when($this->getFilter('payment_status'), fn ($query, $status) => $query->where('payment_status', $status))
            ->when($this->getFilter('shipping_status'), fn ($query, $status) => $query->where('shipping_status', $status))
            ->when($this->getFilter('viewed'), function ($query, $status) {
                if($status === 'new')
                    return $query->where('viewed', 0);
                else if($status === 'viewed')
                    return $query->where('viewed', 1);
                else
                    return $query;
            });
      }

    public function rowView(): string
    {
        return 'frontend.dashboard.orders.row';
    }
}
