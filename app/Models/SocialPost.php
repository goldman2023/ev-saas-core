<?php

namespace App\Models;

use App\Builders\BaseBuilder;
use App\Facades\MyShop;
use App\Traits\CategoryTrait;
use App\Traits\GalleryTrait;
use App\Traits\HasStatus;
use App\Traits\SocialReactionsTrait;
use App\Traits\SocialCommentsTrait;
use App\Traits\PermalinkTrait;
use App\Traits\TranslationTrait;
use App\Traits\UploadTrait;
use App\Traits\CoreMetaTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Shetabit\Visitor\Traits\Visitable;
use Spatie\Activitylog\Traits\LogsActivity;

class SocialPost extends WeBaseModel
{
    use SoftDeletes;
    use LogsActivity;
    use UploadTrait;
    use GalleryTrait;
    use PermalinkTrait;
    use CoreMetaTrait;
    use SocialReactionsTrait;
    use SocialCommentsTrait;
    use HasStatus;

    protected $table = 'social_posts';

    protected $fillable = ['shop_id', 'user_id', 'type', 'content', 'status', 'meta_title', 'meta_description'];

    protected $casts = [
        'created_at' => 'datetime:d.m.Y H:i',
        'updated_at' => 'datetime:d.m.Y H:i',
    ];

    protected static function booted()
    {
        if (request()->is_dashboard) {
            // TODO: Fix to show all blog posts in Frontend and only my posts in Backend
            // Show only MyShop Blog Posts
            // static::addGlobalScope('from_my_shop_or_me', function (BaseBuilder $builder) {
            //     $builder->where('shop_id', '=', MyShop::getShop()->id ?? -1); // restrict to current user's shop blog posts
            // });
        }
    }

    public function getRouteKeyName()
    {
        return 'id';
    }

    public static function getRouteName()
    {
        return 'social.post.single';
    }

    /*
     * Scope searchable parameters
     */
    public function scopeSearch($query, $term)
    {
        return $query->where(
            fn ($query) =>  $query->where('content', 'like', '%'.$term.'%')
        );
    }

    public function shop()
    {
        return $this->belongsTo(Shop::class, 'shop_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getDynamicModelUploadProperties(): array
    {
        return [];
    }
}
