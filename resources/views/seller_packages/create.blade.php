@extends('backend.layouts.app')

@section('content')

    <div class="col-lg-10 mx-auto">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0 h6">{{translate('Create New Seller Package')}}</h5>
            </div>

            <form class="form-horizontal" action="{{ route('admin.seller_packages.store') }}" method="POST" enctype="multipart/form-data">
            	@csrf
                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-sm-2 col-from-label" for="name">{{translate('Package Name')}}</label>
                        <div class="col-sm-10">
                            <input type="text" placeholder="{{translate('Name')}}" id="name" name="name" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-from-label" for="amount">{{translate('Amount')}}</label>
                        <div class="col-sm-10">
                            <input type="number" min="0" step="0.01" placeholder="{{translate('Amount')}}" id="amount" name="amount" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-from-label" for="product_upload">{{translate('Product Upload')}}</label>
                        <div class="col-sm-10">
                            <input type="number" min="0" step="1" placeholder="{{translate('Product Upload')}}" id="product_upload" name="product_upload" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-from-label" for="digital_product_upload">{{translate('Digital Product Upload')}}</label>
                        <div class="col-sm-10">
                            <input type="number" min="0" step="1" placeholder="{{translate('Digital Product Upload')}}" id="digital_product_upload" name="digital_product_upload" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-from-label" for="duration">{{translate('Duration')}}</label>
                        <div class="col-sm-10">
                            <input type="number" min="0" step="1" placeholder="{{translate('Validity in number of days')}}" id="duration" name="duration" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label" for="signinSrEmail">{{translate('Package Logo')}}</label>
                        <div class="col-md-10">
                            <div class="input-group" data-toggle="aizuploader" data-type="image" data-multiple="false">
                                <div class="input-group-prepend">
                                    <div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
                                </div>
                                <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                                <input type="hidden" name="logo" class="selected-files">
                            </div>
                            <div class="file-preview box sm">
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-0 text-right">
                        <button type="submit" class="btn btn-sm btn-primary">{{translate('Save')}}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection
