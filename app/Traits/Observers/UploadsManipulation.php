<?php

namespace App\Traits\Observers;

use App\Models\Upload;
use Illuminate\Database\Eloquent\Collection;

trait UploadsManipulation
{
    public function removeModelUploads(&$model) {
        if(!empty($model?->uploads ?? [])) {
            
        }
    }
}
