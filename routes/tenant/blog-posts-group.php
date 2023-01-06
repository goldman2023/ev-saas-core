<?php

use App\Http\Controllers\BlogPostController;

Route::get('/blog', [BlogPostController::class, 'blog_archive'])->name('blog.archive');
Route::get('/blog/{category_slug}', [BlogPostController::class, 'blog_archive_by_category'])->name('blog.category.archive');
Route::get('/shop/{shop_slug}/blog/post/{slug}', [EVCategoryController::class, 'archiveByCategory'])->name('shop.blog.post.index');
Route::get('/blog/post/{slug}', [BlogPostController::class, 'single'])->name('blog.post.single');