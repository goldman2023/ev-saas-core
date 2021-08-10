@extends('backend.layouts.app')

@section('content')

    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card">
                <div class="card-header">
                    <h1 class="mb-0 h6">{{ translate('SEO Settings') }}</h1>
                </div>
                <div class="card-body">
                    <form action="{{ route('seo.update_seo_setting') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group row">
                            <label class="col-md-3 col-from-label">{{translate('Enable Event Seo?')}}</label>
                            <div class="col-md-8">
                                <label class="aiz-switch aiz-switch-success mb-0">
                                    <input type="hidden" name="types[]" value="enable_seo_event">
                                    <input type="checkbox" name="enable_seo_event" @if(get_setting('enable_seo_event') == 'on') checked @endif>
                                    <span></span>
                                </label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-from-label">{{translate('Enable News Seo?')}}</label>
                            <div class="col-md-8">
                                <label class="aiz-switch aiz-switch-success mb-0">
                                    <input type="hidden" name="types[]" value="enable_seo_news">
                                    <input type="checkbox" name="enable_seo_news" @if(get_setting('enable_seo_news') == 'on') checked @endif>
                                    <span></span>
                                </label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-from-label">{{translate('Enable Company Seo?')}}</label>
                            <div class="col-md-8">
                                <label class="aiz-switch aiz-switch-success mb-0">
                                    <input type="hidden" name="types[]" value="enable_seo_company">
                                    <input type="checkbox" name="enable_seo_company" @if(get_setting('enable_seo_company') == 'on') checked @endif>
                                    <span></span>
                                </label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-from-label">{{translate('Enable Product Seo?')}}</label>
                            <div class="col-md-8">
                                <label class="aiz-switch aiz-switch-success mb-0">
                                    <input type="hidden" name="types[]" value="enable_seo_product">
                                    <input type="checkbox" name="enable_seo_product" @if(get_setting('enable_seo_product') == 'on') checked @endif>
                                    <span></span>
                                </label>
                            </div>
                        </div>
                        <div class="text-right">
                            <button type="submit" class="btn btn-primary">{{ translate('Update') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
