<?php

namespace App\Http\Livewire\Dashboard\Tables;

use Carbon;
use Log;
use App\Enums\StatusEnum;
use App\Facades\MyShop;
use App\Models\BlogPost;
use App\Models\Order;
use App\Models\Orders;
use App\Models\License;
use App\Traits\Livewire\DispatchSupport;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Filter;

class LicensesTable extends DataTableComponent
{
    use DispatchSupport;

    public $for = 'me';
    public ?int $searchFilterDebounce = 800;
    public string $defaultSortDirection = 'desc';
    public bool $columnSelect = true;
    public int $perPage = 10;
    public array $perPageAccepted = [10, 25];

    public array $filterNames = [
        // 'type' => 'License Type'
    ];

    public array $bulkActions = [

    ];

    protected string $pageName = 'licenses';
    protected string $tableName = 'licenses';

    public $user;

    public bool $viewingModal = false;
    public $currentModal;

    public function mount($user) {
        $this->user = $user;

        parent::mount();

        do_action('dashboard.table.licenses.mount.end', $this->user);
    }

    public function filters(): array
    {
        return [
            // 'type' => Filter::make('Type')
            //     ->select([
            //         '' => translate('All'),
            //         StatusEnum::published()->value => translate('Published'),
            //         StatusEnum::draft()->value => translate('Draft'),
            //         StatusEnum::pending()->value => translate('Pending'),
            //         StatusEnum::private()->value => translate('Private'),
            //     ]),
        ];
    }

    public function columns(): array
    {
        $columns = apply_filters('dashboard.table.licenses.columns', [
            Column::make('ID', 'license_id')
                ->excludeFromSelectable(),
            Column::make('Serial Number', 'serial_number')
                ->excludeFromSelectable(),
        ]);

        $columns = array_merge($columns, [
            Column::make('Valid', 'ending')
                ->excludeFromSelectable(),
            Column::make('Actions')
                ->excludeFromSelectable(),
        ]);

        return $columns;
    }

    public function query(): Builder
    {
        return $this->user->licenses()->with('user_subscription')->getQuery()
                    // ->getQuery()->where('end_date', '>', now())->orWhere('end_date', null)
                    ->when($this->getFilter('search'), fn ($query, $search) => $query->search($search));
                    // ->when($this->getFilter('status'), fn ($query, $status) => $query->where('status', $status));
      }

    public function rowView(): string
    {
        return 'frontend.dashboard.plans.row-license';
    }

    // Rest of code should be Pixpro specific!
    // TODO: Create mechanism for extending any Livewire class (using Trait) - adding custom functions dynamically from the ThemeFunctions via hooks (add_filter)
    public function downloadLicense(License $license)
    {
        $response = apply_filters('license.download', $license);

        if(!empty($response['file_name'] ?? null) && !empty($response['file_contents'] ?? null)) {
            // Save file name & contents in data col
            $license->setData('file_name', $response['file_name']);
            $license->setData('file_contents', $response['file_contents']);
            $license->save();

            return response()->streamDownload(function () use($response) {
                echo $response['file_contents'];
            }, $response['file_name']);
        }

        $this->inform(translate('Error: Coudld not download latest .DAT file...'), translate('Please refresh and try again.'), 'fail');
    }

    public function disconnect(License $license) {
        do_action('license.disconnect', $license, $this->user, $this);

        $this->emit('refreshDatatable');
    }
}
