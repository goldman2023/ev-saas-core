@if ($company->gallery_uploads_groups->count() > 0)
    <div class="row">
        <div class="col-12 mb-3">
            <h1>{{ $company->user->shop->name }} {{ translate('gallery') }}</h1>
        </div>
    </div>
    <div class="row mx-n2 flex-wrap">
        @foreach ($company->user->seller->gallery_uploads_groups as $index => $item)
            @foreach ($item->uploads_content_relations as $thumbnail)
                <div class="col-sm-6 col-md-4 px-2 mb-3">
                    <div class="h-250rem bg-img-hero">
                        @if ($thumbnail->file->type == 'image')
                            <img src="{{ my_asset($thumbnail->file->file_name) }}" class="img-fit h-100">
                        @elseif($thumbnail->file->type == 'video')
                            <i class="las la-file-video"></i>
                        @else
                            <i class="las la-file"></i>
                        @endif
                    </div>
                    <div class="text-center text-sm mt-1"> {{ $thumbnail->group->description }} </div>
                </div>
            @endforeach
        @endforeach
    </div>
@else
    <x-empty-state-card title="No images or videos so far" text='' routeOwner='documentgallery.edit' route='contact'>
    </x-empty-state-card>
    @auth
        @if (auth()->user()->id === $company->user->id)
            <div class="text-center">
                <a class="btn btn-primary" target="_blank" href="{{ route('documentgallery.index') }}">
                    {{ translate('Manage Gallery') }}
                </a>
            </div>
        @endif
    @endauth
@endif
<!-- End Gallery Section -->
