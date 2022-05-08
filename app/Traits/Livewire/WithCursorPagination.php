<?php

namespace App\Traits\Livewire;

trait WithCursorPagination
{
    public $nextCursor; // holds our current page position.
    public $hasMorePages; // Tells us if we have more pages to paginate.
    public $perPage = 10;
    public $page = 1; // Used for OFFSET pagination

    /** 
     * Prepares pagination for the next page (if any)
     * 
     * @param mixed $paginator - Paginator object based on which we determine next cursor
    */
    protected function prepareNextPage($paginator) {
        $this->hasMorePages = $paginator->hasMorePages();

        if ($this->hasMorePages === true) {
            if(method_exists($paginator, 'nextCursor')) {
                $this->nextCursor = $paginator->nextCursor()->encode(); // for cursor
            }
            $this->page += 1; // for offset
        }
    }

    protected function resetPagination() {
        $this->hasMorePages = true;
        $this->nextCursor = null;
        $this->page = 1;
    }
}
