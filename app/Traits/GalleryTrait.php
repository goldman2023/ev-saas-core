<?php

namespace App\Traits;

use IMG;
use Illuminate\Support\Collection;
use App\Models\Upload;
use App\Models\UploadsContentRelationship;
use App\Models\UploadsGroup;

trait GalleryTrait
{
    public mixed $thumbnail;
    public mixed $cover;
    public mixed $gallery;
    public mixed $meta_img;

    /**
     * Boot the trait
     *
     * @return void
     */
    protected static function bootGalleryTrait()
    {
        // When model data is retrieved, populate model prices data!
        static::retrieved(function ($model) {
            $model->getThumbnailAttribute();
            $model->getCoverAttribute();
            $model->getGalleryAttribute();
            $model->getMetaImgAttribute();
        });
    }

    /**
     * Initialize the trait
     *
     * @return void
     */
    public function initializeGalleryTrait(): void
    {
        $this->appendCoreProperties(['thumbnail', 'cover', 'gallery', 'meta_img']);
        $this->append(['thumbnail', 'cover', 'gallery', 'meta_img']);
        $this->fillable(array_unique(array_merge($this->fillable, ['thumbnail', 'cover', 'gallery', 'meta_img'])));
    }

    /**
     * Converts gallery properties from Upload model(s) to Upload ID(s)
     *
     * @return void
     */
    public function convertGalleryModelsToIDs() {
        $this->thumbnail = ($this->thumbnail instanceof Upload) ? ($this->thumbnail->id ?? null) : $this->thumbnail;
        $this->cover = ($this->cover instanceof Upload) ? ($this->cover->id ?? null) : $this->cover;
        $this->meta_img = ($this->meta_img instanceof Upload) ? ($this->meta_img->id ?? null) : $this->meta_img;

        $gallery_ids = [];
        if(($this->gallery instanceof Collection && $this->gallery->isNotEmpty()) || (is_array($this->gallery) && !empty($this->gallery))) {
            foreach($this->gallery as $img) {
                $gallery_ids[] = ($img instanceof Upload) ? ($img->id ?? null) : $img;
            }
        }
        $this->gallery = implode(',', array_unique($gallery_ids));
    }

    /******* START THUMBNAIL *******/
    public function getThumbnailAttribute() {
        if(empty($this->thumbnail)) {
            $this->thumbnail = $this->uploads->firstWhere('relation_type', 'thumbnail');
        }

        return $this->thumbnail;
    }

    /**
     * Gets the Thumbnail image URL
     *
     * @param array $options If IMGProxy is enabled, $options will be used to generate proxified image URL
     * @return mixed
     */
    public function getThumbnail(array $options = []): mixed
    {
        return IMG::get($this->thumbnail, IMG::mergeWithDefaultOptions($options, 'thumbnail'));
    }

    /******* START COVER *******/
    public function getCoverAttribute() {
        if(empty($this->cover)) {
            $this->cover = empty($this->uploads) ? null : $this->uploads->firstWhere('relation_type', 'cover');
        }

        return $this->cover;
    }

    /**
     * Gets the Cover image URL
     *
     * @param array $options If IMGProxy is enabled, $options will be used to generate proxified image URL
     * @return mixed
     */
    public function getCover(array $options = []): mixed
    {
        return IMG::get($this->cover, IMG::mergeWithDefaultOptions($options, 'cover'));
    }

    /******* START GALLERY *******/
    public function getGalleryAttribute() {
        if(empty($this->gallery)) {
            $this->gallery = empty($this->uploads) ? null : $this->uploads->where('relation_type', 'gallery');
        }

        return $this->gallery;
    }

    /**
     * Gets the Gallery images
     *
     * @param array $options If IMGProxy is enabled, $options will be used to generate proxified image URL
     * @param string|null $cast_to
     * @return array|\Collection
     */
    public function getGallery(array $options = [], ?string $cast_to = 'array'): array|Collection
    {
        $gallery = [];

        if(!empty($this->gallery)) {
            foreach($this->gallery as $image) {
                $gallery[] = IMG::get($image, IMG::mergeWithDefaultOptions($options, 'gallery'));
            }
        }


        return $cast_to === 'collection' ? collect($gallery) : $gallery;
    }

    /******* START THUMBNAIL *******/
    public function getMetaImgAttribute() {
        if(empty($this->meta_img)) {
            $this->meta_img = empty($this->uploads) ? null : $this->uploads->firstWhere('relation_type', 'meta_img');
        }

        return $this->meta_img;
    }

    /**
     * Gets the Meta image URL
     *
     * @param array $options If IMGProxy is enabled, $options will be used to generate proxified image URL
     * @return mixed
     */
    public function getMetaImg(array $options = []): mixed
    {
        return IMG::get($this->meta_img, IMG::mergeWithDefaultOptions($options, 'meta_img'));
    }

    /**
     * Gets All images combined (thumbnail, cover, gallery)
     *
     * @param array $options
     * @param bool $include_meta
     * @param string|null $cast_to
     * @return array|Collection|null
     */
    public function getAllImages(array $options = [], bool $include_meta = false, ?string $cast_to = 'array'): array|Collection|null
    {
        // TODO: Somehow get only the unique images!
        $all = array_values(array_filter(array_merge(
            [$this->getThumbnail($options), $this->getCover($options)],
            [$this->getGallery($options)]
        )));

        if($include_meta) {
            $all[] = $this->getMetaImg($options);
        }

        return $cast_to === 'collection' ? collect($all) : $all;
    }

    // Upload Groups Relations functions
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
