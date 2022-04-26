<?php

namespace App\Http\Livewire\Modals;

use App\Traits\Livewire\DispatchSupport;
use Livewire\Component;

class DeleteModal extends Component
{
    use DispatchSupport;

    public $model_id;

    public $model_class;

    public $title;

    public $text;

    protected $listeners = [
        'deleteModel' => 'deleteModel',
    ];

    public function mount()
    {
        $this->title = translate('Trash item');
        $this->text = translate('Are you sure you want to trash this item?');
    }

    protected function rules()
    {
        return [
            'model_id' => 'nullable',
            'model_class' => 'nullable',
            'title' => 'nullable',
            'text' => 'nullable',
        ];
    }

    protected function messages()
    {
        return [];
    }

    public function render()
    {
        return view('livewire.modals.delete-modal');
    }

    public function deleteModel($model_id, $modelClass)
    {
        $modelClass = base64_decode($modelClass);

        try {
            // if(!Permissions::canAccess(User::$non_customer_user_types, ['delete_product'], false)) {
            //     // If user does not have a permission to delete product, throw an error
            //     throw new \Exception(translate("You don't have enough permissions to delete this item"));
            // }

            $model = app($modelClass)->findOrFail($model_id);

            $model->delete();

            $this->inform(translate('Item successfully deleted!'), '', 'success');
        } catch (\Throwable $e) {
            $this->inform(translate('Could not delete item(s)!'), $e->getMessage(), 'fail');
        }

        $this->dispatchBrowserEvent('delete-modal-hide');
        $this->emit('refreshDatatable');
    }
}
