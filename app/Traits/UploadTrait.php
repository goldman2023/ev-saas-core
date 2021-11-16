<?php

namespace App\Traits;

use IMG;
use Illuminate\Support\Collection;
use App\Models\Upload;
use App\Models\UploadsContentRelationship;
use App\Models\UploadsGroup;

trait UploadTrait
{
    /**
     * Boot the trait
     *
     * @return void
     */
    protected static function bootUploadTrait()
    {
        // When model data is retrieved, populate model stock data!
        static::retrieved(function ($model):void {
            $model->load('uploads');
        });
    }

    /************************************
     * Uploads Relation Functions *
     ************************************/
    public function uploads() {
        return $this->morphToMany(Upload::class, 'subject', 'uploads_content_relationships', 'subject_id', 'upload_id')
            ->withPivot('type AS toc', 'group_id');
    }
}
