<?php

namespace App\Http\Livewire;

use File;
use Exception;
use MediaService;
use App\Models\Upload;
use Livewire\Component;
use App\Models\CoreMeta;
use Illuminate\Support\Facades\Storage;
use App\Traits\Livewire\DispatchSupport;
use Illuminate\Support\Facades\Validator;

class WefEditorModal extends Component
{
    use DispatchSupport;

    protected $paginator;

    public $target = '';

    public $subject;

    public $wefKey;
    public $wefLabel;
    public $setType;
    public $getType;
    public $formType;
    public $predefinedItems;
    public $customProperties;

    public $displayModal = false;

    public $containerClass;
    public $wrapperClass;

    protected $listeners = [
        'showWefEditorModal' => 'changeWefEditor',
    ];

    public function rules()
    {
        return [
            'subject.*' => [],
        ];
    }

    public function messages()
    {
        return [];
    }

    public function mount()
    {

    }

    public function render()
    {
        return view('livewire.wef-editor-modal');
    }

    public function changeWefEditor($data = []) {
        $this->target = $data['target'] ?? '';
        $this->wefKey = $data['wef_key'] ?? '';
        $this->wefLabel = $data['wef_label'] ?? '';
        $this->setType = $data['set_type'] ?? 'string';
        $this->getType = $data['get_type'] ?? 'string';
        $this->formType = $data['form_type'] ?? 'plain_text';
        $this->customProperties = $data['custom_properties'] ?? [];
        $this->predefinedItems = $data['predefined_items'] ?? [];
        $this->class = $data['class'] ?? '';

        if(!empty($data['subject_type'] ?? null) && !empty($data['subject_id'] ?? null) && !empty($this->wefKey)) {
            $this->subject = app(base64_decode($data['subject_type']))->find($data['subject_id']);
            $this->displayModal = true;
        }
    }
}
