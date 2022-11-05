<?php

namespace App\Traits;

use App\Builders\BaseBuilder;
use App\Models\Category;
use App\Models\Product;
use App\Models\Upload;
use App\Models\UploadsContentRelationship;
use App\Models\UploadsGroup;
use Closure;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use IMG;

trait UploadTrait
{
    /**
     * Boot the trait
     *
     * @return void
     */
    protected static function bootUploadTrait()
    {
        static::addGlobalScope('withUploads', function (mixed $builder) {
            // Eager Load Uploads
            $builder->with(['uploads']);
        });

        static::relationsRetrieved(function ($model) {
            if ($model->relationLoaded('uploads')) {

                // Walk through dynamic upload properties and init each of them by calling respective GET mutator
                $model->dynamicUploadPropertiesWalker(function ($property) use (&$model) {
                    // Create mutator function name based on property name
                    $get_mutator_name = $model->getPropertyMutatorName($property['property_name']);
                    
                    // Run dynamic upload property mutator -> THIS WILL BE ROUTED THROUGH WeBaseModel->__call() magic function and will call $model->getDynamicUpload(...) function to init the property 
                    try {
                        $model->{$get_mutator_name}();
                    } catch(\Throwable $e) {
                        \Log::error($e->getMessage);
                    }
                });
            }
        });
    }

    /**
     * Initialize the trait
     *
     * @return void
     */
    public function initializeUploadTrait(): void
    {
        $this->dynamicUploadPropertiesWalker(function ($property) {
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
        $this->dynamicUploadPropertiesWalker(function ($property) {
            if ($this->{$property['property_name']} instanceof Collection) {
                // Property is a collection of Upload instances or IDs
                foreach ($this->{$property['property_name']} as $key => $item) {
                    $this->{$property['property_name']} = ($item instanceof Upload) ? $this->{$property['property_name']}->put($key, (int) $item->id) : $this->{$property['property_name']}->put($key, (int) $this->{$property['property_name']});
                }

                $this->{$property['property_name']} = $this->{$property['property_name']}->unique()->join(',');
            } elseif (is_array($this->{$property['property_name']})) {
                foreach ($this->{$property['property_name']} as $key => $item) {
                    $this->{$property['property_name']}[$key] = ($item instanceof Upload) ? (int) $item->id : (int) $this->{$property['property_name']};
                }
                $this->{$property['property_name']} = implode(',', array_unique($this->{$property['property_name']}));
            } elseif ($this->{$property['property_name']} instanceof Upload) {
                // Property is single Upload instance
                $this->{$property['property_name']} = (int) $this->{$property['property_name']}->id;
            } elseif (ctype_digit($this->{$property['property_name']})) {
                // Property is not Upload nor Collection (it's most probably number already, but it can be numeric string, hence cast it to int)
                $this->{$property['property_name']} = (int) $this->{$property['property_name']};
            }
        });

        // Convert Gallery Uploads to IDs (if GalleryTrait is present - we check that if convertGalleryModelsToIDs() method exists)
        if (method_exists($this, 'convertGalleryModelsToIDs')) {
            $this->convertGalleryModelsToIDs();
        }

        return $this;
    }

    /************************************
     * Uploads Relation Functions *
     ************************************/
    public function uploads()
    {
        return $this->morphToMany(Upload::class, 'subject', 'uploads_content_relationships', 'subject_id', 'upload_id')
            ->withPivot('relation_type', 'group_id', 'order');
    }

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
    protected function dynamicUploadPropertiesWalker(?Closure $callback = null): void
    {
        $dynamic_properties = $this->getDynamicModelUploadProperties();

        if (! empty($dynamic_properties)) {
            foreach ($dynamic_properties as $property) {
                // Both `property_name` and `relation_type` have to be set in order to create desired Upload properties (+ getter/setter functions)
                if (! empty($property['property_name'] ?? null) && ! empty($property['relation_type'] ?? null) && $callback instanceof Closure) {
                    $callback($property);
                }
            }
        }
    }

    public function syncUploads($specific_property = null)
    {
        // Construct dynamic uploads sync array
        $this->dynamicUploadPropertiesWalker(function ($property) use ($specific_property) {
            if (empty($specific_property) || $specific_property === $property['property_name']) {
                $upload = $this->{$property['property_name']};

                if ($property['multiple']) {
                    if (is_string($upload)) {
                        // property is either multiple IDs (1,2,3...) or numeric string single ID ("55")
                        $upload_keys = explode(',', $upload);
                    } elseif ($upload instanceof Collection) {
                        $upload_keys = $upload->toArray();
                    } elseif (is_array($upload)) {
                        $upload_keys = $upload;
                    } else {
                        $upload_keys = null;
                    }
                } else {
                    if ($upload instanceof Upload) {
                        $upload_keys = [$upload->id];
                    } elseif (ctype_digit($upload) || is_int($upload)) {
                        $upload_keys = [$upload];
                    } else {
                        $upload_keys = null;
                    }
                }

                if ($upload_keys) {
                    $upload_values = $upload_keys;
                    array_walk($upload_values, function (&$value, $key) use ($property) {
                        if($property['multiple']) {
                            $value = [
                                'relation_type' => $property['relation_type'],
                                'order' => $value['order'],
                            ];
                        } else {
                            $value = [
                                'relation_type' => $property['relation_type'],
                                'order' => $key,
                            ];
                        }
                    });

                    if($property['multiple']) {
                        // If property/field is multiple - $upload_keys must be array of IDs, not array of objects with IDs
                        $upload_keys = array_map(function($item) {
                            return isset($item['id']) ? $item['id'] : $item;
                        }, $upload_keys);
                    }
                }

                $sync_array = $upload_keys ? array_combine($upload_keys, $upload_values) : null;

                $this->uploads()->wherePivot('relation_type', $property['relation_type'])->sync($sync_array);
            }
        });

        $this->convertDynamicUploadsToUploads($specific_property = null);

        // Sync Gallery uploads
        if (method_exists($this, 'syncGalleryUploads')) {
            $this->syncGalleryUploads($specific_property);
        }
    }

    /**
     * Converts dynamic uploads from ID(s) to Uploads Models
     *
     * @return void
     */
    public function convertDynamicUploadsToUploads($specific_property = null)
    {
        $this->dynamicUploadPropertiesWalker(function ($property) use ($specific_property) {
            if (empty($specific_property) || $specific_property === $property['property_name']) {

                if($property['multiple']) {
                    // Multiple files
                    $file_uploads = new \Illuminate\Database\Eloquent\Collection();
                    if (($this->{$property['property_name']} instanceof Collection && $this->{$property['property_name']}->isNotEmpty()) || (is_array($this->{$property['property_name']}) && ! empty($this->{$property['property_name']}))) {
                        foreach ($this->{$property['property_name']} as $file) {
            
                            if($file instanceof Upload) {
                                $file_uploads->push($file);
                                continue;
                            }
                            
                            if(is_array($file) && isset($file['id']) && !empty($file['id'])) {
                                $file = Upload::find($file['id'] ?? null);
                            }
            
                            $file_uploads->push($file);
                        }
                    }
                    $this->{$property['property_name']} = $file_uploads;
                } else {
                    // Single file
                    $this->{$property['property_name']} = ($this->{$property['property_name']} instanceof Upload) ? $this->{$property['property_name']} : Upload::find($this->{$property['property_name']} ?? null);
                }
            }
        });
    }

    public function getDynamicUpload($property_name, $relation_type, $multiple) {
        if (! isset($this->{$property_name})) {
            if ($multiple ?? false) {
                // Multiple Uploads
                $this->{$property_name} = empty($this->uploads) ? new \Illuminate\Database\Eloquent\Collection() : $this->uploads->filter(function ($upload) use ($relation_type) {
                    return $upload->pivot->relation_type === $relation_type;
                })->sortBy(function ($upload, $key) {
                    return $upload->pivot->order;
                })->values();
            } else {
                // Single Upload
                $this->{$property_name} = empty($this->uploads) ? null : $this->uploads->filter(function ($upload) use ($relation_type) {
                    return $upload->pivot->relation_type === $relation_type;
                })->first();
            }
        }

        return $this->{$property_name};
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
}
