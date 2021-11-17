<?php

namespace App\Models;

use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use IMG;
use Storage;

class Upload extends EVBaseModel
{
    use SoftDeletes;
    use Cachable;

    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = [
        'file_original_name', 'file_name', 'user_id', 'extension', 'type', 'file_size',
    ];

    public function user()
    {
    	return $this->belongsTo(User::class);
    }

    public function uploads() {
        return $this->morphedByMany(Product::class, 'subject', 'uploads_content_relationships', 'subject_id', 'upload_id')
            ->withPivot('relation_type, group_id');
    }


    /**
     * Generates URL for the Upload model.
     * If Upload is image, it'll be proxified through IMGProxyService using desired $options (otherwise default options for `thumbnail` sizes will be used)
     * If Upload is not an image, it'll generate URL using Storage facade.
     *
     * @param array $options
     * @return string
     */
    public function url(array $options = []): string {
        if(($this->attributes['type'] ?? null) === 'image') {
            return IMG::get($this, IMG::mergeWithDefaultOptions($options, 'thumbnail'));
        }

        return Storage::disk(config('filesystems.default'))->url($this->attributes['file_name'] ?? '');
    }
}
