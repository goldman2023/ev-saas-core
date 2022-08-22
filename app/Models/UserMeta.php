<?php

namespace App\Models;

use App\Models\Category;
use App\Enums\AvailableSocialFieldsEnum;

class UserMeta extends WeBaseModel
{
    protected $table = 'user_meta';

    protected $fillable = [
        'key', 'value', 'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public static function metaDataTypes()
    {
        $available_social_user_profiles = collect(AvailableSocialFieldsEnum::values());
        $social_profiles = [];
        foreach($available_social_user_profiles as $key => $value) {
            $social_profiles[$value.'_profile'] = 'string';
        }

        return [
            'birthday' => 'date',
            'gender' => 'select',
            'headline' => 'string',
            'short_about_me' => 'string',
            'website' => 'string',
            'social_profiles' => $social_profiles,
            'industry' => Category::class,
            'calendly_link' => 'string',
            'company_name' => 'string',
            'company_vat' => 'string',
            'address_country' => 'select',
            'company_registration_number' => 'string',
            // 'company_country' => 'select',
            'address_city' => 'string',
            'address_line' => 'string',
            'address_postal_code' => 'string',
            'address_state' => 'string',

            'work_experience' => 'array',
            'education' => 'array',
            'bio' => 'wysiwyg',
            'locale' => 'select',
            'started_trials_on' => 'array',

            // 'work_experience' => [
            //     'title' => 'string',
            //     'company_name' => 'string',
            //     'employment_type' => 'string',
            //     'location' => 'string',
            //     'currently_working_there' => 'boolean',
            //     'start_date' => 'date',
            //     'end_date' => 'date',
            //     'description' => 'string',
            // ],
            // 'education' => [
            //     'school' => 'string',
            //     'degree_title' => 'string',
            //     'field_of_study' => 'string',
            //     'start_date' => 'date',
            //     'end_date' => 'date',
            //     'description' => 'string',
            //     'certificates' => 'uploads',
            // ],
        ];
    }

    public static function metaForCompanyEntity() {
        return ['company_name', 'company_vat', 'company_registration_number'];
    }

    public static function metaSelectValues($key) {
        $data = [
            'gender' => [
                'male' => 'Male',
                'female' => 'Female',
                'other' => 'Other'
            ]
        ];

        return $data[$key] ?? [];
    }

    public static function createMissingMeta($user_id)
    {
        if ($user_id instanceof User) {
            $user = $user_id;
        } else {
            $user = User::find($user_id);
        }

        if (!empty($user)) {
            $meta = $user->user_meta()->select('id', 'key', 'value')->get()->keyBy('key')->toArray();
            $data_types = self::metaDataTypes();

            $missing = array_diff_key($data_types, $meta);
            if (! empty($missing)) {
                foreach ($missing as $key => $type) {
                    self::updateOrCreate(
                        ['user_id' => $user->id, 'key' => $key],
                        ['value' => $type === 'boolean' ? false : null]
                    );
                }
            }
        }
    }
}
