@extends('backend.layouts.app')

@section('content')

    <div class="row">
        <div class="col-lg-10 mx-auto">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0 h6">{{translate('Affiliate Banner Information')}}</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.affiliate_banner.store') }}" method="POST">
                        @csrf
                        {{--                    @dd($errors->all())--}}
                        <div class="form-group row">
                            <label class="col-sm-3 control-label" for="title">{{translate('Title')}}</label>
                            <div class="col-sm-9">
                                <input type="text" placeholder="{{translate('Title')}}" value="{{old('title')}}"
                                       aria-describedby="title" name="title"
                                       class="form-control @error('title') is-invalid @enderror"
                                       required>
                                @error('title')
                                <div id="title" class="invalid-feedback">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 control-label" for="campaign">{{translate('Campaign')}}</label>
                            <div class="col-sm-9">
                                <input type="text" placeholder="{{translate('Campaign')}}" value="{{old('campaign')}}"
                                       aria-describedby="campaign" name="campaign"
                                       class="form-control @error('campaign') is-invalid @enderror" required>
                                @error('campaign')
                                <div id="campaign" class="invalid-feedback">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label" for="refer_url">{{translate('Refer Url')}}</label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                <input type="text" placeholder="{{translate('Refer Url')}}" value="{{old('refer_url')}}"
                                       name="refer_url" aria-describedby="refer_url"
                                       class="form-control @error('refer_url') is-invalid @enderror" required>
                                @error('refer_url')
                                <div id="refer_url" class="invalid-feedback">
                                    {{$message}}
                                </div>
                                @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label" for="banner">{{translate('Banner')}} <small>(1920x500)</small></label>
                            <div class="col-md-9">
                                <div class="input-group" data-toggle="aizuploader" data-type="image">
                                    <div class="input-group-prepend">
                                        <div
                                            class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
                                    </div>
                                    <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                                    <input type="hidden" name="banner" aria-describedby="banner"
                                           class="selected-files @error('banner') is-invalid @enderror">
                                </div>
                                <div class="file-preview box sm">
                                </div>
                                <span
                                    class="small text-muted">{{ translate('This image is shown as cover banner in affiliate banner details page.') }}</span>
                                @error('banner')
                                <div id="banner" class="invalid-feedback">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>

                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 control-label" for="date_range">{{translate('Date')}}</label>
                            <div class="col-sm-9">
                                <input type="text"
                                       class="form-control @error('date_range') is-invalid @enderror aiz-date-range"
                                       aria-describedby="date_range"
                                       value="{{old('date_range')}}" name="date_range"
                                       placeholder="Select Date" data-time-picker="true" data-format="DD-MM-Y HH:mm:ss"
                                       data-separator=" to " autocomplete="off" required="">
                                @error('date_range')
                                <div id="date_range" class="invalid-feedback">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group mb-0 text-right">
                            <button type="submit" class="btn btn-primary">{{translate('Save')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

