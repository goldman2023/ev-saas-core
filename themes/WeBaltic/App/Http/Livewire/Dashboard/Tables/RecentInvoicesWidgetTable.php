<?php

namespace WeThemes\WeBaltic\App\Http\Livewire\Dashboard\Tables;

use DB;
use Log;
use App\Enums\OrderTypeEnum;
use App\Enums\PaymentStatusEnum;
use App\Enums\ShippingStatusEnum;
use App\Facades\MyShop;
use App\Models\Order;
use App\Models\Invoice;
use App\Models\User;
use App\Traits\Livewire\DispatchSupport;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Filter;

class RecentInvoicesWidgetTable extends DataTableComponent
{
    use DispatchSupport;

    public ?int $searchFilterDebounce = 800;

    public string $defaultSortColumn = 'created_at';

    public string $defaultSortDirection = 'desc';

    public bool $columnSelect = true;

    public int $perPage = 3;

    public array $perPageAccepted = [3, 10, 25, 50, 100];

    protected string $pageName = 'invoices';

    protected string $tableName = 'invoices';

    public $user;
    public $shop;
    public $order;

    public function mount($user = null, $shop = null, $order = null)
    {
        $this->user = $user;
        $this->shop = $shop;
        $this->order = $order;

        parent::mount();
    }

    public array $filterNames = [
        'payment_status' => 'Lipdukas',
    ];

    public function filters(): array
    {
        return [
            'payment_status' => Filter::make('Lipdukas')
                ->select([
                    '' => translate('Any'),
                    PaymentStatusEnum::paid()->value => translate('Paid'),
                    PaymentStatusEnum::unpaid()->value => translate('Unpaid'),
                    PaymentStatusEnum::pending()->value => translate('Pending'),
                    PaymentStatusEnum::canceled()->value => translate('Canceled'),
            ]),
        ];
    }

    public function columns(): array
    {
        return [
            Column::make('Invoice Number')
                ->excludeFromSelectable()
                ->addClass('text-left'),
            Column::make('Customer')
                ->excludeFromSelectable()
                ->addClass('text-left'),
            Column::make('Status', 'status')
                ->excludeFromSelectable()
                ->addClass('text-left'),
            Column::make('Amount (with tax)', 'total_price')
                ->excludeFromSelectable()
                ->addClass('text-left'),
            Column::make('Tax', 'tax')
                ->excludeFromSelectable()
                ->addClass('text-left'),
            Column::make('Actions')
                ->excludeFromSelectable(),
        ];
    }

    public function query(): Builder
    {
        $query = Invoice::query();

        if(empty($this->user) && empty($this->order) && empty($this->shop)) {
            if(!\Permissions::canAccess(User::$non_customer_user_types, ['all_orders', 'browse_orders'], false)) {
                return Invoice::query()->where('user_id', -1);
            }
        } else if(!empty($this->user)) {
            $query = $query->where('user_id', $this->user->id);
        } else if(!empty($this->shop)) {
            $query = $query->where('shop_id', $this->shop->id);
        } else if(!empty($this->order)) {
            $query = $query->where('order_id', $this->order->id);
        }

        return $query
            ->when($this->getFilter('payment_status'), fn ($query, $status) => $query->where('payment_status', $status))
            ->orderBy('updated_at', 'desc');
    }

    public function rowView(): string
    {
        return 'components.dashboard.widgets.invoices.recent-invoice-row';
    }

    public function markInvoiceAsPaid($invoice_id) {
        DB::beginTransaction();

        try {
            $invoice = Invoice::findOrFail($invoice_id);

            $invoice->setInvoiceAsPaid();
            $invoice->save();

            // Maybe: Add this logic to setInvoiceAsPaid() in side Invoice model itself...
            $invoice->order->setOrderAsPaid();
            $invoice->order->save();

            DB::commit();
            
            $this->emit('refreshDatatables');
        } catch(\Exception $e) {
            DB::rollback();
            Log::error($e);
            $this->inform(translate('There was an error while marking invoice as paid.'), '', 'fail');
        }
    }
}
