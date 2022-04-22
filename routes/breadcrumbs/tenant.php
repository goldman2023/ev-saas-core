<?php

// Note: Laravel will automatically resolve `Breadcrumbs::` without
// this import. This is nice for IDE syntax and refactoring.
use App\Models\Category;
use Diglactic\Breadcrumbs\Breadcrumbs;
// This import is also not required, and you could replace `BreadcrumbTrail $trail`
//  with `$trail`. This is nice for IDE type checking and completion.
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

// Home
Breadcrumbs::for('home', function (BreadcrumbTrail $trail) {
    $trail->push('Home', route('home'));
});

// Category
Breadcrumbs::for('category', function (BreadcrumbTrail $trail, Category $category, $content_type = null) {
    $trail->parent('home');

    $ancestors = $category->ancestors;

    if (! empty($ancestors)) {
        foreach ($ancestors as $ancestor) {
            $trail->push($ancestor->name, $ancestor->getPermalink($content_type));
        }
    }

    $trail->push($category->name, $category->getPermalink($content_type));
});
