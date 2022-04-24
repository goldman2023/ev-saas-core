<?php

namespace App\Http\Livewire\Dashboard\Tables;

use App\Enums\AttributeTypeEnum;
use App\Enums\StatusEnum;
use App\Facades\MyShop;
use App\Models\Attribute;
use App\Models\BlogPost;
use App\Models\Order;
use App\Models\Orders;
use App\Models\Plan;
use App\Traits\Livewire\DispatchSupport;
use DB;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Filter;

class AttributesTable extends DataTableComponent
{
    use DispatchSupport;

    // public $for = 'me';
    public ?int $searchFilterDebounce = 800;

    public string $defaultSortColumn = 'created_at';

    public string $defaultSortDirection = 'desc';

    public bool $columnSelect = true;

    public int $perPage = 25;

    public array $perPageAccepted = [10, 25, 50, 100];

    public ?string $content = null;

    public array $filterNames = [
        'type' => 'Type',
        'filterable' => 'Filterable',
        'has_schema' => 'Has Schema',
    ];

    public array $bulkActions = [

    ];

    protected string $pageName = 'attributes';

    protected string $tableName = 'attributes';

    public function mount()
    {
        $this->content_type = base64_decode(request()->content_type);
    }

    public function filters(): array
    {
        return [
            'type' => Filter::make('Type')
                ->select(array_merge(['' => translate('All')], AttributeTypeEnum::labels())),
            'filterable' => Filter::make('Filterable')
                ->select([
                    '' => translate('All'),
                    1 => translate('Yes'),
                    0 => translate('No'),
                ]),
            'has_schema' => Filter::make('Has Schema')
                ->select([
                    '' => translate('All'),
                    1 => translate('Yes'),
                    0 => translate('No'),
                ]),
        ];
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
            Column::make('Type')
                ->excludeFromSelectable(),
            Column::make('Filterable', 'filterable')
                ->excludeFromSelectable(),
            Column::make('Created', 'created_at')
                ->sortable(),
            Column::make('Actions')
                ->excludeFromSelectable(),
        ];
    }

    public function query(): Builder
    {
        return Attribute::query()->where('content_type', $this->content_type)
            //->when($this->for === 'me', fn($query, $value) => $query->where('user_id', auth()->user()?->id ?? null))
            // ->when($this->for === 'shop', fn($query, $value) => $query->where('shop_id', MyShop::getShopID()))
            ->when($this->getFilter('search'), fn ($query, $search) => $query->search($search))
            ->when($this->getFilter('type'), fn ($query, $type) => $query->where('type', $type))
            ->when($this->getFilter('filterable'), fn ($query, $filterable) => $query->where('filterable', $filterable))
            ->when($this->getFilter('has_schema'), fn ($query, $has_schema) => $query->where('is_schema', $has_schema));
    }

    public function rowView(): string
    {
        return 'frontend.dashboard.attributes.row';
    }

    public function removeAttribute($id)
    {
        $attribute = Attribute::findOrFail($id);

        DB::beginTransaction();

        // TODO: Add delete modal with warning - don't forget to prevent attributedeletion IF attribute is used for variations in any content_type!!!

        try {
            $attribute->delete();

            DB::commit();

            $this->toastify(translate('Attribute successfully deleted!'), 'success');
        } catch (\Exception $e) {
            dd($e);
            $this->dispatchGeneralError(translate('here was an error while deleting an attribute and it\'s translations, values and relationships: '.$e->getMessage()));
            $this->toastify(translate('There was an error while deleting an attribute and it\'s translations, values and relationships: '.$e->getMessage()), 'danger');
        }
    }
}
