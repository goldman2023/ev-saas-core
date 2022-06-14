<?php

namespace App\Http\Livewire\Dashboard\Tables;

use Carbon;
use App\Enums\UserTypeEnum;
use App\Events\Plans\PlanSubscriptionCancel;
use App\Events\Plans\PlanSubscriptionRevive;
use App\Enums\StatusEnum;
use App\Facades\MyShop;
use App\Models\User;
use App\Traits\Livewire\DispatchSupport;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Filter;

class UsersTable extends DataTableComponent
{
    use DispatchSupport;

    public $for = 'staff'; // all, staff, customers
    public ?int $searchFilterDebounce = 800;
    public string $defaultSortColumn = 'users.created_at';
    public string $defaultSortDirection = 'desc';
    public bool $columnSelect = true;
    public int $perPage = 10;
    public array $perPageAccepted = [10, 25];

    public array $filterNames = [
        // 'status' => 'Status'
    ];

    public array $bulkActions = [];

    protected string $pageName = 'users';
    protected string $tableName = 'users';

    public function mount($for = 'staff')
    {
        $this->for = $for;

        if ($for === 'staff') {
            $this->filters = [
                'user_types' => UserTypeEnum::staff()->value
            ];
        } else if ($for === 'customer') {
            $this->filters = [
                'user_types' => UserTypeEnum::customer()->value
            ];
        }

        parent::mount();
    }

    public function filters(): array
    {
        $filters = [];

        if (auth()->user()->user_type === UserTypeEnum::admin()->value) {
            $filters['user_types'] = Filter::make('Users Type')
                ->select([
                    '' => translate('All'),
                    UserTypeEnum::admin()->value => translate('Admin'),
                    UserTypeEnum::moderator()->value => translate('Moderator'),
                    UserTypeEnum::seller()->value => translate('Seller'),
                    UserTypeEnum::staff()->value => translate('Staff'),
                    UserTypeEnum::customer()->value => translate('Customer')
                ]);
        } else if (auth()->user()->user_type === UserTypeEnum::seller()->value) {
            $filters['user_types'] = Filter::make('Users Type')
                ->select([
                    '' => translate('All'),
                    UserTypeEnum::staff()->value => translate('Staff'),
                    UserTypeEnum::customer()->value => translate('Customers')
                ]);
        } else if (auth()->user()->user_type === UserTypeEnum::staff()->value) {
            // add: && Permissions::canAccess({params for managing staff/users})
        }

        return $filters;
    }

    public function columns(): array
    {
        return [
            Column::make('ID')
                ->sortable()
                ->excludeFromSelectable(),
            Column::make('Name')
                ->sortable()
                ->excludeFromSelectable(),
            Column::make('Status', 'license')
                ->excludeFromSelectable(),
            Column::make('Trial', 'email_verified_at')
                ->excludeFromSelectable(),
            Column::make('Type', 'user_type')
                ->excludeFromSelectable(),
            Column::make('Entity', 'entity')
                ->excludeFromSelectable(),


            Column::make('Created', 'created_at')
                ->sortable(),
            Column::make('Actions')
                ->excludeFromSelectable(),
        ];
    }

    public function query(): Builder
    {
        return User::query()
            ->when($this->getFilter('search'), fn ($query, $search) => $query->search($search))
            ->when($this->getFilter('user_types'), fn ($query, $user_type) => $query->where('user_type', $user_type));
    }

    public function rowView(): string
    {
        return 'frontend.dashboard.users.row';
    }
}
