<?php

namespace App\Http\Livewire;

use App\Enums\SortMediaLibraryEnum;
use App\Models\Upload;
use App\Traits\Livewire\DispatchSupport;
use Auth;
use Exception;
use File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Image;
use Livewire\Component;
use Livewire\WithFileUploads;
use MediaService;
use MyShop;
use WeBuilder;

class WeMediaLibrary extends Component
{
    use DispatchSupport;
    use WithFileUploads;

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

    public $per_page = 24;

    public $mediaCount = 0;

    public $new_media = [];

    protected $listeners = [
        'showMediaLibrary' => 'changeMediaLibrary',
    ];

    public function rules()
    {
        return [
            'media.*' => [],
            'new_media.*' => [],
            'media_type' => [],
            'selected' => [],
            'sort_by' => [Rule::in(SortMediaLibraryEnum::toValues())],
            'search_string' => [],
            'page' => [],
        ];
    }

    public function messages()
    {
        return [];
    }

    public function mount()
    {
    }

    public function render()
    {
        return view('livewire.we-media-library');
    }

    public function changeMediaLibrary($for_id, $media_type, $selected = null)
    {
        $this->for_id = $for_id;

        $this->populateMedia();

        $this->selected = $selected;

        $this->dispatchBrowserEvent('display-media-library-modal');
    }

    public function updatedSortBy($value = 'newest')
    {
        $this->populateMedia();
    }

    public function updatedSearchString($value)
    {
        $this->populateMedia();
    }

    public function updatedPage($value)
    {
        $this->populateMedia();
    }

    public function updatedNewMedia($value)
    {
        try {
            $this->validate([
                'new_media.*' => 'file|max:10240', // 10MB Max; TODO: Store  WeMediaLibrary max file size somewhere in tenant settings
            ]);
        } catch (\Exception $e) {
            if ($e instanceof \Illuminate\Validation\ValidationException) {
                $title = collect($e->validator->errors()->messages())->first()[0] ?? '';
            } elseif ($e instanceof \Exception) {
                $title = $e->getMessage();
            }

            $this->inform($title, '', 'fail');
            $this->new_media = []; // reset new_media (basically, get rid of the livewire temp files added to $new_media)

            return;
        }

        if (! empty($this->new_media)) {
            foreach ($this->new_media as $key => $media) {
                $upload = new Upload();

                $extension = $media->guessExtension();

                if (isset(MediaService::getPermittedExtensions()[$extension])) {
                    $upload->file_original_name = null;

                    $arr = explode('.', $media->getClientOriginalName());
                    for ($i = 0; $i < count($arr) - 1; $i++) {
                        if ($i == 0) {
                            $upload->file_original_name .= $arr[$i];
                        } else {
                            $upload->file_original_name .= '.'.$arr[$i];
                        }
                    }

                    $tenant_path = 'uploads/all';

                    if (tenant('id')) {
                        $tenant_path = 'uploads/'.tenant('id');
                    }

                    // Check if tenant uploads folder exists an create it if not
                    // dd(Storage::disk('do')->exists($tenant_path));
                    if (! Storage::disk('do')->exists($tenant_path)) { 
                        // Create Tenant folder on DO if it doesn't exist
                        Storage::makeDirectory($tenant_path, 0775, true, true);
                    }

                    try {
                        Storage::makeDirectory($tenant_path, 0775, true, true);
                    } catch(\Exception $e) {

                    }

                    $new_filename = time().'_'.$media->getClientOriginalName();

                    $wtf = $media->storeAs($tenant_path, $new_filename, 'do');
                    $upload->extension = $extension;
                    $upload->file_name = $tenant_path.'/'.$new_filename;
                    $upload->user_id = auth()->user()->id;
                    $upload->shop_id = empty(MyShop::getShopID()) ? null : MyShop::getShopID();
                    $upload->type = MediaService::getPermittedExtensions()[$extension];
                    $upload->file_size = $media->getSize();
                    $upload->save();

                    $this->new_media[$key] = $upload;
                }
            }
        }
    }

    protected function query()
    {
        return Upload::query()
            ->when($this->sort_by === 'newest', fn ($query, $value) => $query->newest())
            ->when($this->sort_by === 'oldest', fn ($query, $value) => $query->oldest())
            ->when($this->sort_by === 'smallest', fn ($query, $value) => $query->smallest())
            ->when($this->sort_by === 'largest', fn ($query, $value) => $query->largest())
            ->when(! empty($this->search_query), fn ($query, $value) => $query->search($this->search_query))
            ->where('user_id', auth()->user()->id)
            ->paginate(perPage: $this->per_page, page: $this->page);
    }

    protected function populateMedia()
    {
        $this->paginator = $this->query();
        $this->media = $this->paginator->items();
        $this->mediaCount = $this->paginator->total();
        $this->lastPageNumber = $this->paginator->lastPage();
    }
}
