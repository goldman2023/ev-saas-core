<?php

namespace App\Http\Livewire\Dashboard\Tables;

use DB;
use StripeService;
use App\Models\Order;
use App\Models\Orders;
use App\Facades\MyShop;
use App\Models\Product;
use App\Enums\StatusEnum;
use App\Enums\ProductTypeEnum;
use App\Traits\Livewire\CanDelete;
use App\Traits\Livewire\DispatchSupport;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Filter;
use Rappasoft\LaravelLivewireTables\DataTableComponent;

class ProductsTable extends DataTableComponent
{
    use DispatchSupport;
    use CanDelete;

    public ?int $searchFilterDebounce = 800;

    public string $defaultSortColumn = 'created_at';

    public string $defaultSortDirection = 'desc';

    public bool $columnSelect = true;

    public int $perPage = 10;

    public array $perPageAccepted = [10, 25, 50];

    public array $filterNames = [
        'status' => 'Status',
    ];

    public array $bulkActions = [];

    protected string $pageName = 'products';

    protected string $tableName = 'products';

    public function mount($for = 'shop')
    {
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
            'type' => Filter::make('Type')
                ->select([
                    '' => translate('All'),
                    ProductTypeEnum::digital()->value => translate('Digital'),
                    ProductTypeEnum::standard()->value => translate('Standard'),
                    ProductTypeEnum::course()->value => translate('Course'),
                    ProductTypeEnum::event()->value => translate('Event'),
                    ProductTypeEnum::bookable_service()->value => translate('Bookable'),
                ]),
        ];
    }

    public function columns(): array
    {
        return [

            Column::make('Image')
                ->excludeFromSelectable(),
            Column::make('Title', 'name')
                ->excludeFromSelectable(),
            Column::make('Status', 'status')
                ->excludeFromSelectable(),
            Column::make('Price', 'price')
                ->excludeFromSelectable(),
            // Column::make('Type', 'type')
            //     ->excludeFromSelectable(),
            Column::make('Views', 'views')
                ->excludeFromSelectable(),
            Column::make('Last Update', 'updated_at'),
            Column::make('Actions')
                ->excludeFromSelectable(),
        ];
    }

    public function query(): Builder
    {
        return Product::query()
            // ->when($this->for === 'me', fn ($query, $value) => $query->where('user_id', auth()->user()?->id ?? null))
            // ->when($this->for === 'shop', fn ($query, $value) => $query->where('shop_id', MyShop::getShopID()))
            ->when($this->getFilter('search'), fn ($query, $search) => $query->search($search))
            ->when($this->getFilter('status'), fn ($query, $status) => $query->where('status', $status))
            ->when($this->getFilter('type'), fn ($query, $type) => $query->where('type', $type));
    }

    public function rowView(): string
    {
        return 'frontend.dashboard.products.row';
    }

    public function importToStripe($id)
    {
        try {
            $model = Product::findOrFail($id);

            if (StripeService::saveStripeProduct($model)) {
                $this->inform(translate('Successfully imported to Stripe!'), '', 'fail');
            }
        } catch (\Exception $e) {
            $this->inform(translate('Could not import to Stripe account'), $e->getMessage(), 'fail');
        }
    }

    public function duplicateProduct($id)
    {
        $product = Product::find($id);

        DB::beginTransaction();

        try {
            $clone = $product->duplicate();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            $this->inform(translate('Could not duplicate item...'), $e->getMessage(), 'fail');
            dd($e);
        }

        $this->emit('refreshDatatable');
    }
}
