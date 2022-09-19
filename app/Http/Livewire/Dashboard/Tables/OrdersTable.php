<?php

namespace App\Http\Livewire\Dashboard\Tables;

use App\Enums\OrderTypeEnum;
use App\Enums\PaymentStatusEnum;
use App\Enums\ShippingStatusEnum;
use App\Facades\MyShop;
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

    public $for = 'me';

    public $user;

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
        // 'exportSelected' => 'Export',
    ];

    protected string $pageName = 'orders';

    protected string $tableName = 'orders';

    public function mount($for = 'me', $user = null)
    {
        $this->for = $for;
        $this->user = $user;
        parent::mount();
    }

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
            'type' => Filter::make('Type')
                ->select([
                    '' => translate('All'),
                    OrderTypeEnum::standard()->value => translate('Standard'),
                    OrderTypeEnum::subscription()->value => translate('Subscription'),
                    OrderTypeEnum::installments()->value => translate('Installments'),
                ]),
            'payment_status' => Filter::make('Payment Status')
                ->select([
                    '' => translate('Any'),
                    PaymentStatusEnum::paid()->value => translate('Paid'),
                    PaymentStatusEnum::unpaid()->value => translate('Unpaid'),
                    PaymentStatusEnum::pending()->value => translate('Pending'),
                    PaymentStatusEnum::canceled()->value => translate('Canceled'),
                ]),
            'shipping_status' => Filter::make('Shipping Status')
                ->select([
                    '' => translate('Any'),
                    ShippingStatusEnum::delivered()->value => translate('Delivered'),
                    ShippingStatusEnum::sent()->value => translate('Sent'),
                    ShippingStatusEnum::not_sent()->value => translate('Not Sent'),
                ]),
            'viewed' => Filter::make('Viewed')
                ->select([
                    '' => translate('All'),
                    'new' => translate('New'),
                    'viewed' => translate('Viewed'),
                ]),
            'date_created' => Filter::make('Date created')
                ->date([
                    'max' => now()->format('Y-m-d'), // Optional
                ]),
        ];
    }

    public function columns(): array
    {
        return [
            Column::make('Order', 'id')
                ->sortable()
                ->excludeFromSelectable()
                ->addClass('hidden md:table-cell'),
            Column::make('Type', 'type')
                ->excludeFromSelectable()
                ->addClass('hidden md:table-cell'),
            Column::make('Customer', 'user_id')
                ->excludeFromSelectable(),
            Column::make('Date', 'created_at')
                ->excludeFromSelectable()
                ->sortable(),
            Column::make('Payment status', 'payment_status')
                ->sortable()
                ->addClass('hidden md:table-cell'),
            // Column::make('Shipping status', 'shipping_status')
            //     ->sortable()
            //     ->addClass('hidden md:table-cell'),
            Column::make('Total', 'total')
                ->excludeFromSelectable(),
            Column::make('Actions')
                ->excludeFromSelectable(),
        ];
    }

    public function query(): Builder
    {
        return Order::query()->where('is_temp', 0)
            ->when($this->for === 'me', fn ($query, $value) => $query->where('user_id', $this->user->id ?? null))
            // ->when($this->for === 'shop', fn ($query, $value) => $query->where('shop_id', MyShop::getShopID()))
            ->when($this->getFilter('search'), fn ($query, $search) => $query->search($search))
            ->when($this->getFilter('type'), fn ($query, $type) => $query->where('type', $type))
            ->when($this->getFilter('payment_status'), fn ($query, $status) => $query->where('payment_status', $status))
            ->when($this->getFilter('shipping_status'), fn ($query, $status) => $query->where('shipping_status', $status))
            ->when($this->getFilter('viewed'), function ($query, $status) {
                if ($status === 'new') {
                    return $query->where('viewed', 0);
                } elseif ($status === 'viewed') {
                    return $query->where('viewed', 1);
                } else {
                    return $query;
                }
            })
            ->when($this->getFilter('date_created'), fn ($query, $date) => $query->whereDate('created_at', '=', $date));
    }

    public function rowView(): string
    {
        return 'frontend.dashboard.orders.row';
    }
}
