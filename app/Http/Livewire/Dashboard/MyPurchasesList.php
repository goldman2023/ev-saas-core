<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;
use App\Models\Ownership;
use App\Traits\Livewire\DispatchSupport;
use Spatie\Activitylog\Models\Activity;

class MyPurchasesList extends Component
{
    use DispatchSupport;

    public $items;
    public $per_page;
    public $count;

    public function rules() {
        return [
            'items' => ''
        ];
    }

    public function mount($per_page = 10)
    {
        $this->per_page = $per_page;

        $this->items = $this->query()->get();
        $this->count = auth()->user()->owned_assets()->count();
    }

    public function render()
    {
        return view('livewire.dashboard.my-purchases-list');
    }

    protected function query() {
        return auth()->user()->owned_assets()->with(['subject', 'order', 'order.order_items'])->orderBy('created_at', 'desc')->take($this->per_page);
    }

    public function setNotifyOnUpdate($ownership_id, $should_notify = false) {
        $ownership = Ownership::my()->find($ownership_id);

        if(!empty($ownership)) {
            $ownership->notify_owner_when_updated = $should_notify === true ? true : false;
            $ownership->save();
        }
    }
}