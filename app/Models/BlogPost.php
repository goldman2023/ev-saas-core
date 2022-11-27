<?php

namespace App\Models;

use App\Facades\MyShop;
use App\Traits\HasStatus;
use App\Traits\UploadTrait;
use App\Traits\GalleryTrait;
use Spatie\Sitemap\Tags\Url;
use App\Builders\BaseBuilder;
use App\Traits\CategoryTrait;
use App\Traits\CoreMetaTrait;
use Spatie\Sluggable\HasSlug;
use App\Traits\PermalinkTrait;
use App\Enums\BlogPostTypeEnum;
use App\Traits\HasContentColumn;
use App\Traits\TranslationTrait;
use Spatie\Sluggable\SlugOptions;
use App\Traits\SocialCommentsTrait;
use App\Traits\SocialReactionsTrait;
use Shetabit\Visitor\Traits\Visitable;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sitemap\Contracts\Sitemapable;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;


// use GetStream\StreamLaravel\Eloquent\ActivityTrait;

class BlogPost extends WeBaseModel  implements Sitemapable
{
    use HasSlug;
    use SoftDeletes;
    use LogsActivity;
    use CoreMetaTrait;

    use HasContentColumn;
    use HasStatus;

    use UploadTrait;
    use GalleryTrait;
    use TranslationTrait;
    use CategoryTrait;

//    use ReactionsTrait;
    // use CommentsTrait;
    use PermalinkTrait;
    use SocialCommentsTrait;
    use SocialReactionsTrait;

    protected $table = 'blog_posts';

    protected $fillable = ['shop_id', 'type', 'name', 'excerpt', 'status', 'subscription_only', 'meta_title', 'meta_description', 'meta_keywords', 'created_at', 'updated_at'];

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
            // static::addGlobalScope('from_my_shop_or_me', function (BaseBuilder $builder) {
            //     $builder->where('shop_id', '=', MyShop::getShop()->id ?? -1); // restrict to current user's shop blog posts
            // });
        }
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug')
            ->doNotGenerateSlugsOnUpdate();
    }

    public function toSitemapTag(): Url | string | array
    {
        return route('blog.post.single', $this->slug);
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
        // TODO: Move content and excerpt to HasContentColumn trait
        return $query->where(
            fn ($query) =>  $query->where('id', 'like', '%'.$term.'%')
                ->orWhere('name', 'like', '%'.$term.'%')
                ->orWhere('excerpt', 'like', '%'.$term.'%')
                ->orWhere($this->getContentColumnName(), 'like', '%'.$term.'%')
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

    public function isBlog() {
        return $this->type === BlogPostTypeEnum::blog()->value;
    }

    public function isPortfolio() {
        return $this->type === BlogPostTypeEnum::portfolio()->value;
    }

    public function getDynamicModelUploadProperties(): array
    {
        return [];
    }

    public function getTranslationModel(): ?string
    {
        return BlogPostTranslation::class;
    }

    public function getPageMeta() {
        $meta = [
            'title' => $this->name,
            'description' => $this->meta_description,
            'image' => $this->getThumbnail()
        ];

        if($this->getMetaImg()) {
            $meta['image'] = $this->getMetaImg();
        }

        if($this->meta_title) {
            $meta['title'] = $this->meta_title;
        }

        return $meta;
    }
}
