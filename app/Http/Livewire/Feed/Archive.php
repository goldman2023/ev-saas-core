<?php

namespace App\Http\Livewire\Feed;

use App\Enums\StatusEnum;
use App\Models\Category;
use Illuminate\Database\Eloquent\Builder;
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

    public $totalItemsCount;

    public $lastPageNumber;

    public $links;

    public $readyToLoad = false;

    public $loading = false;

    public $sort_by = 'newest';

    public $num_of_cols = 4;

    public $showFilters = false;

    public $filter_categories = [];

    protected $listeners = [
        'refreshArchive' => '$refresh',
        'filterArchive' => 'filterArchive',
        'sortArchive' => 'sortArchive',
        'filterByCategories' => 'filterByCategories',
        'clearAll' => 'clearAll',
    ];

    public function mount($model_class, $showFilters = false)
    {
        $this->perPage = 12; // Should use get_setting() from Tenant Settings
        $this->num_of_cols = 4; // Should use get_setting() from Tenant Settings
        $this->model_class = $model_class;
        $this->showFilters = true;

        $this->fetchArchive();
    }

    public function updatedPage($value)
    {
        $this->fetchArchive();
        // $this->emit('refreshArchive');
    }

    public function updatedSortBy()
    {
        $this->fetchArchive();
    }

    public function sortArchive($sort_by = 'newest')
    {
        $this->sort_by = $sort_by;
        $this->fetchArchive();
    }

    protected function fetchArchive()
    {
        $this->paginator = $this->query();
        $this->totalItemsCount = $this->paginator->total();
        $this->lastPageNumber = $this->paginator->lastPage();
    }

    public function clearAll()
    {
        $this->sort_by = 'newest';
        $this->filter_categories = [];
        $this->page = 1;
        $this->fetchArchive();
        $this->dispatchBrowserEvent('clear-all-filters');
    }

    public function filterArchive($selected_categories, $sort_by)
    {
        $this->sort_by = $sort_by;
        $this->filter_categories = $selected_categories;
        $this->fetchArchive();
    }

    public function render()
    {
        $this->loading = false;

        $this->hasMorePages = $this->paginator->hasMorePages();

        return view('livewire.feed.archive', [
            'items' => $this->paginator,
            'hasMorePages' => $this->hasMorePages,
        ]);
    }

    public function filterByCategories($id)
    {
        if (($key = array_search($id, $this->filter_categories)) !== false) {
            unset($this->filter_categories[$key]);
            $this->filter_categories = array_values($this->filter_categories);
        } else {
            $this->filter_categories[] = $id;
        }

        $this->fetchArchive();
    }

    protected function query()
    {
        return  app($this->model_class)::query()
            ->where('status' , 'published')
            ->when($this->sort_by === 'discount', fn ($query, $value) => $query->discountDesc())
            ->when($this->sort_by === 'price', fn ($query, $value) => $query->priceAsc())
            ->when($this->sort_by === 'newest', fn ($query, $value) => $query->newest())
            ->when($this->sort_by === 'oldest', fn ($query, $value) => $query->oldest())
            ->when($this->sort_by === 'most_popular', fn ($query, $value) => $query->mostPopular())
            ->when($this->sort_by === 'best_rating', fn ($query, $value) => $query->bestRating())
            // ->when(!empty($this->search_query), fn($query, $value) => $query->search($this->search_query))
            // ->where('user_id' , auth()->user()->id)
            ->whereHas('categories', function (Builder $query) {
                if (count($this->filter_categories) > 0) {
                    $query->whereIn('category_id', $this->filter_categories);
                }
            })
            ->paginate(perPage: $this->perPage, page: $this->page);
    }
}
