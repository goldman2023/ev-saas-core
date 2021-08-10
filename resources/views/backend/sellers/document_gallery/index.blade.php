@extends('backend.layouts.app')

@section('content')

    <div class="row gutters-5">
        <div class="col-lg-6 col-md-6 col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0 h6">{{translate('Company Gallery')}}</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('documentgallery.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label class="col-form-label" for="name">{{translate('Gallery Name')}}</label>
                            <input type="text" placeholder="{{ translate('Name')}}" value="{{ old('name') }}" id="name" name="name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label class="col-form-label" for="signinSrEmail">{{translate('Gallery Images')}}</label>
                            <div class="input-group" data-toggle="aizuploader" data-type="image" data-multiple="true">
                                <div class="input-group-prepend">
                                    <div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
                                </div>
                                <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                                <input type="hidden" name="photos" value="" class="selected-files">
                            </div>
                            <div class="file-preview box sm">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-form-label" for="signinSrEmail">{{translate('Thumbnail Image')}} <small>(290x300)</small></label>
                            <div class="input-group" data-toggle="aizuploader" data-type="image" data-multiple="false">
                                <div class="input-group-prepend">
                                    <div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
                                </div>
                                <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                                <input type="hidden" name="thumbnail_img" value="" class="selected-files">
                            </div>
                            <div class="file-preview box sm">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>{{ translate('Description') }}</label>
                            <textarea class="aiz-text-editor form-control" name="description" data-buttons='[["font", ["bold", "underline", "italic"]],["para", ["ul", "ol"]],["view", ["undo","redo"]]]' placeholder="Type.." data-min-height="150">

                            </textarea>
                        </div>
                        <input type="hidden" name="group_type" value="gallery">
                        <input type="hidden" name="id" value="{{ $seller->id }}">
                        <div class="text-right">
                            <button type="submit" class="btn btn-primary">{{ translate('Save') }}</button>
                        </div>
                        <div class="row justify-content-between mt-3">
                            @foreach($seller->thumbnails as $thumbnail)
                                <div class="w-140px w-lg-220px">
                                    <div class="aiz-file-box">
                                        <div class="dropdown-file" >
                                            <a class="dropdown-link" data-toggle="dropdown">
                                                <i class="la la-ellipsis-v"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a href="{{route('admin.sellers.documentgallery.edit', $thumbnail->group->id)}}" class="dropdown-item" data-id="">
                                                    <i class="las la-info-circle mr-2"></i>
                                                    <span>{{ translate('Details') }}</span>
                                                </a>
                                                <a href="javascript:void(0)" class="dropdown-item confirm-delete" data-href="{{route('documentgallery.destroy', $thumbnail->group->id)}}">
                                                    <i class="las la-trash mr-2"></i>
                                                    <span>{{ translate('Delete') }}</span>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="card card-file aiz-uploader-select c-default">
                                            <div class="card-file-thumb">
                                                @if($thumbnail->file->type == 'image')
                                                    <img src="{{ my_asset($thumbnail->file->file_name) }}" class="img-fit">
                                                @elseif($thumbnail->file->type == 'video')
                                                    <i class="las la-file-video"></i>
                                                @else
                                                    <i class="las la-file"></i>
                                                @endif
                                            </div>
                                            <div class="card-body">
                                                <h5 class="mb-0">{{ $thumbnail->group->name }}</h5>
                                                <h6 class="d-flex">
                                                    <span class="text-truncate title">{{ $thumbnail->file->file_original_name }}</span>
                                                    <span class="ext">.{{ $thumbnail->file->extension }}</span>
                                                </h6>
                                                <p>{{ formatBytes($thumbnail->file->file_size) }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
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
                    <form action="{{ route('documentgallery.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label class="col-form-label" for="name">{{translate('Document Name')}}</label>
                            <input type="text" placeholder="{{ translate('Name')}}" id="name" name="name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="signinSrEmail">{{ translate('File') }}</label>
                            <div class="input-group " data-toggle="aizuploader" data-type="document" data-multiple="false">
                                <div class="input-group-prepend">
                                    <div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse') }}</div>
                                </div>
                                <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                                <input type="hidden" name="document_file" value="" class="selected-files">
                            </div>
                            <div class="file-preview"></div>
                        </div>
                        <div class="form-group">
                            <label>{{ translate('Description') }}</label>
                            <textarea class="aiz-text-editor form-control" name="description" data-buttons='[["font", ["bold", "underline", "italic"]],["para", ["ul", "ol"]],["view", ["undo","redo"]]]' placeholder="Type.." data-min-height="150">

                            </textarea>
                        </div>
                        <input type="hidden" name="group_type" value="document">
                        <input type="hidden" name="id" value="{{ $seller->id }}">
                        <div class="text-right">
                            <button type="submit" class="btn btn-primary">{{ translate('Save') }}</button>
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
                                <th>{{ translate('Name')}}</th>
                                <th>{{ translate('File')}}</th>
                                <th class="text-right">{{ translate('Options')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($seller->documents as $index => $document)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $document->group->name }}</td>
                                    <td>{{ $document->file->file_original_name . "." . $document->file->extension }}</td>
                                    <td class="text-right">
                                        <a class="btn btn-soft-primary btn-icon btn-circle btn-sm" href="{{route('admin.sellers.documentgallery.edit', $document->group->id)}}" title="{{ translate('Edit') }}">
                                            <i class="las la-edit"></i>
                                        </a>
                                        <a href="#" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete" data-href="{{route('documentgallery.destroy', $document->group->id)}}" title="{{ translate('Delete') }}">
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
