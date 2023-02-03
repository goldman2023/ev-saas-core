<?php

namespace App\Observers;

use Categories;
use App\Models\Category;
use App\Models\CategoryRelationship;

class CategoriesObserver
{
    /**
     * Handle events after all transactions are committed.
     *
     * @var bool
     */
    public bool $afterCommit = true;

 
    public function created(Category $category)
    {
        Categories::clearCache();
    }

    public function restored(Category $category)
    {
        Categories::clearCache();
    }

    public function updated(Category $category)
    {
        Categories::clearCache();
    }

    public function deleted(Category $category)
    {
        $this->forceDeleted($category);
    }

    public function forceDeleted(Category $category)
    {
        // Remove all relationships when category is removed!
        CategoryRelationship::where('category_id', $category->id)->delete();

        Categories::clearCache();
    }
}
