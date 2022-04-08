<?php

namespace App\Http\Livewire\Feed;

use Illuminate\Support\Facades\Session;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Activitylog\Models\Activity;

class Archive extends Component
{
    use WithPagination;

    protected $paginator;
    public $perPage = 12;
    public $model_class;
    public $items;
    public $totalItemsCount;
    public $lastPageNumber;
    public $links;
    public $readyToLoad = false;
    public $loading = false;
    public $type = 'recent';
    public $num_of_cols = 4;

    public function mount($model_class)
    {
        $this->perPage = 1; // Should use get_setting() from Tenant Settings
        $this->num_of_cols = 4; // Should use get_setting() from Tenant Settings
        $this->model_class = $model_class;

        $this->fetchArchive();
    }

    public function updatedPage($value) {
        $this->fetchArchive();
        $this->emit('$refresh');
    }

    protected function fetchArchive() {
        $this->paginator = $this->query();
        $this->items = $this->paginator->items();
        $this->totalItemsCount = $this->paginator->total();
        $this->lastPageNumber = $this->paginator->lastPage();
    }

    

    public function render()
    {
        $this->loading = false;

        $this->hasMorePages = $this->paginator->hasMorePages();

        return view('livewire.feed.archive', [
            'hasMorePages' => $this->hasMorePages
        ]);
    }

    protected function query() {
        return  app($this->model_class)::query()
            // ->when($this->sort_by === 'newest', fn($query, $value) => $query->newest())
            // ->when($this->sort_by === 'oldest', fn($query, $value) => $query->oldest())
            // ->when($this->sort_by === 'smallest', fn($query, $value) => $query->smallest())
            // ->when($this->sort_by === 'largest', fn($query, $value) => $query->largest())
            // ->when(!empty($this->search_query), fn($query, $value) => $query->search($this->search_query))
            // ->where('user_id' , auth()->user()->id)
            ->paginate(perPage: $this->perPage, page: $this->page);
    }

    public function loadMore()
    {
        $this->loading = true;
        $this->perPage += 10;
    }
}