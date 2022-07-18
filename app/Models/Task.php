<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Traits\UploadTrait;
use App\Traits\CoreMetaTrait;
use App\Traits\GalleryTrait;
use Spatie\Sluggable\HasSlug;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use HasFactory;
    use UploadTrait;
    use GalleryTrait;
    use CoreMetaTrait;
    use SoftDeletes;
    use HasSlug;
    use LogsActivity;

    protected $table = 'tasks';

    public function creator(){

        return $this->belongsTo(User::class, 'foreign_key');
    }

    public function assigne(){
        return $this->belongsTo(User::class, 'foreign_key');
    }
   
    public function subject(){
        return $this->morphTo('subject');
    }

    public function getDynamicModelUploadProperties(): array
    {
        return [
            [
                'property_name' => 'documents',
                'relation_type' => 'documents',
                'multiple' => true,
            ]
        ];
    }
}
