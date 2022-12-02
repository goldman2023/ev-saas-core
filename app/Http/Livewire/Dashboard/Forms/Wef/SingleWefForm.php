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
    public $wefKey;
    public $wefValue;
    public $wefLabel;
    public $dataType; // this data type of wef used for get/st casting from.to database
    public $formType; // this is form type of wef used for display (e.g. check AttributeTypeEnum )
    public $template; // inline, form
    public $positioning; // horizontal, vertical
    public $showForm;
    public $customProperties;
    public $predefinedItems;
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
    public function mount($subject, $wefKey, $wefLabel = '', $dataType = 'string', $formType = 'plain_text', $template = 'form', $positioning = 'horizontal', $customProperties = [], $showForm = false, $predefinedItems = [], $target = null, $class = '') {
        $this->showForm = $showForm;
        $this->subject = $subject;
        $this->wefKey = $wefKey;
        $this->wefLabel = $wefLabel;
        $this->dataType = $dataType;
        $this->formType = $formType;
        $this->template = $template;
        $this->positioning = $positioning;
        $this->customProperties = $customProperties;
        $this->predefinedItems = $predefinedItems;
        $this->target = $target;
        $this->class = $class;
        
        if(!empty($subject) && $subject instanceof WeBaseModel && !empty($wefKey)) {
            $this->wefValue = $subject->getWEF($wefKey, true, $dataType);

            // If desired wefValue is not found in database for given $subject and $key, create it!
            if(empty($this->wefValue)) {
                $subject->setWEF($wefKey, null, $dataType); // Create wef for given $key and $subject
                $this->wefValue = $subject->getWEF($wefKey, true, $dataType); // fetch the wef now
            }
            
        }
    }

    public function dehydrate()
    {
        // $this->dispatchBrowserEvent('init-form');
    }

    public function saveWEF() {
        if($this->formType === 'text_list') {
            // For text lists, remove empty items in array
            $this->wefValue = array_values(array_filter($this->wefValue));
        }

        if($this->wefValue == 'null') {
            $this->wefValue = null;
        }

        $this->subject->setWEF($this->wefKey, $this->wefValue, $this->dataType); // set WEF
        $this->showForm = false;

        // If $target is not empty, dispatch Browser event to update frontend
        if(!empty($this->target)) {
            $this->dispatchBrowserEvent('wef-replace-value-on-frontend', [
                'target' => $this->target,
                'wef_value' => $this->subject->getWEF($this->wefKey, true, $this->dataType)
            ]);
        }
    }

    public function render()
    {
        return view('livewire.dashboard.forms.wef.single-wef-form');
    }
}
