<?php

namespace App\Models;

use App\Builders\BaseBuilder;
use App\Facades\MyShop;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Wishlist
 *
 * @property int $id
 * @property int $user_id
 * @property int $product_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Wishlist newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Wishlist newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Wishlist query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Wishlist whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Wishlist whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Wishlist whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Wishlist whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Wishlist whereUserId($value)
 * @mixin \Eloquent
 */

class Wishlist extends WeBaseModel
{

    protected $guarded = [];

    protected $with = ['subject'];

    protected static function booted()
    {
        static::addGlobalScope('my_wishlists', function (BaseBuilder $builder) {
            $builder->where('user_id', '=', auth()->user()?->id)->orWhere('guest_id', '=', -1);
            // TODO: getting wishlist items by session
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function subject()
    {
        return $this->morphTo('subject');
    }
}
