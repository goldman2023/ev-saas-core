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


class UpcomingEvents extends Component
{
    use WithCursorPagination;

    public $events;

    public $readyToLoad = false;

    public $loading = false;

    public function mount()
    {
        $this->perPage = 3;
        $this->events = new \Illuminate\Database\Eloquent\Collection();

        $this->loadEvents();
    }

    public function render()
    {
        return view('livewire.feed.blocks.upcoming-events');
    }

    public function loadInit()
    {
        $this->readyToLoad = true;
    }

    public function loadEvents()
    {
        if ($this->hasMorePages !== null  && ! $this->hasMorePages) {
            return;
        }

        $events = Product::select(['products.*', 'core_meta.value AS event_start_date'])->event()->with(['core_meta'])
            ->whereRelation('core_meta', function($query) {
                $query->where('key', 'start_date')->where('value', '>', time());
            })
            ->leftJoin('core_meta', function($join) {
                $join->on('products.id', '=', 'core_meta.subject_id')
                ->where('core_meta.subject_type', Product::class)
                ->where('core_meta.key', 'start_date');
            })
            ->orderBy('event_start_date', 'ASC')
            ->cursorPaginate($this->perPage, ['*'], 'cursor', Cursor::fromEncoded($this->nextCursor));


        $this->events->push(...$events->items()); // Append paginated activities to `public $this->activities`
        $this->prepareNextPage($events);
    }
}
