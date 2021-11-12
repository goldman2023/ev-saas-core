<?php

namespace App\Traits;

use IMG;
use Illuminate\Support\Collection;
use App\Models\Upload;
use App\Models\UploadsContentRelationship;
use App\Models\UploadsGroup;

trait UploadTrait
{
    /*
     * Get all Uploads related to the Model
     */
    public function uploads() {
        return $this->morphToMany(Upload::class, 'subject', 'uploads_content_relationships', 'subject_id', 'upload_id')
            ->withPivot('type AS toc', 'group_id');
    }
}
