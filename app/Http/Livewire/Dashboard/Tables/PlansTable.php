<?php

namespace App\Http\Livewire\Dashboard\Tables;

use Carbon;
use App\Events\Plans\PlanSubscriptionCanceled;
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

class PlansTable extends DataTableComponent
{
    use DispatchSupport;

    public $for = 'me';
    public ?int $searchFilterDebounce = 800;
    public string $defaultSortColumn = 'plans.created_at';
    public string $defaultSortDirection = 'desc';
    public bool $columnSelect = true;
    public int $perPage = 10;
    public array $perPageAccepted = [10, 25];

    public array $filterNames = [
        'status' => 'Status'
    ];

    public array $bulkActions = [

    ];

    protected string $pageName = 'plans';
    protected string $tableName = 'plans';

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
                ]),
        ];
    }

    public function columns(): array
    {

        $columns = [];

        if($this->for == 'me') {
            return [
                Column::make('Title')
                    ->sortable()
                    ->excludeFromSelectable(),
                Column::make('Amount', 'amount')
                    ->excludeFromSelectable(),
                Column::make('Price', 'price')
                    ->excludeFromSelectable(),
                Column::make('Actions')
                    ->excludeFromSelectable(),
            ];
        }

        return [
            Column::make('ID')
                ->sortable()
                ->excludeFromSelectable(),
            Column::make('Title')
                ->sortable()
                ->excludeFromSelectable(),
            Column::make('Status', 'status')
                ->excludeFromSelectable(),
            Column::make('Featured', 'featured'),
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
        if($this->for === 'me') {
            return auth()->user()->plans()->getQuery()->where('end_date', '>', now())->orWhere('end_date', null)
                    ->when($this->getFilter('search'), fn ($query, $search) => $query->search($search))
                    ->when($this->getFilter('status'), fn ($query, $status) => $query->where('status', $status));
        }

        return Plan::query()
            ->when($this->for === 'shop', fn($query, $value) => $query->where('shop_id', MyShop::getShopID()))
            ->when($this->getFilter('search'), fn ($query, $search) => $query->search($search))
            ->when($this->getFilter('status'), fn ($query, $status) => $query->where('status', $status));
      }

    public function rowView(): string
    {
        if($this->for === 'me') {
            return 'frontend.dashboard.plans.row-me';

        }

        return 'frontend.dashboard.plans.row';
    }

    public function cancelPlan($user_subscription_id) {

        if($this->for === 'me') {
            $plan_subscription = auth()->user()->plan_subscriptions->where('id', $user_subscription_id)->first();

            if(!empty($plan_subscription)) {
                // TODO: This should depend on the order <-> last invoice
                $plan_subscription->end_date = Carbon::now()->addDays(7)->timestamp;
            }

            $plan_subscription->save();

            PlanSubscriptionCanceled::dispatch($plan_subscription);

            $this->inform(translate('Subscription plan successfully canceled!'), '', 'success');
        }

        return false;
    }
}
