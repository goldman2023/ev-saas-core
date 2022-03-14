<?php

namespace App\Http\Livewire;

use App\Models\Upload;
use Livewire\Component;
use App\Traits\Livewire\DispatchSupport;
use App\Enums\SortMediaLibraryEnum;
use Illuminate\Validation\Rule;
use WeBuilder;

class WeMediaLibrary extends Component
{
    use DispatchSupport;

    protected $paginator;
    public $for_id = '';
    public $media = [];
    public $media_type = 'image';
    public $selected = [];
    public $multiple = false;
    public $sort_by = 'newest'; // newest, oldest, smallest, largest
    public $search_string = '';
    public $page = 1;
    public $lastPageNumber = 0;
    public $per_page = 32;
    public $mediaCount = 0;

    protected $listeners = [
        'showMediaLibrary' => 'changeMediaLibrary'
    ];

    public function rules() {
        return [
            'media.*' => [],
            'media_type' => [],
            'selected' => [],
            'sort_by' => [Rule::in(SortMediaLibraryEnum::toValues())],
            'search_string' => [],
            'page' => [],
        ];
    }

    public function messages() {
        return [];
    }

    public function mount() {
        
    }

    public function render() {
        return view('livewire.we-media-library');
    }

    public function changeMediaLibrary($for_id, $media_type, $selected = null) {
        $this->for_id = $for_id;
        
        $this->populateMedia();

        $this->selected = $selected;

        $this->dispatchBrowserEvent('display-media-library-modal');
    }

    public function updatedSortBy($value = 'newest') {
        $this->populateMedia();
    }

    public function updatedSearchString($value) {
        $this->populateMedia();
    }

    public function updatedPage($value) {
        $this->populateMedia();
    }

    protected function query() {
        return Upload::query()
            ->when($this->sort_by === 'newest', fn($query, $value) => $query->newest())
            ->when($this->sort_by === 'oldest', fn($query, $value) => $query->oldest())
            ->when($this->sort_by === 'smallest', fn($query, $value) => $query->smallest())
            ->when($this->sort_by === 'largest', fn($query, $value) => $query->largest())
            ->when(!empty($this->search_query), fn($query, $value) => $query->search($this->search_query))
            ->paginate(perPage: $this->per_page, page: $this->page);
    }

    protected function populateMedia() {
        $this->paginator = $this->query();
        $this->media = $this->paginator->items();
        $this->mediaCount = $this->paginator->total();
        $this->lastPageNumber = $this->paginator->lastPage();
    }


    public function uploadMedia() {

    }
}