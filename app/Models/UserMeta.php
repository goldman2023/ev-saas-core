<?php

namespace App\Models;

use App\Models\Category;

class UserMeta extends EVBaseModel
{
    protected $table = 'user_meta';

    protected $fillable = [
        'key', 'value', 'user_id'
    ];

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public static function metaDataTypes() {
        return [
            'birthday' => 'date',
            'gender' => 'select',
            'headline' => 'string',
            'industry' => Category::class,
            'bio' => 'string',
            'work_experience' => [
                'title' => 'string',
                'company_name' => 'string',
                'employment_type' => 'string',
                'location' => 'string',
                'currently_working_there' => 'boolean',
                'start_date' => 'date',
                'end_date' => 'date',
                'description' => 'string',
            ],
            'education' => [
                'school' => 'string',
                'degree_title' => 'string',
                'field_of_study' => 'string',
                'start_date' => 'date',
                'end_date' => 'date',
                'description' => 'string',
                'certificates' => 'uploads',
            ],
        ];
    }
}