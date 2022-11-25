<?php

// Note: Laravel will automatically resolve `Breadcrumbs::` without
// this import. This is nice for IDE syntax and refactoring.
use App\Models\Category;
use Diglactic\Breadcrumbs\Breadcrumbs;
// This import is also not required, and you could replace `BreadcrumbTrail $trail`
//  with `$trail`. This is nice for IDE type checking and completion.
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

// Home
Breadcrumbs::for('home', function (BreadcrumbTrail $trail, $page = null) {
    $trail->push('Home', route('home'));
    if($page) {
        $trail->push($page->name, route('custom-pages.show_custom_page', $page->slug));
    }
});

Breadcrumbs::for('products', function (BreadcrumbTrail $trail) {
    $trail->push('All Products', route('products.all'));
});

// Category
Breadcrumbs::for('category', function (BreadcrumbTrail $trail, $category, $content_type = null) {
    $trail->push('All Products', route('products.all'));

    // $trail->parent('home');

    if (isset($category->ancestors)) {
        $ancestors = $category->ancestors;

        if (!empty($ancestors)) {
            foreach ($ancestors as $ancestor) {
                $trail->push($ancestor->name, $ancestor->getPermalink($content_type));
            }
        }

        $trail->push($category->name, $category->getPermalink($content_type));
    }
});

// Category
Breadcrumbs::for('product', function (BreadcrumbTrail $trail, $product, $content_type = null) {
    $trail->push('All Products', route('products.all'));
    /* TODO: Add product categories */


    $primary_category = $product->categories()->first();
    if($primary_category){
        $trail->push($primary_category->name , route('blog.category.archive', $primary_category->slug));
    }

    $trail->push($product->name, $product->getPermalink($content_type));

    // $trail->parent('home');

    // if (isset($category->ancestors)) {
    //     $ancestors = $category->ancestors;

    //     if (!empty($ancestors)) {
    //         foreach ($ancestors as $ancestor) {
    //             $trail->push($ancestor->name, $ancestor->getPermalink($content_type));
    //         }
    //     }

    //     $trail->push($category->name, $category->getPermalink($content_type));
    // }
});


Breadcrumbs::for('blog', function (BreadcrumbTrail $trail, $blog_post = null, $content_type = null) {

    $trail->push('Blog', route('blog.archive'));

    if($blog_post) {
        $primary_category = $blog_post->categories()->first();

        /* TODO: Add blog category */
        if($primary_category){
            $trail->push($primary_category->name , route('blog.category.archive', $primary_category->slug));
        }

        $trail->push($blog_post->name, $blog_post->getPermalink($content_type));
    }
});

Breadcrumbs::for('page', function (BreadcrumbTrail $trail, $page = null, $content_type = null) {

    $trail->push('Page', route('blog.archive'));


        /* TODO: Add blog category */

        // $trail->push($blog_post->name, $blog_post->getPermalink($content_type));
});
