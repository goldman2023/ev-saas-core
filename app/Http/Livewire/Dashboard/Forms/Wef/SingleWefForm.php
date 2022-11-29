<?php

namespace App\Http\Livewire\Dashboard\Forms\Wef;

use DB;
use Str;
use URL;
use Uuid;
use App\Models\User;
use Livewire\Component;
use App\Models\CoreMeta;
use App\Models\WeBaseModel;
use App\Traits\Livewire\RulesSets;
use App\Traits\Livewire\DispatchSupport;
use Illuminate\Support\Facades\Notification;

class SingleWefForm extends Component
{
    use RulesSets;
    use DispatchSupport;

    public $subject;
    public $wef;
    public $dataType;
    public $template; // inline, form
    public $class;

    protected $listeners = ['refreshWEF' => '$refresh'];

    protected function rules()
    {
        return [
            'subject' => ['required'],
            'wef' => ['required'],
            'dataType' => ['required']
        ];
    }

    protected function messages()
    {
        return [
            'subject.required' => translate('Subject related to meta field is required'),
            'wef.required' => translate('Meta field is required'),
            'dataType.required' => translate('Meta field data type is requried'),
        ];
    }

    /**
     * Create a new component instance.
     *
     * @param mixed|null $user
     * @param string $class
     * @return void
     */
    public function mount($subject, $wef, $dataType, $template = 'form', $class = '') {
        $this->subject = $subject;
        $this->dataType = $dataType;
        $this->template = $template;
        $this->class = $class;
        
        if(!empty($subject) && $subject instanceof WeBaseModel) {
            if($wef instanceof CoreMeta) {
                $this->wef = $wef;
            } else if(is_string($wef)) {
                $this->wef = $subject->getWEF($wef, true, $dataType);

                // If desired WEF is not found in database for given $subject and $key, create it!
                if(empty($this->wef)) {
                    $subject->setWEF($wef, null, $dataType); // Create wef for given $key and $subject
                    $this->wef = $subject->getWEF($wef, true, $dataType); // fetch the wef now
                }
            }
            
        }
    }

    public function dehydrate()
    {
        // $this->dispatchBrowserEvent('init-form');
    }

    public function saveWEF() {

    }

    public function render()
    {
        return view('livewire.dashboard.forms.wef.single-wef-form');
    }
}
