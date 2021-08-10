@extends('frontend.layouts.user_panel')

@section('panel_content')
    <div class="row gutters-5">
        <div class="col-lg-6 col-md-6 col-12">
            <div class="card">
                <form action="{{ route('documentgallery.update', ['id' => $upload_group->id]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @if ($group_type != "document")
                        @php 
                            $thumbnail = $upload_group->uploads_content_relations->where('type', 'thumbnail')->first();
                            $images = $upload_group->uploads_content_relations->where('type', 'image');
                        @endphp
                        <div class="card-header">
                            <h5 class="mb-0 h6">{{translate('Edit Gallery')}}</h5>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label class="col-form-label" for="name">{{translate('Gallery Name')}}</label>                        
                                <input type="text" placeholder="{{ translate('Name')}}" value="{{ $upload_group->name }}" id="name" name="name" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label class="col-form-label" for="signinSrEmail">{{translate('Gallery Images')}}</label>                        
                                <div class="input-group" data-toggle="aizuploader" data-type="image" data-multiple="true">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
                                    </div>
                                    <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                                    <input type="hidden" name="photos" value="{{ implode(',', $images->pluck('upload_id')->toArray()) }}" class="selected-files">
                                </div>
                                <div class="file-preview box sm"></div>
                                @error('photos')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="col-form-label" for="signinSrEmail">{{translate('Thumbnail Image')}} <small>(290x300)</small></label>                       
                                <div class="input-group" data-toggle="aizuploader" data-type="image" data-multiple="false">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
                                    </div>
                                    <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                                    <input type="hidden" name="thumbnail_img" value="{{ $thumbnail != null ? $thumbnail->upload_id : '' }}" class="selected-files">
                                </div>
                                <div class="file-preview box sm">
                                </div>
                            </div>
                            <div class="form-group">
                                <label>{{ translate('Description') }}</label>                            
                                <textarea class="aiz-text-editor form-control" name="description" data-buttons='[["font", ["bold", "underline", "italic"]],["para", ["ul", "ol"]],["view", ["undo","redo"]]]' placeholder="Type.." data-min-height="150">
                                    {{ $upload_group->description }}
                                </textarea>
                            </div>
                            <input type="hidden" name="group_type" value="gallery" />               
                            <div class="text-right">
                                <button type="submit" class="btn btn-primary">{{ translate('Update') }}</button>
                            </div>                            
                        </div>
                    @else
                        @php
                            $document = $upload_group->uploads_content_relations->where('type', 'document')->first();
                        @endphp
                        <div class="card-header">
                            <h6 class="mb-0">{{ translate('Edit Document') }}</h6>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label class="col-form-label" for="name">{{translate('Document Name')}}</label>                        
                                <input type="text" placeholder="{{ translate('Name')}}" value="{{ $upload_group->name }}" id="name" name="name" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="signinSrEmail">{{ translate('File') }}</label>
                                <div class="input-group " data-toggle="aizuploader" data-multiple="false">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse') }}</div>
                                    </div>
                                    <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                                    <input type="hidden" name="document_file" value="{{ $document->upload_id }}" class="selected-files">
                                </div>
                                <div class="file-preview"></div>
                                @error('document_file')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>{{ translate('Description') }}</label>
                                <textarea class="aiz-text-editor form-control" name="description" data-buttons='[["font", ["bold", "underline", "italic"]],["para", ["ul", "ol"]],["view", ["undo","redo"]]]' placeholder="Type.." data-min-height="150">
                                    {{ $upload_group->description }}
                                </textarea>
                            </div>
                            <input type="hidden" name="group_type" value="document" />              
                            <div class="text-right">
                                <button type="submit" class="btn btn-primary">{{ translate('Update') }}</button>
                            </div>
                        </div>
                    @endif
                </form>
            </div>
        </div>        
    </div>
@endsection