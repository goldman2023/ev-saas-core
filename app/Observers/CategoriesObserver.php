<?php

namespace App\Observers;

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

    /**
     * Handle the Categorys "deleted" event.
     *
     * @param Category $category
     * @return void
     */
    public function deleted(Category $category)
    {
        // Remove all relationships when category is removed!
        CategoryRelationship::where('category_id', $category->id)->delete();
    }
}
