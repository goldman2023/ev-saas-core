<?php

namespace App\Http\Livewire\Dashboard\Elements;

use Livewire\Component;
use Spatie\Activitylog\Models\Activity;

class ActivityLog extends Component
{
    public $acitivites;

    public function mount() {
        $this->acitivites = Activity::latest()->whereNotNull('causer_id')->take(10)->get();

    }

    public function render()
    {
        return view('livewire.dashboard.elements.activity-log');
    }
}
