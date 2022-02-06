<?php

namespace App\Traits\Livewire;

trait DispatchSupport
{
    public string $toast_id = 'global-toast';

    protected function toastify($msg = '', $type = 'info') {
        $this->dispatchBrowserEvent('toastit', ['id' => $this->toast_id, 'content' => $msg, 'type' => $type ]);
    }

    protected function dispatchGeneralError(mixed $errors) {
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
        } else {
            $errors = $obj;
        }

        // Remember: Order of the keys in assoc. array is same as the order of keys in rules()
        $this->dispatchBrowserEvent('validation-errors', ['errors' => $errors]);
    }
}
