<?php

namespace App\Traits;

use App\Builders\BaseBuilder;
use App\Models\Task;

trait TasksTrait
{
    /**
     * Boot the trait
     *
     * @return void
     */
    protected static function bootTasksTrait()
    {
        
    }

    /**
     * Initialize the trait
     *
     * @return void
     */
    public function initializeTasksTrait(): void
    {
        
    }

    /************************************
     * Tasks Relation Functions *
     ************************************/
    public function tasks()
    {
        return $this->morphToMany(Task::class, 'subject', 'task_relationships', 'subject_id');
    }
}
