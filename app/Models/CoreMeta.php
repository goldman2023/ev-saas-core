<?php

namespace App\Models;

use WEF;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoreMeta extends Model
{
    use HasFactory;

    protected $table = 'core_meta';

    protected $fillable = ['subject_id', 'subject_type', 'key', 'value'];

    public function subject()
    {
        return $this->morphTo('subject');
    }

    public static function metaGlobalDataTypes() {
        return [
            'content_structure' => 'array',
        ];
    }

    public static function metaProductDataTypes()
    {
        return array_merge(self::metaGlobalDataTypes(), [
            'date_type' => 'string',
            'start_date' => 'date',
            'end_date' => 'date',
            'location_type' => 'string',
            'location_address' => 'string',
            'location_address_map_link' => 'string',
            'location_link' => 'string',
            'unlockables' => 'string', // for now it's a string/wysiwyg
            'unlockables_structure' => 'array',
            'calendly_link' => 'string',

            // Course core_meta
            'course_what_you_will_learn' => 'array',
            'course_requirements' => 'array',
            'course_target_audience' => 'array',
            'course_includes' => 'array',
            'course_intro_video_url' => 'string',


            // 'custom_cta_title' => 'string',
            'thank_you_cta_custom_title' => 'string',
            'thank_you_cta_custom_text' => 'string',
            'thank_you_cta_custom_url' => 'string',
            'thank_you_cta_custom_button_title' => 'string',
            
        ]);
    }

    public static function metaBlogPostDataTypes()
    {
        return array_merge(self::metaGlobalDataTypes(), [
            'portfolio_link' => 'string',
        ]);
    }

    public static function metaPlanDataTypes()
    {
        return array_merge(self::metaGlobalDataTypes(), apply_filters('plan.meta.data-types', [
            'custom_redirect_url' => 'string',
            'custom_cta_label' => 'string',
            'custom_pricing_label' => 'string',
        ]));
    }

    public static function metaUserSubscriptionDataTypes()
    {
        return array_merge(self::metaGlobalDataTypes(), apply_filters('user-subscription.meta.data-types', [
            
        ]));
    }

    public static function metaUploadDataTypes()
    {
        return array_merge(self::metaGlobalDataTypes(), apply_filters('upload.meta.data-types', [
            'upload_tag' => 'string',
        ]));
    }

    public static function getMeta($core_meta, $content_type, $strict = false)
    {
        if (is_array($core_meta)) {
            if (empty($core_meta)) {
                $core_meta = [];
            } else {
                $core_meta = collect($core_meta)->keyBy('key')->toArray();
            }
        } else {
            $core_meta = $core_meta->keyBy('key')->toArray();
        }

        $data_types = WEF::getWEFDataTypes($content_type);

        castValuesForGet($core_meta, $data_types);
        
        $missing = array_diff_key($data_types, $core_meta);
        $missing_clone = $missing;
        
        // TODO: Fix logic to not include value anymore or something like that!
        if (! empty($missing)) {
            foreach ($missing as $key => $type) {
                $missing[$key] = null;
            }
            castValuesForGet($missing, $missing_clone);
        }

        // If strict is true, get only core_meta from $data_types, remove other meta
        if($strict) {
            return collect(array_intersect_key(array_merge($core_meta, $missing), $data_types))->map(fn($item, $key) => $item);
        }

        return array_merge($core_meta, $missing);
    }
}
