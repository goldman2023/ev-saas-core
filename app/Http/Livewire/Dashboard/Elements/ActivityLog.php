<?php

namespace App\Http\Livewire\Dashboard\Elements;

use Livewire\Component;
use Spatie\Activitylog\Models\Activity;

class ActivityLog extends Component
{
    public $acitivites;
    public $causer;
    public $subject;
    public $scope;
    public $per_page;
    public $title;

    public function rules() {
        return [
            'activities' => ''
        ];
    }

    public function mount($scope = 'all', $causer = null, $subject = null, $per_page = 10, $title = null)
    {
        $this->scope = $scope;
        $this->subject = $subject;
        $this->causer = $causer;
        $this->per_page = $per_page;
        if($title) {
            $this->title = $title;
        } else {
            $this->title = translate('Real-Time') .' '. get_site_name() .' '. translate('Activity');
        }

        $this->acitivites = $this->query()->get();
        // dd($this->activities);
    }

    public function render()
    {
        return view('livewire.dashboard.elements.activity-log');
    }

    protected function query() {
        $query = Activity::latest();

        if(!empty($this->causer) && isset($this->causer->id)) {
            $query->where([
                ['causer_id', $this->causer->id],
                ['causer_type', $this->causer::class],
            ]);
        } else if(!empty($this->subject) && isset($this->subject->id)) {
            $query->where([
                ['subject_id', $this->subject->id],
                ['subject_type', $this->subject::class],
            ]);
        } else if(auth()->user()?->isAdmin()) {
            if($this->scope === 'all') {
                $query->whereNotNull('causer_id');
            }
        } else if(auth()->user()?->isSeller()) {
            // show some activity for seller...
        }

        return $query->take($this->per_page);
    }


}
