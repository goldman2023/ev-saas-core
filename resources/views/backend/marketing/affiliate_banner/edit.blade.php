@extends('backend.layouts.app')

@section('content')

    <div class="aiz-titlebar text-left mt-2 mb-3">
        <h5 class="mb-0 h6">{{translate('Affiliate Banner Information')}}</h5>
    </div>

    <div class="row">
        <div class="col-lg-10 mx-auto">
            <div class="card">
                <div class="card-body p-0">
                    <form class="p-4" action="{{ route('admin.affiliate_banner.update', $affiliate_banner->id) }}"
                          method="POST">
                        @csrf
                        <input type="hidden" name="_method" value="PATCH">
                        <input type="hidden" name="lang" value="{{ $lang }}">

                        <div class="form-group row">
                            <label class="col-sm-3 col-from-label" for="title">{{translate('Title')}}</label>
                            <div class="col-sm-9">
                                <input type="text" placeholder="{{translate('Title')}}" aria-describedby="title"
                                       name="title" value="{{ $affiliate_banner->title }}" class="form-control @error('title') is-invalid @enderror"
                                       required>
                                @error('title')
                                <div id="title" class="invalid-feedback">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-from-label" for="campaign">{{translate('Campaign')}}</label>
                            <div class="col-sm-9">
                                <input type="text" placeholder="{{translate('Campaign')}}" name="campaign"
                                       aria-describedby="campaign" value="{{ $affiliate_banner->campaign }}"
                                       class="form-control @error('banner') is-invalid @enderror" required>
                                @error('campaign')
                                <div id="campaign" class="invalid-feedback">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-from-label" for="campaign">{{translate('Refer Url')}}</label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                <input type="text" placeholder="{{translate('Refer Url')}}" name="refer_url"
                                       aria-describedby="refer_url" value="{{ $affiliate_banner->refer_url }}"
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
                            <label class="col-md-3 col-form-label" for="signinSrEmail">{{translate('Banner')}} <small>(1920x500)</small></label>
                            <div class="col-md-9">
                                <div class="input-group" data-toggle="aizuploader" data-type="image">
                                    <div class="input-group-prepend">
                                        <div
                                            class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
                                    </div>
                                    <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                                    <input type="hidden" name="banner" aria-describedby="banner"
                                           value="{{ $affiliate_banner->banner }}" class="selected-files @error('banner') is-invalid @enderror">
                                    @error('banner')
                                    <div id="banner" class="invalid-feedback">
                                        {{$message}}
                                    </div>
                                    @enderror
                                </div>
                                <div class="file-preview box sm">
                                </div>
                            </div>
                        </div>

                        @php
                            $start_date = date('d-m-Y H:i:s', $affiliate_banner->start_date);
                            $end_date = date('d-m-Y H:i:s', $affiliate_banner->end_date);
                        @endphp

                        <div class="form-group row">
                            <label class="col-sm-3 col-from-label" for="start_date">{{translate('Date')}}</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control aiz-date-range @error('date_range') is-invalid @enderror"
                                       value="{{ $start_date.' to '.$end_date }}" name="date_range"
                                       aria-describedby="date_range"
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
