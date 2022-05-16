<?php

namespace App\Models;

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

    public static function metaProductDataTypes()
    {
        return [
            'date_type' => 'string',
            'start_date' => 'date',
            'end_date' => 'date',
            'location_type' => 'string',
            'location_address' => 'string',
            'location_address_map_link' => 'string',
            'location_link' => 'string',
            'unlockables' => 'string', // for now it's a string/wysiwyg
            'calendly_link' => 'string',
            // 'custom_cta_title' => 'string',
            'thank_you_cta_custom_title' => 'string',
            'thank_you_cta_custom_text' => 'string',
            'thank_you_cta_custom_url' => 'string',
            'thank_you_cta_custom_button_title' => 'string'
        ];
    }

    public static function metaBlogPostDataTypes()
    {
        return [
            'portfolio_link' => 'string',
        ];
    }

    public static function metaPlanDataTypes()
    {
        return [
            'custom_redirect_url' => 'string',
        ];
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

        if($content_type === Product::class) {
            $data_types = self::metaProductDataTypes();
        } else if($content_type === BlogPost::class) {
            $data_types = self::metaBlogPostDataTypes();
        } else if($content_type === Plan::class) {
            $data_types = self::metaPlanDataTypes();
        }

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
