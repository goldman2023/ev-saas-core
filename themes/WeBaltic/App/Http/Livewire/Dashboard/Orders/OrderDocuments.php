<?php

namespace WeThemes\WeBaltic\App\Http\Livewire\Dashboard\Orders;

use Log;
use App\Models\Task;
use App\Models\Order;
use Livewire\Component;
use App\Enums\TaskStatusEnum;
use Illuminate\Support\Facades\DB;
use App\Traits\Livewire\DispatchSupport;
use App\Traits\Livewire\HasDynamicActions;
use WeThemes\WeBaltic\App\Enums\TaskTypesEnum;
use WeThemes\WeBaltic\App\Enums\DocumentUploadTagsEnum;

class OrderDocuments extends Component
{
    use DispatchSupport;
    use HasDynamicActions;

    public $order;
    public $subject;
    public $class;
    public $generatableUploadTags;
    public $documents = [];

    public function mount($order = null, $class = '')
    {
        $this->order = $order;
        $this->subject = $order;
        $this->class = $class;
       
        $this->generatableUploadTags = DocumentUploadTagsEnum::getGeneratableUploadTags();

        foreach($this->generatableUploadTags as $key => $upload_tag) {
            $this->documents[] = [
                'upload_tag' => $upload_tag,
                'upload_tag_label' => DocumentUploadTagsEnum::labels()[$key] ?? $upload_tag,
                'upload' => $this->order->getUploadsWhere('documents', wef_params: [
                    ['upload_tag', $upload_tag]
                ])
            ];
        }
    }

    public function render()
    {
        return view('livewire.dashboard.orders.order-documents');
    }

}
