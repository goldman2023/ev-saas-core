<?php

namespace App\Http\Livewire\Feed\Blocks;


use App\Traits\Livewire\WithCursorPagination;
use Illuminate\Support\Facades\Session;
use Livewire\Component;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\Cursor;
use App\Enums\StatusEnum;
use App\Enums\ProductTypeEnum;
use App\Models\Activity;
use App\Models\Product;
use App\Models\SocialComment;
use App\Models\Ownership;


class MyCourses extends Component
{
    use WithCursorPagination;

    public $courses;

    public $readyToLoad = false;

    public $loading = false;

    public function mount()
    {
        $this->perPage = 3;
        $this->courses = new \Illuminate\Database\Eloquent\Collection();

        $this->loadCourses();
    }

    public function render()
    {
        return view('livewire.feed.blocks.my-courses');
    }

    public function loadInit()
    {
        $this->readyToLoad = true;
    }

    public function loadCourses()
    {
        if ($this->hasMorePages !== null  && ! $this->hasMorePages) {
            return;
        }

        // Get owned courses through Ownership table
        $courses = auth()->user()?->owned_assets()->where('subject_type', Product::class)->whereHas('subject', function($query) {
                $query->where('type', ProductTypeEnum::course()->value);
            })
            ->orderBy('created_at', 'DESC')
            ->cursorPaginate($this->perPage, ['*'], 'cursor', Cursor::fromEncoded($this->nextCursor));

        $this->courses->push(...$courses->items());
        $this->prepareNextPage($courses);
    }
}
