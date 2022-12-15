<?php

namespace App\Http\Livewire\Dashboard\Tables;

use Log;
use Carbon;
use App\Models\Order;
use App\Models\Orders;
use App\Facades\MyShop;
use App\Models\License;
use App\Models\BlogPost;
use App\Enums\StatusEnum;
use Yoast\WP\Lib\Migrations\table;
use App\Traits\Livewire\DispatchSupport;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Filter;
use Rappasoft\LaravelLivewireTables\DataTableComponent;

class LicensesTable extends DataTableComponent
{
    use DispatchSupport;

    public $for = 'me';
    public ?int $searchFilterDebounce = 800;
    public string $defaultSortDirection = 'desc';
    public bool $columnSelect = true;
    public int $perPage = 10;
    public array $perPageAccepted = [10, 25];
    public $status = 'active';
    public $only_expired = false;

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

    public function mount($user = null, $status = 'active' , $for = 'me', $only_expired = false) {
        $this->user = $user;
        $this->status = $status;
        $this->for = $for;
        $this->only_expired = $only_expired;

        parent::mount();
        if($this->user) {
            do_action('dashboard.table.licenses.mount.end', $this->user);
        }
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
            Column::make('Type', 'license_id')
                ->excludeFromSelectable(),
            Column::make('Cloud Services', 'data')
                ->excludeFromSelectable(),
            Column::make('Offline Services', 'data')
                ->excludeFromSelectable(),
            Column::make('Hardware ID', 'had')
                ->excludeFromSelectable(),
            Column::make('Serial Number', 'serial_number')
                ->excludeFromSelectable(),
        ]);

        $columns = array_merge($columns, [
            Column::make('Valid', 'ending')

        ]);
        if(auth()->user()->isAdmin()) {
            $columns = array_merge($columns, [
                Column::make('Actions')
                    ->excludeFromSelectable(),
            ]);
        }


        return $columns;
    }

    public function query()
    {
        if($this->user) {
            $query = $this->user->licenses()->with('user_subscription')->getQuery()
            // ->getQuery()->where('end_date', '>', now())->orWhere('end_date', null)
            ->when($this->getFilter('search'), fn ($query, $search) => $query->search($search));
            // ->when($this->getFilter('status'), fn ($query, $status) => $query->where('status', $status));

        } else {

            if($this->only_expired) {

            }
            $start_date = date('Y-m-d H:i:s');
            $end_date = date("Y-m-d 23:59:59", strtotime('-3 days', strtotime($start_date)));

            $query = License::with('user_subscription');

            if($this->only_expired) {
                $query = $query->whereDate('data->expiration_date', '<', $end_date)
                ->orderBy('updated_at', 'DESC');
            }

            // ->getQuery()->where('end_date', '>', now())->orWhere('end_date', null)
            // ->when($this->getFilter('search'), fn ($query, $search) => $query->search($search));
            // ->when($this->getFilter('status'), fn ($query, $status) => $query->where('status', $status));
        }


        return $query;
      }

    public function rowView(): string
    {
        $view = 'frontend.dashboard.licenses.row-license';
        if(auth()->user()->isAdmin()) {
            $view = 'frontend.dashboard.licenses.row-license-admin';
        }
        return $view;
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

    public function removeLicense(License $license) {
        do_action('license.remove', $license, $this->user, $this);

        $this->emit('refreshDatatable');
    }
}
