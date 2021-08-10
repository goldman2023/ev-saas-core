@extends('frontend.layouts.user_panel')

@section('panel_content')
    <div class="row gutters-5">
        <div class="col-lg-6 col-md-6 col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0 h6">{{ translate('Company Gallery') }}</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('documentgallery.store') }}" method="POST" enctype="multipart/form-data"
                        id="gallery-form">
                        @csrf
                        <div class="form-group">
                            <label class="col-form-label" for="name">{{ translate('Gallery Name') }}</label>
                            <input type="text"
                            value="{{ old('name') }}"
                            placeholder="{{ translate('Name') }}" id="name" name="name" data-test="name"
                                class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label class="col-form-label" for="signinSrEmail">{{ translate('Gallery Images') }}</label>
                            <div class="input-group" data-toggle="aizuploader" data-type="image" data-multiple="true">
                                <div class="input-group-prepend">
                                    <div class="input-group-text bg-soft-secondary font-weight-medium">
                                        {{ translate('Browse') }}</div>
                                </div>
                                <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                                <input type="hidden" name="photos" data-test="photos" value="" class="selected-files">
                            </div>
                            <div class="file-preview box sm"></div>
                            @error('photos')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>{{ translate('Description') }}</label>
                            <textarea class="aiz-text-editor form-control" name="description"
                                data-buttons='[["font", ["bold", "underline", "italic"]],["para", ["ul", "ol"]],["view", ["undo","redo"]]]'
                                placeholder="Type.." data-min-height="150">

                                </textarea>
                        </div>
                        <input type="hidden" name="group_type" value="gallery">
                        <input type="hidden" name="id" value="{{ $seller->id }}">
                        <div class="text-right">
                            <button type="submit" class="btn btn-primary">{{ translate('Save') }}</button>
                        </div>
                        <ul class="list-group mt-3">
                            @foreach ($seller->gallery_uploads_groups as $group)
                                @php
                                    $thumbnail = $group->uploads_content_relations->where('type', 'thumbnail')->first();
                                @endphp
                                <li class="list-group-item">
                                    <div class="row align-items-center gx-2">
                                        <div class="col-auto">
                                            @if ($thumbnail != null)
                                                <img class="avatar avatar-xs avatar-4by3"
                                                    src="{{ my_asset($thumbnail->file->file_name) }}"
                                                    alt="Thumbnail Image">
                                            @else
                                                <img class="avatar avatar-xs avatar-4by3"
                                                    src="{{ asset('assets/svg/brands/google-docs.svg') }}"
                                                    alt="Thumbnail Image">
                                            @endif
                                        </div>

                                        <div class="col">
                                            <h5 class="mb-0">
                                                <a class="text-dark" href="#">{{ $group->name }}</a>
                                            </h5>
                                        </div>

                                        <div class="col-auto">
                                            <a class="btn btn-soft-primary btn-icon btn-circle btn-sm"
                                                href="{{ route('documentgallery.edit', $group->id) }}"
                                                title="{{ translate('Edit') }}">
                                                <i class="las la-edit"></i>
                                            </a>
                                            <a href="#"
                                                class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete"
                                                data-href="{{ route('documentgallery.destroy', $group->id) }}"
                                                title="{{ translate('Delete') }}">
                                                <i class="las la-trash"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <!-- End Row -->
                                </li>
                            @endforeach
                        </ul>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-12">
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">{{ translate('Company Documents') }}</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('documentgallery.store') }}" method="POST" enctype="multipart/form-data"
                        id="document-form">
                        @csrf
                        <div class="form-group">
                            <label class="col-form-label" for="name">{{ translate('Document Name') }}</label>
                            <input type="text" placeholder="{{ translate('Name') }}" id="name" name="name"
                                class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="signinSrEmail">{{ translate('File') }}</label>
                            <div class="input-group " data-toggle="aizuploader" data-multiple="false">
                                <div class="input-group-prepend">
                                    <div class="input-group-text bg-soft-secondary font-weight-medium">
                                        {{ translate('Browse') }}</div>
                                </div>
                                <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                                <input type="hidden" name="document_file" value="" class="selected-files">
                            </div>
                            <div class="file-preview"></div>
                            @error('document_file')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>{{ translate('Description') }}</label>
                            <textarea class="aiz-text-editor form-control" name="description" data-test="description"
                                data-buttons='[["font", ["bold", "underline", "italic"]],["para", ["ul", "ol"]],["view", ["undo","redo"]]]'
                                placeholder="Type.." data-min-height="150">

                                </textarea>
                        </div>
                        <input type="hidden" name="group_type" value="document">
                        <input type="hidden" name="id" value="{{ $seller->id }}">
                        <div class="text-right">
                            <button type="submit" class="btn btn-primary" data-test="submit">{{ translate('Save') }}</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">{{ translate('Documents') }}</h6>
                </div>
                <div class="card-body">
                    <table class="table aiz-table mb-0 mt-3">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ translate('Name') }}</th>
                                <th>{{ translate('File') }}</th>
                                <th class="text-right">{{ translate('Options') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($seller->document_uploads_groups as $index => $group)
                                @php
                                    $document = $group->uploads_content_relations->where('type', 'document')->first();
                                @endphp
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $document->group->name }}</td>
                                    <td>{{ $document->file->file_original_name . '.' . $document->file->extension }}</td>
                                    <td class="text-right">
                                        <a class="btn btn-soft-primary btn-icon btn-circle btn-sm"
                                            href="{{ route('documentgallery.edit', $document->group->id) }}"
                                            title="{{ translate('Edit') }}">
                                            <i class="las la-edit"></i>
                                        </a>
                                        <a href="#" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete"
                                            data-href="{{ route('documentgallery.destroy', $document->group->id) }}"
                                            title="{{ translate('Delete') }}">
                                            <i class="las la-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modal')
    @include('modals.delete_modal')
@endsection
