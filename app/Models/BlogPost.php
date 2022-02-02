<?php

namespace App\Models;

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
//    use ReactionsTrait;
//    use CommentsTrait;
//    use PermalinkTrait;

    public const STATUSES = ['published', 'draft', 'private', 'pending'];
    public const STATUS_PUBLISHED = 'published';
    public const STATUS_DRAFT = 'draft';
    public const STATUS_PRIVATE = 'private';
    public const STATUS_PENDING = 'pending';

    protected $table = 'blog_posts';

    protected $fillable = ['shop_id', 'title', 'excerpt', 'content', 'status', 'subscription_only', 'meta_title', 'meta_description', 'meta_keywords'];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    public function shop() {
        return $this->belongsTo(Shop::class, 'shop_id');
    }

    public function authors() {
        return $this->morphedByMany(User::class, 'subject', 'blog_post_relationships');
    }

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
