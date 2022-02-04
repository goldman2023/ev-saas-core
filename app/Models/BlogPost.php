<?php

namespace App\Models;

use App\Builders\BaseBuilder;
use App\Facades\MyShop;
use App\Traits\CategoryTrait;
use App\Traits\GalleryTrait;
use App\Traits\PermalinkTrait;
use App\Traits\TranslationTrait;
use App\Traits\UploadTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

// use GetStream\StreamLaravel\Eloquent\ActivityTrait;

class BlogPost extends EVBaseModel
{
    use HasSlug;
    use SoftDeletes;
    use LogsActivity;

    use UploadTrait;
    use GalleryTrait;
    use TranslationTrait;
    use CategoryTrait;
//    use ReactionsTrait;
//    use CommentsTrait;
//    use PermalinkTrait;


    protected $table = 'blog_posts';

    protected $fillable = ['shop_id', 'title', 'excerpt', 'content', 'status', 'subscription_only', 'meta_title', 'meta_description', 'meta_keywords'];

    protected $casts = [
        'subscription_only' => 'boolean',
        'created_at' => 'datetime:d.m.Y H:i',
        'updated_at' => 'datetime:d.m.Y H:i',
    ];

    protected static function booted()
    {
        // Show only MyShop Blog Posts
        static::addGlobalScope('from_my_shop_or_me', function (BaseBuilder $builder) {
            $builder->where('shop_id', '=', MyShop::getShop()->id ?? -1); // restrict to current user's shop blog posts
        });
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    /*
     * Scope searchable parameters
     */
    public function scopeSearch($query, $term)
    {
        return $query->where(
            fn ($query) =>  $query->where('id', 'like', '%'.$term.'%')
                ->orWhere('title', 'like', '%'.$term.'%')
                ->orWhere('excerpt', 'like', '%'.$term.'%')
                ->orWhere('content', 'like', '%'.$term.'%')
        );
    }


    public function shop() {
        return $this->belongsTo(Shop::class, 'shop_id');
    }

    public function authors() {
        return $this->morphedByMany(User::class, 'subject', 'blog_post_relationships');
    }

//    public function categories() {
//        return $this->morphedByMany(Category::class, 'subject', 'blog_post_relationships');
//    }

//    public function subscriptions()
//    {
//        return $this->morphedByMany(Subscription::class, 'subject', 'blog_post_relationships');
//    }


    public function getDynamicModelUploadProperties(): array
    {
        return [];
    }

    public function getTranslationModel(): ?string
    {
        return BlogPostTranslation::class;
    }
}
