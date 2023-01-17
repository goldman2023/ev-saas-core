<?php

namespace App\Models;

use WEF;
use App\Traits\UploadTrait;
use App\Traits\GalleryTrait;
use App\Traits\CoreMetaTrait;
use Spatie\Sluggable\HasSlug;
use App\Traits\HasContentColumn;
use App\Traits\SocialCommentsTrait;
use  Spatie\Sluggable\SlugOptions;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Task extends WeBaseModel
{
    use HasFactory;
    use UploadTrait;
    use GalleryTrait;
    use CoreMetaTrait;
    use SoftDeletes;
    use HasSlug;
    use LogsActivity;
    use HasContentColumn;
    use SocialCommentsTrait;

    protected $table = 'tasks';

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    public function creator(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function assignee() {
        return $this->belongsTo(User::class, 'assignee_id');
    }

    public function orders() {
        return $this->morphedByMany(Order::class, 'subject', 'task_relationships');
    }


    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults();
    }

    public function getDynamicModelUploadProperties(): array
    {
        return [
            [
                'property_name' => 'documents',
                'relation_type' => 'documents',
                'multiple' => true,
            ],
            [
                'property_name' => 'attachments',
                'relation_type' => 'attachments',
                'multiple' => true,
            ]
        ];
    }

    public function getWEFDataTypes() {
        return WEF::bundleWithGlobalWEF(apply_filters('task.wef.data-types', []));
    }
}
