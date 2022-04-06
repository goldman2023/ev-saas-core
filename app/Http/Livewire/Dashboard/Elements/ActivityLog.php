<?php

namespace App\Http\Livewire\Dashboard\Elements;

use Livewire\Component;
use Spatie\Activitylog\Models\Activity;

class ActivityLog extends Component
{
    public $acitivites;
    public $scope;

    public function mount($scope = 'all') {
        $this->scope = $scope;
        if($this->scope == 'all') {
            $this->acitivites = Activity::latest()->whereNotNull('causer_id')->take(10)->get();

        } else if($scope == 'seller') {
        $this->acitivites = Activity::latest()->whereNotNull('causer_id')->take(10)->get();

        } else {
            $this->scope = 'customer';
        }

    }

    public function render()
    {
        return view('livewire.dashboard.elements.activity-log');
    }
}
