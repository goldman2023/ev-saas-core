<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Review
 *
 * @property int $id
 * @property int $product_id
 * @property int $user_id
 * @property int $rating
 * @property string $comment
 * @property int $status
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Review newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Review newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Review query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Review whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Review whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Review whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Review whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Review whereRating($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Review whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Review whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Review whereUserId($value)
 * @mixin \Eloquent
 */

class Review extends Model
{
    public function review_relationship()
    {
        return $this->hasOne(ReviewRelationship::class);
    }
    
    public function user(){
    return $this->belongsTo(User::class);
  }

  public function product(){
    return $this->belongsTo(Product::class);
  }
}
