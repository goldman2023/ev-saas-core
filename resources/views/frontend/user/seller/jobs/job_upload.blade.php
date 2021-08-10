@extends('frontend.layouts.user_panel')

@section('panel_content')

    <div class="aiz-titlebar mt-2 mb-4">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h1 class="h3">{{ translate('New Job') }}</h1>
            </div>
        </div>
    </div>
    <form class="" action="{{route('jobs.store')}}" method="POST" enctype="multipart/form-data" id="choice_form">
        @csrf
        <input type="hidden" name="shop_id" value="{{auth()->user()->shop->id}}">
        <div class="card">
            <div class="card-body">
                <div class="form-group row">
                    <label class="col-lg-3 col-from-label">{{translate('Title')}} <span class="text-danger">*</span></label>
                    <div class="col-lg-9">
                        <input type="text" class="form-control" name="title" placeholder="{{translate('Job title')}}" value="{{ old('title') }}">
                        @error('title')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-from-label">{{translate('Excerpt')}} <span class="text-danger">*</span></label>
                    <div class="col-lg-9">
                        <textarea class="form-control" name="excerpt" value="{{ old('excerpt') }}"></textarea>
                        @error('excerpt')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-from-label">{{ translate('Content')}} <span class="text-danger">*</span></label>
                    <div class="col-lg-9">
                        <textarea class="form-control" name="content" value="{{ old('content') }}"></textarea>
                        @error('excerpt')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group mb-0 text-right">
            <button type="submit" class="btn btn-primary">{{translate('Save Job')}}</button>
        </div>
    </form>

@endsection
