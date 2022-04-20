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

    public static function metaDataTypes()
    {
        return [
            'date_type' => 'string',
            'start_date' => 'date',
            'end_date' => 'date',
            'location_type' => 'string',
            'location_address' => 'string',
            'location_address_coordinates' => 'array',
            'location_link' => 'string',
            'unlockables' => 'array',
            'calendly_link' => 'string',
        ];
    }

    public static function getMeta($core_meta)
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

        $data_types = self::metaDataTypes();

        castValuesForGet($core_meta, $data_types);

        $missing = array_diff_key($data_types, $core_meta);
        $missing_clone = $missing;

        if (! empty($missing)) {
            foreach ($missing as $key => $type) {
                $missing[$key] = [
                    'value' => null,
                ];
            }
            castValuesForGet($missing, $missing_clone);
        }

        return array_merge($core_meta, $missing);
    }
}
