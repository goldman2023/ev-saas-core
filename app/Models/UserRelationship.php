<?php

namespace App\Models;

use App\Models\Cart;
use App\Notifications\EmailVerificationNotification;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class UserRelationship extends Authenticatable implements MustVerifyEmail
{
    use Notifiable, HasApiTokens;

    protected $table = 'user_relationships';

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
