<?php

namespace App\Traits\Livewire;

use App\Enums\StatusEnum;

trait HasStatus
{
    public $originalStatus;

    public function initializeHasStatus()
    {
        
    }

    public function setOriginalStatus($model)
    {
        $this->originalStatus = $model->status;
    }

    public function getStatusBadgeData($status = null) {
        if(empty($status)) {
            $status = $this->originalStatus;
        }

        $badgeData = [
            'color-class' => '',
            'label' => ''
        ];

        // TODO: Make Status enum Dynamic - so it can be overridden through ThemeFunctions
        if($this->originalStatus === StatusEnum::published()->value) {
            $badgeData = [
                'color-class' => 'badge-success',
                'label' => StatusEnum::published()->label
            ];
        } else if($this->originalStatus === StatusEnum::draft()->value) {
            $badgeData = [
                'color-class' => 'badge-warning',
                'label' => StatusEnum::draft()->label
            ];
        } else if($this->originalStatus === StatusEnum::pending()->value) {
            $badgeData = [
                'color-class' => 'badge-info',
                'label' => StatusEnum::pending()->label
            ];
        } else if($this->originalStatus === StatusEnum::private()->value) {
            $badgeData = [
                'color-class' => 'badge-dark',
                'label' => StatusEnum::private()->label
            ];
        }

        return $badgeData;
    }
}
