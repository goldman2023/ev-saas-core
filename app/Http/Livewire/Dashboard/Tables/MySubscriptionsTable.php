<?php

namespace App\Http\Livewire\Dashboard\Tables;

use Carbon;
use DB;
use App\Events\Plans\PlanSubscriptionCancel;
use App\Events\Plans\PlanSubscriptionRevive;
use App\Enums\UserSubscriptionStatusEnum;
use App\Facades\MyShop;
use App\Models\Order;
use App\Models\UserSubscription;
use App\Traits\Livewire\DispatchSupport;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Filter;

class MySubscriptionsTable extends DataTableComponent
{
    use DispatchSupport;

    public ?int $searchFilterDebounce = 800;
    public string $defaultSortColumn = 'created_at';
    public string $defaultSortDirection = 'desc';
    public bool $columnSelect = true;
    public int $perPage = 10;
    public $user = null;
    public array $perPageAccepted = [10, 25];
    public $hideActions = false;

    public array $filterNames = [
        'status' => 'Status'
    ];

    public array $bulkActions = [

    ];

    protected string $pageName = 'user_subscriptions';
    protected string $tableName = 'user_subscriptions';

    public function mount() {
        parent::mount();
    }

    public function filters(): array
    {
        return [
            'status' => Filter::make('Status')
                ->select(array_merge([
                    '' => translate('All'),
                ], UserSubscriptionStatusEnum::labels())),
        ];
    }

    public function columns(): array
    {
        $columns = [
            Column::make('ID')
                ->excludeFromSelectable(),
            Column::make('Title')
                ->sortable()
                ->excludeFromSelectable(),
            Column::make('Status', 'status')
                ->excludeFromSelectable(),
            Column::make('Payment status', 'payment_status')
                ->excludeFromSelectable(),
            Column::make('Amount', 'amount')
                ->excludeFromSelectable(),
            Column::make('Price', 'price')
                ->excludeFromSelectable(),
            // Column::make('Starting', 'start_date')
            //     ->excludeFromSelectable(),
            Column::make('Ending', 'end_date')
                ->excludeFromSelectable(),
        ];

        if(!$this->hideActions) {
            $columns[] = Column::make('Actions')
                ->excludeFromSelectable();
        }

        return $columns;
    }

    public function query(): Builder
    {
        return $this->user->subscriptions()->getQuery()->with(['items', 'licenses', 'order'])
            // ->where('end_date', '>', now())->orWhere('end_date', null)
            // ->when($this->getFilter('search'), fn ($query, $search) => $query->search($search))
            ->when($this->getFilter('status'), fn ($query, $status) => $query->where('status', $status));
      }

    public function rowView(): string
    {
        return 'frontend.dashboard.user-subscriptions.row-subscription';
    }

    // public function cancelPlan($user_subscription_id) {

    //     if($this->for === 'me') {
    //         $plan_subscription = auth()->user()->plan_subscriptions->where('id', $user_subscription_id)->first();

    //         try {
    //             if(!empty($plan_subscription)) {
    //                 PlanSubscriptionCancel::dispatch($plan_subscription);
    //             } else {
    //                 throw new \Exception('Cannot find a subscription with ID: '.$user_subscription_id);
    //             }
    //         } catch(\Exception $e) {
    //             $this->inform(translate('Error: Cannot cancel a subscription...'), $e->getMessage(), 'fail');
    //             return false;
    //         }

    //         $end_date = Carbon::createFromTimestamp($plan_subscription->end_date)->format('d. M Y, H:i');
    //         $this->inform(translate('Subscription plan successfully canceled!'), 'Have in mind that you can still use the plan before ending period: '.$end_date, 'success', 5000);
    //     }
    // }

    // public function revivePlan($user_subscription_id) {

    //     if($this->for === 'me') {
    //         $plan_subscription = auth()->user()->plan_subscriptions->where('id', $user_subscription_id)->first();

    //         try {
    //             if(!empty($plan_subscription)) {
    //                 PlanSubscriptionRevive::dispatch($plan_subscription);
    //             } else {
    //                 throw new \Exception('Cannot find a subscription with ID: '.$user_subscription_id);
    //             }
    //         } catch(\Exception $e) {
    //             $this->inform(translate('Error: Cannot revive a subscription...'), $e->getMessage(), 'fail');
    //             return false;
    //         }

    //         $this->inform(translate('Subscription plan successfully revived!'), '', 'success', 5000);
    //     }
    // }
}
