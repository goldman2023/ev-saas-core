@if ($company->user->seller->document_uploads_groups->count() > 0)
    <div class="row">
        <div class="col-12 mb-3">
            <h1>
                {{ translate('Documents by ') }}
                {{ $company->user->shop->name }}
                <hr>
        </div>
    </div>
    <ul class="list-group">

        @foreach ($company->user->seller->document_uploads_groups as $index => $document)

            @foreach ($document->uploads_content_relations as $file)


                <!-- List Item -->
                <li class="list-group-item">
                    <div class="row align-items-center gx-2">
                        <div class="col-auto">
                            <img class="avatar avatar-xs avatar-4by3"
                                src="{{ asset('assets/svg/brands/google-docs.svg') }}" alt="Image Description">
                        </div>

                        <div class="col">
                            <h5 class="mb-0">
                                <a class="text-dark" href="#">{{ $document->name }}</a>
                            </h5>
                            <ul class="list-inline list-separator small">
                                <li class="list-inline-item">
                                    {{ $file->file->file_original_name . '.' . $file->file->extension }}</li>
                                <li class="list-inline-item">{{ formatBytes($file->file->file_size) }}</li>
                            </ul>
                        </div>

                        <div class="col-auto">

                        </div>
                    </div>
                    <!-- End Row -->
                </li>
                <!-- End List Item -->
            @endforeach
        @endforeach
    </ul>

@else
    <x-empty-state-card title="No documents so far" text='' routeOwner='documentgallery.edit' route='contact'>
    </x-empty-state-card>

    @auth
        @if (auth()->user()->id === $company->user->id)
            <div class="text-center">
                <a class="btn btn-primary" target="_blank" href="{{ route('documentgallery.index') }}">
                    {{ translate('Manage Documents') }}
                </a>
            </div>
        @endif
    @endauth
@endif
