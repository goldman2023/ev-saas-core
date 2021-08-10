@extends('backend.layouts.app')

@section('content')

    <div class="row">
        <div class="col-lg-6">
            <div class="card">
              <div class="card-header">
                  <h5 class="mb-0 h6">{{translate('Seller Commission')}}</h5>
              </div>
              <div class="card-body">
                  <form class="form-horizontal" action="{{ route('admin.business_settings.vendor_commission.update') }}" method="POST" enctype="multipart/form-data">
                  	@csrf
                    <div class="form-group row">
                        <input type="hidden" name="type" value="{{ $business_settings->type }}">
                        <label class="col-lg-3 control-label">{{ translate('Seller Commission') }}</label>
                        <div class="col-lg-9">
                            <div class="input-group">
                                <input type="number" lang="en" min="0" step="0.01" value="{{ $business_settings->value }}" placeholder="{{translate('Seller Commission')}}" name="value" class="form-control">
                                <div class="input-group-append">
                                    <span class="input-group-text">%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-0 text-right">
                        <button type="submit" class="btn btn-primary">{{translate('Save')}}</button>
                    </div>
                  </form>
              </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0 h6">{{translate('Note')}}</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        <li class="list-group-item text-muted">
                            1. {{ $business_settings->value }}% {{translate('of seller product price will be deducted from seller earnings') }}.
                        </li>
                        <li class="list-group-item text-muted">
                            2. {{translate('This commission only works when Category Based Commission is turned off from Business Settings') }}.
                        </li>
                        <li class="list-group-item text-muted">
                            3. {{translate('Commission doesn\'t work if seller package system add-on is activated') }}.
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

@endsection
