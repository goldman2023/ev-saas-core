<?php

namespace App\Models;

use App\Builders\BaseBuilder;
use App\Facades\MyShop;
use App\Traits\CategoryTrait;
use App\Traits\GalleryTrait;
use App\Traits\HasStatus;
use App\Traits\SocialReactionsTrait;
use App\Traits\PermalinkTrait;
use App\Traits\TranslationTrait;
use App\Traits\UploadTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Shetabit\Visitor\Traits\Visitable;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

// use GetStream\StreamLaravel\Eloquent\ActivityTrait;

class BlogPost extends WeBaseModel
{
    use HasSlug;
    use SoftDeletes;
    use LogsActivity;
    use UploadTrait;
    use GalleryTrait;
    use TranslationTrait;
    use CategoryTrait;

//    use ReactionsTrait;
    // use CommentsTrait;
    use PermalinkTrait;
    use SocialReactionsTrait;
    use HasStatus;

    protected $table = 'blog_posts';

    public const ROUTING_SINGULAR_NAME_PREFIX = 'post';

    public const ROUTING_PLURAL_NAME_PREFIX = 'posts';

    protected $fillable = ['shop_id', 'type', 'name', 'excerpt', 'content', 'status', 'subscription_only', 'meta_title', 'meta_description', 'meta_keywords'];

    protected $casts = [
        'subscription_only' => 'boolean',
        'created_at' => 'datetime:d.m.Y H:i',
        'updated_at' => 'datetime:d.m.Y H:i',
    ];

    protected static function booted()
    {
        if (request()->is_dashboard) {
            // TODO: Fix to show all blog posts in Frontend and only my posts in Backend
            // Show only MyShop Blog Posts
            static::addGlobalScope('from_my_shop_or_me', function (BaseBuilder $builder) {
                $builder->where('shop_id', '=', MyShop::getShop()->id ?? -1); // restrict to current user's shop blog posts
            });
        }
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public static function getRouteName()
    {
        return 'blog.post.single';
    }

    /*
     * Scope searchable parameters
     */
    public function scopeSearch($query, $term)
    {
        return $query->where(
            fn ($query) =>  $query->where('id', 'like', '%'.$term.'%')
                ->orWhere('name', 'like', '%'.$term.'%')
                ->orWhere('excerpt', 'like', '%'.$term.'%')
                ->orWhere('content', 'like', '%'.$term.'%')
        );
    }

    public function shop()
    {
        return $this->belongsTo(Shop::class, 'shop_id');
    }

    public function authors()
    {
        return $this->morphedByMany(User::class, 'subject', 'blog_post_relationships');
    }

//    public function categories() {
//        return $this->morphedByMany(Category::class, 'subject', 'blog_post_relationships');
//    }

    public function plans()
    {
        return $this->morphedByMany(Plan::class, 'subject', 'blog_post_relationships');
    }

    public function getDynamicModelUploadProperties(): array
    {
        return [];
    }

    public function getTranslationModel(): ?string
    {
        return BlogPostTranslation::class;
    }

    public function comments()
    {
        return $this->morphMany(SocialComment::class, 'subject');
    }
}
