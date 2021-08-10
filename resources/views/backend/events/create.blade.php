@extends('backend.layouts.app')

@section('content')
<div class="aiz-titlebar text-left mt-2 mb-3">
    <h5 class="mb-0 h6">{{translate('Add New Product')}}</h5>
</div>
<div class="">
    <form class="" action="{{route('admin.events.store')}}" method="POST" enctype="multipart/form-data" id="choice_form">
        @csrf
        <div class="card">
            <div class="card-body">
                <div class="form-group row">
                    <label class="col-lg-3 col-from-label">{{translate('Event Title')}} <span class="text-danger">*</span></label>
                    <div class="col-lg-9">
                        <input type="text" class="form-control" name="title" placeholder="{{translate('Event title')}}" value="{{ old('title') }}">
                        @error('title')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-from-label">{{translate('Event Description')}} <span class="text-danger">*</span></label>
                    <div class="col-lg-9">
                        <textarea class="form-control" name="description" value="{{ old('description') }}"></textarea>
                        @error('description')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-from-label">{{ translate('Event Image')}} <span class="text-danger">*</span></label>
                    <div class="col-lg-9">
                        <div class="input-group" data-toggle="aizuploader" data-multiple="false">
                            <div class="input-group-prepend">
                                <div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
                            </div>
                            <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                            <input type="hidden" name="image" value="{{ old('image') }}" class="selected-files">
                        </div>
                        <div class="file-preview box sm">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group mb-0 text-right">
            <button type="submit" class="btn btn-primary" data-test="submit">{{translate('Save Event')}}</button>
        </div>
    </form>
</div>

@endsection

@section('script')

@endsection
