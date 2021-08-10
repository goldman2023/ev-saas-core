<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\UploadsContentRelationship;

class UploadsGroup extends Model
{
    use HasFactory;

    public function uploads_content_relations() {
        return $this->hasMany(UploadsContentRelationship::class, 'group_id', 'id');
    }

    public static function boot() {
        parent::boot();

        static::deleting(function($group) {
             $group->uploads_content_relations()->delete();
        });
    }
}
