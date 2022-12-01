<?php

namespace App\Http\Livewire;

use File;
use Exception;
use MediaService;
use App\Models\Upload;
use Livewire\Component;
use Illuminate\Support\Facades\Storage;
use App\Traits\Livewire\DispatchSupport;
use Illuminate\Support\Facades\Validator;

class WeMediaEditor extends Component
{
    use DispatchSupport;

    protected $paginator;

    public $for_id = '';

    public $subject;

    public $upload;

    public $display = 'modal'; // modal, inline

    public $displayModal = false;

    public $containerClass;
    public $wrapperClass;

    protected $listeners = [
        'showMediaEditor' => 'changeMediaEditor',
    ];

    public function rules()
    {
        return [
            'subject.*' => [],
            'upload.*' => [],
        ];
    }

    public function messages()
    {
        return [];
    }

    public function mount($display = 'modal')
    {
        $this->display = $display;
        
        $this->displayModal = false;
        $this->containerClass = 'fixed z-[10000] inset-0 overflow-y-auto';
        $this->wrapperClass = 'fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity';
    }

    public function render()
    {
        return view('livewire.we-media-editor');
    }

    public function changeMediaEditor($for_id, $subject_id, $subject_type, $upload_id)
    {
        $this->for_id = $for_id;
        $this->subject = app(base64_decode($subject_type))->find($subject_id);
        $this->upload = Upload::find($upload_id);

        $this->dispatchBrowserEvent('display-media-editor-modal');
    }

    public function saveUpload()
    {
        
    }
}
