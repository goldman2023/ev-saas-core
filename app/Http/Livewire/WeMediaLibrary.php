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

    public $media = [];
    public $media_type = 'image';
    public $selected = '';
    public $sort_by = 'newest'; // newest, oldest, smallest, largest
    public $search_string = '';
    public $page = 1;
    public $per_page = 32;

    protected $listeners = [
        'showMediaLibrary' => 'changeMediaLibrary'
    ];

    public function rules() {
        return [
            'media.*' => [],
            'media_type' => [],
            'selected' => [],
            'sort_by' => [Rule::in(SortMediaLibraryEnum::toValues())],
            'search_string' => []
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

    public function changeMediaLibrary($media_type, $selected = null) {
        // dd($this->query()->items());
        $this->media = $this->query()->items();
        $this->selected = $selected;

        $this->dispatchBrowserEvent('display-media-library-modal');
    }

    public function updatedSortBy($value = 'newest') {
        $this->media = $this->query()->items();
    }

    public function updatedSearchString($value) {
        $this->media = $this->query()->items();
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


    public function uploadMedia() {

    }
}