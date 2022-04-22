<?php

namespace App\Traits\Livewire;

trait CanDelete
{
    public function initializeCanDelete()
    {
        $this->listeners = array_merge($this->listeners, [
            'deleteModel' => 'deleteModel',
        ]);
    }

    public function deleteModel($model_id, $modelClass)
    {
        dd(app($modelClass)->find($model_id));

        $this->emit('refreshDatatable');
    }
}
