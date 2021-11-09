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
            if(empty($this->uploads)) {
                $this->load('uploads');
            }

            $model->getThumbnailAttribute();
            $model->getCoverAttribute();
            $model->getGalleryAttribute();
        });
    }

    /**
     * Initialize the trait
     *
     * @return void
     */
    public function initializeGalleryTrait(): void
    {
        $this->append(['thumbnail', 'cover', 'gallery']);
        $this->fillable(array_unique(array_merge($this->fillable, ['thumbnail', 'cover', 'gallery'])));
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
            $this->cover = $this->uploads->firstWhere('toc', 'cover');
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
            $this->gallery = $this->uploads->where('toc', 'gallery');
        }

        return $this->gallery;
    }

    /**
     * Gets the Gallery images
     *
     * @param array $options If IMGProxy is enabled, $options will be used to generate proxified image URL
     * @param string|null $cast_to
     * @return mixed
     */
    public function getGallery(array $options = [], ?string $cast_to = 'array'): mixed
    {
        $gallery = [];

        if(!empty($this->gallery)) {
            foreach($this->gallery as $image) {
                $gallery[] = IMG::get($image, $this->imgProxyDefaultOptions($options));
            }
        }


        return $cast_to === 'collection' ? collect($gallery) : $gallery;
    }

    // Helpers
    private function imgProxyDefaultOptions($options = []): array {
        $defaults = [
            'thumbnail' => [
                'w' => 350
            ],
            'cover' => [
                'w' => 600
            ],
            'gallery' => [
                'w' => 500
            ],
        ];
        return array_merge($defaults, $options);
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
