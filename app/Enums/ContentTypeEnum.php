<?php

namespace App\Enums;

/**
 * @method static self product()
 * @method static self product_variation()
 * @method static self plan()
 * @method static self shop()
 * @method static self user()
 * @method static self category()
 * @method static self blog_post()
 * @method static self brand()
 * @method static self event()
 * @method static self upload()
 * @method static self wishlist()
 * @method static self wallet()
 * @method static self review()
 * @method static self order()
 * @method static self invoice()
 * @method static self address()
 * @method static self attribute()
 * @method static self attribute_value()
 * @method static self currency()
 */
class ContentTypeEnum extends EVBaseEnum
{
    public static function values(): array
    {
        return [
            'product' => \App\Models\Product::class,
            'product_variation' => \App\Models\ProductVariation::class,
            'plan' => \App\Models\Plan::class,
            'shop' => \App\Models\Shop::class,
            'user' => \App\Models\User::class,
            'category' => \App\Models\Category::class,
            'blog_post' => \App\Models\BlogPost::class,
            'brand' => \App\Models\Brand::class,
            'event' => \App\Models\Event::class,
            'upload' => \App\Models\Upload::class,
            'wishlist' => \App\Models\Wishlist::class,
            'wallet' => \App\Models\Wallet::class,
            'review' => \App\Models\Review::class,
            'order' => \App\Models\Order::class,
            'invoice' => \App\Models\Invoice::class,
            'address' => \App\Models\Address::class,
            'attribute' => \App\Models\Attribute::class,
            'attribute_value' => \App\Models\AttributeValue::class,
            'currency' => \App\Models\Currency::class,
        ];
    }

    public static function labels(): array
    {
        return [
            'product' => 'Product',
            'product_variation' => 'ProductVariation',
            'plan' => 'Plan',
            'shop' => 'Shop',
            'user' => 'User',
            'category' => 'Category',
            'blog_post' => 'BlogPost',
            'brand' => 'Brand',
            'event' => 'Event',
            'upload' => 'Upload',
            'wishlist' => 'Wishlist',
            'wallet' => 'Wallet',
            'review' => 'Review',
            'order' => 'Order',
            'invoice' => 'Invoice',
            'address' => 'Address',
            'attribute' => 'Attribute',
            'attribute_value' => 'AttributeValue',
            'currency' => 'Currency',
        ];
    }
}
