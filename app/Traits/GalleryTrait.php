<?php

namespace App\Traits;

use IMG;
use Illuminate\Support\Collection;
use App\Models\Upload;
use App\Models\UploadsContentRelationship;
use App\Models\UploadsGroup;

trait GalleryTrait
{
    public ?Upload $thumbnail;
    public ?Upload $cover;
    public Collection|array|null $gallery;
    public ?Upload $meta_img;

    /**
     * Boot the trait
     *
     * @return void
     */
    protected static function bootGalleryTrait()
    {
        // When model data is retrieved, populate model prices data!
        static::retrieved(function ($model) {
            // Check if $this->uploads is eager loaded or not. If not, load the relation!
            /*if(empty($model->uploads)) {
                //$model->load('uploads');
            }*/

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
        $this->append(['thumbnail', 'cover', 'gallery', 'meta_img']);
        $this->fillable(array_unique(array_merge($this->fillable, ['thumbnail', 'cover', 'gallery', 'meta_img'])));
    }

    /******* START THUMBNAIL *******/
    public function getThumbnailAttribute() {
        if(empty($this->thumbnail)) {
            $this->thumbnail = $this->uploads->firstWhere('toc', 'thumbnail');
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
        return IMG::get($this->thumbnail, $this->imgProxyDefaultOptions($options));
    }

    /******* START COVER *******/
    public function getCoverAttribute() {
        if(empty($this->cover)) {
            $this->cover = empty($this->uploads) ? null : $this->uploads->firstWhere('toc', 'cover');
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
        return IMG::get($this->cover, $this->imgProxyDefaultOptions($options));
    }

    /******* START GALLERY *******/
    public function getGalleryAttribute() {
        if(empty($this->gallery)) {
            $this->gallery = empty($this->uploads) ? null : $this->uploads->where('toc', 'gallery');
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
                $gallery[] = IMG::get($image, $this->imgProxyDefaultOptions($options));
            }
        }


        return $cast_to === 'collection' ? collect($gallery) : $gallery;
    }

    /******* START THUMBNAIL *******/
    public function getMetaImgAttribute() {
        if(empty($this->meta_img)) {
            $this->meta_img = empty($this->uploads) ? null : $this->uploads->firstWhere('toc', 'meta_img');
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
        return IMG::get($this->meta_img, $this->imgProxyDefaultOptions($options));
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

    // Helpers
    private function imgProxyDefaultOptions($options = [], $target = 'thumbnail'): array {
        $defaults = [
            'thumbnail' => [
                'w' => 350
            ],
            'cover' => [
                'w' => 820
            ],
            'gallery' => [
                'w' => 500
            ],
            'meta_img' => [
                'w' => 1200
            ]
        ];

        return array_merge_recursive($defaults[in_array($target, $defaults, true) ? $target : 'thumbnail'], $options);
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
