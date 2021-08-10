<?php


namespace App\Traits;


use App\Models\UploadsContentRelationship;
use App\Models\UploadsGroup;

trait GalleryTrait
{    
    public function uploads_groups() {
        return $this->hasMany(UploadsGroup::class, 'user_id', 'user_id');
    }

    public function gallery_uploads_groups() {
        return $this->hasMany(UploadsGroup::class, 'user_id', 'user_id')->where('type', 'gallery');
    }

    public function document_uploads_groups() {
        return $this->hasMany(UploadsGroup::class, 'user_id', 'user_id')->where('type', 'document');
    }
}
