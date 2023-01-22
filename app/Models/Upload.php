<?php

namespace App\Models;

use IMG;
use MyShop;
use Storage;
use WEF;
use App\Traits\CoreMetaTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;

class Upload extends WeBaseModel
{
    use SoftDeletes;
    use CoreMetaTrait;
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

    public function orders()
    {
        return $this->morphedByMany(Order::class, 'subject', 'uploads_content_relationships')
            ->withPivot('relation_type', 'group_id', 'order');
    }

    // public function products()
    // {
    //     return $this->morphedByMany(Product::class, 'subject', 'uploads_content_relationships', 'subject_id')
    //         ->withPivot(['relation_type', 'order', 'group_id']);
    // }

    public function related()
    {
        return $this->hasMany(UploadsContentRelationship::class);
    }

    /**
     * Generates URL for the Upload model.
     * If Upload is image, it'll be proxified through IMGProxyService using desired $options (otherwise default options for `thumbnail` sizes will be used)
     * If Upload is not an image, it'll generate URL using Storage facade.
     *
     * @param array $options
     * @return string
     */
    public function url(array $options = [], $proxify = true): string
    {
        if (($this->attributes['type'] ?? null) === 'image') {
            return IMG::get($this, IMG::mergeWithDefaultOptions($options, 'thumbnail'), proxify: $proxify);
        }

        return Storage::disk(config('filesystems.default'))->url($this->attributes['file_name'] ?? '');
    }

    /**
     * Local Scopes
     */
    public function scopeNewest($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    public function scopeOldest($query)
    {
        return $query->orderBy('created_at', 'asc');
    }

    public function scopeSmallest($query)
    {
        return $query->orderBy('file_size', 'asc');
    }

    public function scopeLargest($query)
    {
        return $query->orderBy('file_size', 'desc');
    }

    public function scopeOnlyImages($query)
    {
        return $query->where('type', 'image');
    }

    public function scopeOnlyDocuments($query)
    {
        return $query->where('type', 'document');
    }
    // END Local Scopes


    public function toJSONMedia() {
        return [
            'id' => $this?->id ?? '',
            'file_name' => $this?->file_name ?? '',
            'extension' => $this?->extension ?? '',
            'file_size' => $this?->file_size ?? 0,
            'type' => $this?->type ?? null,
            'file_original_name' => $this?->file_original_name ?? '',
        ];
    }

    public function getWEFDataTypes() {
        return WEF::bundleWithGlobalWEF(apply_filters('upload.wef.data-types', [
            'upload_tag' => 'string',
        ]));
    }
}
