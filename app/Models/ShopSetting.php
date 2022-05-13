<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class ShopSetting extends Model
{
    use Notifiable;

    protected $table = 'shop_settings';

    protected $fillable = ['shop_id', 'setting', 'value', 'created_at', 'updated_at'];

    public function shop()
    {
        return $this->belongsTo(Shop::class, 'shop_id', 'id');
    }

    public static function metaDataTypes()
    {
        return [
            'email' => 'string',
            'phones' => 'array',
            'phones' => 'array',
            'tagline' => 'string',
            'websites' => 'array',
            'tax_number' => 'string',
            'registration_number' => 'string',
            'contact_details' => 'array',
        ];
    }

    public static function createMissingSettings($shop_id)
    {
        if ($shop_id instanceof Shop) {
            $shop = $shop_id;
        } else {
            $shop = User::find($shop_id);
        }

        if (!empty($shop)) {
            $settings = $shop->settings()->select('id', 'setting', 'value')->get()->keyBy('setting')->toArray();
            $data_types = self::metaDataTypes();

            $missing = array_diff_key($data_types, $settings);
            if (! empty($missing)) {
                foreach ($missing as $setting => $type) {
                    self::updateOrCreate(
                        ['shop_id' => $shop_id, 'setting' => $setting],
                        ['value' => $type === 'boolean' ? false : null]
                    );
                }
            }
        }
    }
}
