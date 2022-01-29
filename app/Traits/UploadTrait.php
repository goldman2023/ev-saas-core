<?php

namespace App\Traits;

use App\Builders\BaseBuilder;
use App\Models\Product;
use Closure;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use IMG;
use Illuminate\Support\Collection;
use App\Models\Upload;
use App\Models\UploadsContentRelationship;
use App\Models\UploadsGroup;

trait UploadTrait
{
    /**
     * Boot the trait
     *
     * @return void
     */
    protected static function bootUploadTrait()
    {
        static::addGlobalScope('withUploads', function(mixed $builder) {
            // Eager Load Uploads
            $builder->with(['uploads']);
        });

        static::relationsRetrieved(function ($model): void {
            if(!$model->relationLoaded('uploads')) {
                $model->load('uploads');
            }

            // Initiate dynamic properties values
            $model->dynamicUploadPropertiesWalker(function($property) use (&$model) {
                if($property['multiple'] ?? false) {
                    // Multiple Uploads
                    $model->{$property['property_name']} = empty($model->uploads) ? null : $model->uploads->filter(function ($upload) use ($property) {
                        return $upload->pivot->relation_type === $property['relation_type'];
                    })->sortBy('order')->values();
                } else {
                    // Single Upload
                    $model->{$property['property_name']} = empty($model->uploads) ? null : $model->uploads->filter(function ($upload) use ($property) {
                        return $upload->pivot->relation_type === $property['relation_type'];
                    })->first();
                }
            });
        });
    }

    /**
     * Initialize the trait
     *
     * @return void
     */
    public function initializeUploadTrait(): void
    {
        $this->dynamicUploadPropertiesWalker(function($property) {
            // Add dynamic properties to Model $append and $fillable vars
            $this->appendCoreProperties([$property['property_name']]);
            $this->append([$property['property_name']]);
            $this->fillable(array_unique(array_merge($this->fillable, [$property['property_name']])));
        });
    }


//    /**
//     * Fill the model with an array of attributes.
//     *
//     * @param  array  $attributes
//     * @return $this
//     *
//     * @throws \Illuminate\Database\Eloquent\MassAssignmentException
//     */
//    public function fill(array $attributes)
//    {
//        if($this instanceof \App\Models\Category) {
//            dd($attributes);
//        }
//        parent::fill($attributes);
//
//
//    }

    /*
     * Gets the Upload URL
     *
     * @param array $options If IMGProxy is enabled, $options will be used to generate proxified image URL
     * @return mixed
     */
    public function getUpload($property_name, array $options = []): mixed
    {
        return IMG::get($this->{$property_name}, IMG::mergeWithDefaultOptions($options, 'thumbnail'));
    }

    /**
     * Converts gallery properties from Upload model(s) to Upload ID(s)
     *
     * @return self
     */
    public function convertUploadModelsToIDs(): self
    {
        // Convert Dynamic Uploads to IDs
        $this->dynamicUploadPropertiesWalker(function($property) {
            if($this->{$property['property_name']} instanceof Collection) {
                // Property is a collection of Upload instances or IDs
                foreach($this->{$property['property_name']} as $key => $item) {
                    $this->{$property['property_name']} = ($item instanceof Upload) ? $this->{$property['property_name']}->put($key, (int) $item->id) : $this->{$property['property_name']}->put($key, (int) $this->{$property['property_name']});
                }

                $this->{$property['property_name']} = $this->{$property['property_name']}->unique()->join(',');
            } else if(is_array($this->{$property['property_name']})) {
                foreach($this->{$property['property_name']} as $key => $item) {
                    $this->{$property['property_name']}[$key] = ($item instanceof Upload) ? (int) $item->id : (int) $this->{$property['property_name']};
                }
                $this->{$property['property_name']} = implode(',', array_unique($this->{$property['property_name']}));
            } else if($this->{$property['property_name']} instanceof Upload) {
                // Property is single Upload instance
                $this->{$property['property_name']} = (int) $this->{$property['property_name']}->id;
            } else if(ctype_digit($this->{$property['property_name']})) {
                // Property is not Upload nor Collection (it's most probably number already, but it can be numeric string, hence cast it to int)
                $this->{$property['property_name']} = (int) $this->{$property['property_name']};
            }
        });

        // Convert Gallery Uploads to IDs (if GalleryTrait is present - we check that if convertGalleryModelsToIDs() method exists)
        if(method_exists($this, 'convertGalleryModelsToIDs')) {
            $this->convertGalleryModelsToIDs();
        }

        return $this;
    }

    /************************************
     * Uploads Relation Functions *
     ************************************/
    public function uploads() {
        return $this->morphToMany(Upload::class, 'subject', 'uploads_content_relationships', 'subject_id', 'upload_id')
            ->withPivot('relation_type', 'group_id');
    }

    /**
     * An abstract function which defines dynamic model upload-related properties.
     *
     * IMPORTANT: For property_name always use snake-case with underscore!!!
     *
     * Returns an array of properties where each property is consisted of desired parameters, like this:
     * [
     *       [
     *          'property_name' => 'pdf', // This is the property name which we can use as $model->{property_name} to access desired Upload of the current Model
     *          'relation_type' => 'pdf', // This is an identificator which determines the relation between Upload and Model (e.g. Products have `thumbnail`, `cover`, `gallery`, `meta_img`, `pdf`, `documents` etc.; Blog posts have `thumbnail`, `cover`, `gallery`, `meta_img`, `documents` etc.).
     *          'is_image' => false, // This value determines if Upload URL will be proxified using IMGProxy. If true, URL will be proxified; If false, standard URL will be returned! Default: false!
     *          'multiple' => false // Property getter function logic and return type (Upload or (Collection/array)) depend on this parameter. Default: false!
     *       ],
     *       ...
     *       ...
     *   ];
     * @return array
     */
    abstract public function getDynamicModelUploadProperties() : array;


    /**
     * Walks through DynamicModelUploadProperties and executes a provided closure for each property if conditions are met.
     *
     * Conditions:
     * 1. `property_name` parameter is not empty
     * 2. `relation_type` parameter is not empty
     * 3. Provided callback is an instance of Closure ($callback is anonymous function)
     *
     * @param ?Closure $callback
     */
    protected function dynamicUploadPropertiesWalker(?Closure $callback = null): void {
        $dynamic_properties = $this->getDynamicModelUploadProperties();

        if(!empty($dynamic_properties)) {
            foreach ($dynamic_properties as $property) {
                // Both `property_name` and `relation_type` have to be set in order to create desired Upload properties (+ getter/setter functions)
                if(!empty($property['property_name'] ?? null) && !empty($property['relation_type'] ?? null) && $callback instanceof Closure) {
                    $callback($property);
                }
            }
        }
    }

    public function syncUploads() {
        // Construct dynamic uploads sync array
        $this->dynamicUploadPropertiesWalker(function($property) {
            $upload = $this->{$property['property_name']};

            if($property['multiple']) {
                if(is_string($upload)) {
                    // property is either multiple IDs (1,2,3...) or numeric string single ID ("55")
                    $upload_keys = explode(',', $upload);
                } else if ($upload instanceof Collection) {
                    $upload_keys = $upload->toArray();
                } else if (is_array($upload)) {
                    $upload_keys = $upload;
                } else {
                    $upload_keys = null;
                }
            } else {
                if($upload instanceof Upload) {
                    $upload_keys = [$upload->id];
                } else if(ctype_digit($upload) || is_int($upload)) {
                    $upload_keys = [$upload];
                } else {
                    $upload_keys = null;
                }
            }

            if($upload_keys) {
                $upload_values = $upload_keys;
                array_walk($upload_values, function(&$value, $key) use($property) {
                    $value = [
                        'relation_type' => $property['relation_type'],
                        'order' => $key
                    ];
                });
            }

            $sync_array = $upload_keys ? array_combine($upload_keys, $upload_values) : null;

            $this->uploads()->wherePivot('relation_type', $property['relation_type'])->sync($sync_array);
        });

        // Sync Gallery uploads
        if(method_exists($this, 'syncGalleryUploads')) {
            $this->syncGalleryUploads();
        }
    }
}
