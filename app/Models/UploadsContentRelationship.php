<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Upload;
use App\Models\UploadsGroup;

class UploadsContentRelationship extends Model
{
    use HasFactory;

    public function file() {
        return $this->belongsTo(Upload::class, 'upload_id', 'id');        
    }

    public function group() {
        return $this->belongsTo(UploadsGroup::class, 'group_id', 'id');
    }
}
