<?php

use App\Http\Controllers\BlogPostController;

/* Blog Posts */

Route::get('/blog/posts', [BlogPostController::class, 'index'])->name('blog.posts.index');
Route::get('/blog/posts/create', [BlogPostController::class, 'create'])->name('blog.post.create');
Route::get('/blog/posts/edit/{id}', [BlogPostController::class, 'edit'])->name('blog.post.edit');