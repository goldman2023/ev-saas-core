<?php

namespace App\Models;

use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use IMG;
use Storage;
use MyShop;

class Upload extends EVBaseModel
{
    use SoftDeletes;
    // use Cachable;

    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = [
        'file_original_name', 'file_name', 'user_id', 'shop_id', 'extension', 'type', 'file_size',
    ];

    protected static function booted()
    {
        static::addGlobalScope('uploads_from_my_shop', function ($builder) {
            // if(request()->is_dashboard) { // get uploads from my shop if user is in dashboard
            //     $builder->where('shop_id', '=', auth()->user()->shop()->noEagerLoads()->first()->id ?? -1);
            // }
        });
    }

    /*
     * Scope searchable parameters
     */
    public function scopeSearch($query, $term)
    {
        return $query->where(
            fn ($query) =>  $query->where('file_original_name', 'like', '%'.$term.'%')
        );
    }


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

    /**
     * Local Scopes
     */
    public function scopeNewest($query) {
        return $query->orderBy('created_at', 'desc');
    }

    public function scopeOldest($query) {
        return $query->orderBy('created_at', 'asc');
    }

    public function scopeSmallest($query) {
        return $query->orderBy('file_size', 'asc');
    }

    public function scopeLargest($query) {
        return $query->orderBy('file_size', 'desc');
    }
}
