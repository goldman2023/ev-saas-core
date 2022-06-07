<?php

namespace App\Http\Livewire\Dashboard\Tables;

use App\Enums\OrderTypeEnum;
use App\Enums\PaymentStatusEnum;
use App\Enums\ShippingStatusEnum;
use App\Facades\MyShop;
use App\Models\Order;
use App\Models\Invoice;
use App\Traits\Livewire\DispatchSupport;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Filter;

class RecentInvoicesWidgetTable extends DataTableComponent
{
    use DispatchSupport;

    public $for = 'me';

    public ?int $searchFilterDebounce = 800;

    public string $defaultSortColumn = 'created_at';

    public string $defaultSortDirection = 'desc';

    public bool $columnSelect = true;

    public int $perPage = 3;

    public array $perPageAccepted = [3, 10, 25, 50, 100];

    protected string $pageName = 'invoices';

    protected string $tableName = 'invoices';

    public function mount($for = 'me', $order = null)
    {
        $this->for = $for;
        $this->order = $order;

        parent::mount();
    }


    public function columns(): array
    {
        return [
            Column::make('Invoice ID')
                ->excludeFromSelectable()
                ->addClass('text-left'),
            Column::make('Order ID')
                ->excludeFromSelectable()
                ->addClass('text-left'),
            Column::make('Status', 'status')
                ->excludeFromSelectable()
                ->addClass('text-left'),
            Column::make('Amount', 'total_price')
                ->excludeFromSelectable()
                ->addClass('text-left'),
            Column::make('Next Invoice Date', 'created_at')
                ->excludeFromSelectable()
                ->addClass('text-left'),
            Column::make('Actions')
                ->excludeFromSelectable(),
        ];
    }

    public function query(): Builder
    {
        return Invoice::query()
            ->orderBy('updated_at', 'desc')
            ->when($this->for === 'me', fn ($query, $value) => $query->my())
            ->when($this->for === 'shop', fn ($query, $value) => $query->shopOrders())
            ->when($this->for === 'all', fn ($query, $value) => $query)
            ->when($this->for === 'order', fn ($query, $value)  => $query->where('order_id', $this->order->id));

            // ->when($this->getFilter('search'), fn ($query, $search) => $query->search($search))
            // ->when($this->getFilter('type'), fn ($query, $type) => $query->where('type', $type))
            // ->when($this->getFilter('payment_status'), fn ($query, $status) => $query->where('payment_status', $status))
            // ->when($this->getFilter('shipping_status'), fn ($query, $status) => $query->where('shipping_status', $status))
            // ->when($this->getFilter('viewed'), function ($query, $status) {
            //     if ($status === 'new') {
            //         return $query->where('viewed', 0);
            //     } elseif ($status === 'viewed') {
            //         return $query->where('viewed', 1);
            //     } else {
            //         return $query;
            //     }
            // })
            // ->when($this->getFilter('date_created'), fn ($query, $date) => $query->whereDate('created_at', '=', $date));
    }

    public function rowView(): string
    {
        return 'components.dashboard.widgets.invoices.recent-invoice-row';
    }
}
