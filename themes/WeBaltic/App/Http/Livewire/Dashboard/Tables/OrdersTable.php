<?php

namespace WeThemes\WeBaltic\App\Http\Livewire\Dashboard\Tables;

use App\Models\Order;
use App\Models\Orders;
use App\Facades\MyShop;
use App\Enums\OrderTypeEnum;
use App\Enums\PaymentStatusEnum;
use App\Enums\ShippingStatusEnum;
use App\Traits\Livewire\DispatchSupport;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Filter;
use WeThemes\WeBaltic\App\Enums\OrderCycleStatusEnum;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use WeThemes\WeBaltic\App\Http\Controllers\OrderController;

class OrdersTable extends DataTableComponent
{
    use DispatchSupport;

    public $user;

    public $status;

    public $tableId;

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
        'payment_status' => 'Lipdukas',
        'shipping_status' => 'Shipping Status',
        'status' => 'Order Status',
    ];

    public array $bulkActions = [
        // 'exportSelected' => 'Export',
    ];

    protected string $pageName = 'orders';

    protected string $tableName = 'orders';

    public function mount($user = null, $status = null, $tableId = null)
    {
        $this->status = $status;
        $this->user = $user;
        $this->tableId = $tableId;

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
            'payment_status' => Filter::make('Lipdukas')
                ->select([
                    '' => translate('Any'),
                    PaymentStatusEnum::paid()->value => translate('Paid'),
                    PaymentStatusEnum::unpaid()->value => translate('Unpaid'),
                    PaymentStatusEnum::pending()->value => translate('Pending'),
                    PaymentStatusEnum::canceled()->value => translate('Canceled'),
                ]),
            'shipping_status' => Filter::make('Printing Status')
                ->select([
                    '' => translate('Any'),
                    ShippingStatusEnum::delivered()->value => translate('Not Printed'),
                    ShippingStatusEnum::sent()->value => translate('Printed'),
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
            Column::make('ID', 'id')
                ->sortable()
                ->excludeFromSelectable()
                ->addClass('hidden md:table-cell'),
            // Column::make('Type', 'type')
            //     ->excludeFromSelectable()
            //     ->addClass('hidden md:table-cell'),
            Column::make('Product')
                ->excludeFromSelectable()
                ->addClass('text-left max-w-[300px]'),
            Column::make('Customer', 'user_id')
                ->excludeFromSelectable()
                ->addClass('text-left max-w-[300px]'),
            
            Column::make('Man. order')
                ->excludeFromSelectable()
                ->addClass('text-left whitespace-nowrap'),

            Column::make('Actions')
                ->excludeFromSelectable(),
                Column::make('Printing Status')
                ->excludeFromSelectable()
                ->sortable(),
                Column::make('Payment', 'payment_status')
                ->sortable()
                ->addClass('hidden md:table-cell'),
            Column::make('Date', 'created_at')
                ->excludeFromSelectable()
                ->sortable(),

            // Column::make('Shipping status', 'shipping_status')
            //     ->sortable()
            //     ->addClass('hidden md:table-cell'),
            Column::make('Total', 'total')
                ->excludeFromSelectable(),

        ];
    }

    public function query(): Builder
    {
        return Order::query()->where('is_temp', 0)
            ->when(in_array($this->status, OrderCycleStatusEnum::toValues(), true), fn ($query, $value) => $query->whereWEF('cycle_status', $this->status ?? null))

            ->when(!auth()->user()->isCustomer() && !empty($this->user), fn ($query, $value) => $query->where('user_id', $this->user->id ?? null))
            ->when(auth()->user()->isCustomer(), fn ($query, $value) => $query->where('user_id', $this->user->id ?? null))

            ->when($this->getFilter('search'), fn ($query, $search) => $query->search($search))
            ->when($this->getFilter('type'), fn ($query, $type) => $query->where('type', $type))
            ->when($this->getFilter('payment_status'), fn ($query, $status) => $query->where('payment_status', $status))
            ->when($this->getFilter('shipping_status'), fn ($query, $status) => $query->where('shipping_status', $status))
            ->when($this->getFilter('status'), fn ($query, $status) => $query->where('status', $status))
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

    public function incrementOrderCycleStatus($order_id = null)
    {

        $controller = app()->make(OrderController::class);

        $order = $controller->change_cycle_status(order_id: $order_id, standalone: true);

        if ($order instanceof Order) {
            $new_status_label = OrderCycleStatusEnum::labels()[$order->getWEF('cycle_status', true)] ?? '?';

            $this->inform(translate('Order cycle status successfully incremented!'), translate('Order (#') . $order_id . translate(') has the cycle status: ') . $new_status_label, 'success');
            $this->emit('refreshDatatable');
        } else {
            $this->inform(translate('Order cycle status could not be incremented'), translate('Order (#') . $order_id . translate(') could not increment the cycle status...'), 'fail');
        }
    }
}
