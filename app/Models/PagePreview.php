<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class PagePreview extends WeBaseModel
{
    protected $table = 'page_previews';

    protected $fillable = ['page_id', 'user_id', 'content', 'created_at', 'updated_at'];

    protected $casts = [
        'created_at' => 'datetime:d.m.Y H:i',
        'updated_at' => 'datetime:d.m.Y H:i',
    ];

    public function page()
    {
        return $this->belongsTo(Page::class, 'page_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getContentAttribute($value)
    {
        return array_values(json_decode((empty($value) || ! is_string($value)) ? '[]' : $value, true));
    }

    public function setContentAttribute($value)
    {
        if ($value instanceof Collection) {
            $this->attributes['content'] = $value->values()->toJson();
        } elseif (is_array($value)) {
            $this->attributes['content'] = json_encode(array_values($value ?? []));
        } else {
            $this->attributes['content'] = [];
        }
    }
}
