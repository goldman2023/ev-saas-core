<?php

namespace App\Traits\Livewire;

trait DispatchSupport
{
    public string $toast_id = 'global-toast';
    public string $info_modal_basic_id = 'info-modal-basic';
    public string $validation_errors_toast_id = 'validation-error-toast';

    protected function toastify($msg = '', $type = 'info') {
        $this->dispatchBrowserEvent('toastit', ['id' => $this->toast_id, 'content' => $msg, 'type' => $type ]);
    }

    protected function inform($title, $text, $type) {
        $this->dispatchBrowserEvent('inform', ['id' => $this->info_modal_basic_id, 'title' => $title, 'text' => $text, 'type' => $type]);
    }

    protected function dispatchGeneralError(mixed $errors) {
        if($errors instanceof \Exception) {
            $errors = $errors->getMessage();
        }

        // TODO: Think about changing name of the Event, because GeneralError does not have to be validation related error...
        $this->dispatchBrowserEvent('validation-errors', ['errors' => [
            'general' => is_string($errors) ? [$errors] : $errors
        ]]);
    }

    protected function dispatchValidationErrors($obj) {
        if($obj instanceof \Illuminate\Validation\ValidationException) {
            $errors = $obj->validator->errors()->messages();
        } elseif($obj instanceof \Illuminate\Contracts\Validation\Validator) {
            $errors = $obj->errors()->messages();
        } else if($obj instanceof \Illuminate\Support\MessageBag) {
            $errors = $obj->messages();
        } else if($obj instanceof \Exception) {
            $errors = $obj->getMessage();
        } else {
            $errors = $obj;
        }

        // Remember: Order of the keys in assoc. array is same as the order of keys in rules()
        $this->dispatchBrowserEvent('validation-errors', ['id' => $this->validation_errors_toast_id, 'errors' => $errors]);
    }
}
