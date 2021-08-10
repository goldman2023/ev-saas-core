@extends('frontend.layouts.user_panel')

@section('panel_content')

    <div class="aiz-titlebar mt-2 mb-4">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h1 class="h3">{{ translate('Events') }}</h1>
            </div>
        </div>
    </div>
    <form class="" action="{{route('events.store')}}" method="POST" enctype="multipart/form-data" id="choice_form">
        @csrf
        <div class="card">
            <div class="card-body">
                <div class="form-group row">
                    <label class="col-lg-3 col-from-label">{{translate('Event Title')}} <span class="text-danger">*</span></label>
                    <div class="col-lg-9">
                        <input type="text" class="form-control" name="title" data-test="title" placeholder="{{translate('Event title')}}" value="{{ old('title') }}">
                        @error('title')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-from-label">{{translate('Event Description')}} <span class="text-danger">*</span></label>
                    <div class="col-lg-9">
                        <textarea class="form-control" name="description" data-test="description" value="{{ old('description') }}"></textarea>
                        @error('description')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-from-label">{{ translate('Event Image')}} <span class="text-danger">*</span></label>
                    <div class="col-lg-9">
                        <div class="input-group" data-toggle="aizuploader" data-multiple="false" data-test="image">
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

@endsection
