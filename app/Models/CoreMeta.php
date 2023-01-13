<?php

namespace App\Models;

use WEF;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoreMeta extends WeBaseModel
{
    use HasFactory;

    protected $table = 'core_meta';

    protected $fillable = ['subject_id', 'subject_type', 'key', 'value'];

    public function subject()
    {
        return $this->morphTo('subject');
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
