<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SocialAccount extends Model
{
    protected $table = 'social_accounts';

    protected $fillable = ['id', 'user_id', 'provider', 'connected', 'data', 'created_at', 'updated_at',];

    protected $casts = [
        'data' => 'array',
        'connected' => 'boolean'
    ];

    public static $available_providers = [
        'google' => 'Google',
        'facebook' => 'Facebook',
        'twitter' => 'Twitter',
        'linkedin' => 'LinkedIn',
        'github' => 'Github',
        'pinterest' => 'Pinterest'
    ];

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getAvailableProviders() {
        return self::$available_providers;
    }
}
