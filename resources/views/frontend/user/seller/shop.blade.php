@extends('frontend.layouts.user_panel')

@section('panel_content')

    <div class="aiz-titlebar mt-2 mb-4">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h1 class="h3">{{ translate('Company Data')}}
                    <a href="{{ route('shop.visit', $shop->slug) }}" class="btn btn-link btn-sm"
                       target="_blank">({{ translate('Visit Company Profile')}})<i class="la la-external-link"></i>)</a>
                </h1>
            </div>
        </div>
    </div>

    {{-- Basic Info --}}
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0 h6">
                {{ translate('Business Profile') }}
            </h5>
        </div>
        <div class="card-body">
            <form class="" action="{{ route('shops.update', $shop->id) }}" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="_method" value="PATCH">
                @csrf
                <div class="row">
                    <label class="col-md-2 col-form-label">{{ translate('Company Name') }}<span
                            class="text-danger text-danger">*</span></label>
                    <div class="col-md-10">
                        <input type="text" class="form-control mb-3 @error('name') is-invalid @enderror"
                               placeholder="{{ translate('Company Name')}}" name="name" value="{{ $shop->name }}"
                               required>
                        @error('name')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-md-2 col-form-label">{{ translate('Company Logo') }}</label>
                    <div class="col-md-10">
                        <div class="input-group" data-toggle="aizuploader" data-type="image">
                            <div class="input-group-prepend">
                                <div
                                    class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
                            </div>
                            <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                            <input type="hidden" name="logo" value="{{ $shop->logo }}" class="selected-files">
                        </div>
                        <div class="file-preview box sm">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <label class="col-md-2 col-form-label">{{ translate('Company Address') }} <span
                            class="text-danger text-danger">*</span></label>
                    <div class="col-md-10">
                        <input type="text" class="form-control mb-3 @error('address') is-invalid @enderror"
                               placeholder="{{ translate('Address')}}" name="address" value="{{ $shop->address }}"
                               required>
                        @error('address')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                </div>
                @if (\App\Models\BusinessSetting::where('type', 'shipping_type')->first()->value == 'seller_wise_shipping')
                    <div class="row">
                        <div class="col-md-2">
                            <label>{{ translate('Shipping Cost')}} <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-md-10">
                            <input type="number" lang="en" min="0" class="form-control mb-3"
                                   placeholder="{{ translate('Shipping Cost')}}" name="shipping_cost"
                                   value="{{ $shop->shipping_cost }}" required>
                        </div>
                    </div>
                @endif
                @if (\App\Models\BusinessSetting::where('type', 'pickup_point')->first()->value == 1)
                <div class="row mb-3 d-none">
                    <label class="col-md-2 col-form-label">{{ translate('Pickup Points') }}</label>
                    <div class="col-md-10">
                        <select class="form-control aiz-selectpicker" data-placeholder="{{ translate('Select Pickup Point') }}" id="pick_up_point" name="pick_up_point_id[]" multiple>
                            @foreach (\App\Models\PickupPoint::all() as $pick_up_point)
                                @if (auth()->user()->shop->pick_up_point_id != null)
                                    <option value="{{ $pick_up_point->id }}" @if (in_array($pick_up_point->id, json_decode(auth()->user()->shop->pick_up_point_id))) selected @endif>{{ $pick_up_point->getTranslation('name') }}</option>
                                @else
                                    <option value="{{ $pick_up_point->id }}">{{ $pick_up_point->getTranslation('name') }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                @endif

                <div class="row d-none">
                    <label class="col-md-2 col-form-label">{{ translate('Meta Title') }}<span
                            class="text-danger text-danger">*</span></label>
                    <div class="col-md-10">
                        <input type="text" class="form-control mb-3" placeholder="{{ translate('Meta Title')}}"
                               name="meta_title" value="{{ $shop->meta_title }}">
                    </div>
                </div>
                <div class="row">
                    <label class="col-md-2 col-form-label">{{ translate('Company Description') }}<span
                            class="text-danger text-danger">*</span></label>
                    <div class="col-md-10">
                        <textarea name="meta_description" rows="3"
                                  class="form-control @error('meta_description') is-invalid @enderror mb-3 "
                                  required>{{ $shop->meta_description }}</textarea>
                        @error('meta_description')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="form-group mb-0 text-right">
                    <button type="submit" class="btn btn-sm btn-primary">{{translate('Save')}}</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Banner Settings --}}
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0 h6">{{ translate('Cover Image') }}</h5>
        </div>
        <div class="card-body">
            <form class="" action="{{ route('shops.update', $shop->id) }}" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="_method" value="PATCH">
                @csrf

                <div class="row mb-3">
                    <label class="col-md-2 col-form-label">{{ translate('Banners') }} (1500x450)</label>
                    <div class="col-md-10">
                        <div class="input-group" data-toggle="aizuploader" data-type="image" data-multiple="true">
                            <div class="input-group-prepend">
                                <div
                                    class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
                            </div>
                            <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                            <input type="hidden" name="sliders" value="{{ $shop->sliders }}" class="selected-files">
                        </div>
                        <div class="file-preview box sm">
                        </div>
                        <small
                            class="text-muted">{{ translate('We had to limit height to maintian consistancy. In some device both side of the banner might be cropped for height limitation.') }}</small>
                    </div>
                </div>

                <div class="form-group mb-0 text-right">
                    <button type="submit" class="btn btn-sm btn-primary">{{translate('Save')}}</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Social Media Link --}}
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0 h6">{{ translate('Social Media Links') }}</h5>
        </div>
        <div class="card-body">
            <form class="" action="{{ route('shops.update', $shop->id) }}" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="_method" value="PATCH">
                @csrf
                <div class="form-box-content p-3">
                    <div class="row mb-3">
                        <label class="col-md-2 col-form-label">{{ translate('Facebook') }}</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control @error('facebook') is-invalid @enderror"
                                   placeholder="{{ translate('Facebook')}}" name="facebook"
                                   value="{{ $shop->facebook }}">
                            <small class="text-muted">{{ translate('Insert link with https ') }}</small>
                            @error('facebook')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-md-2 col-form-label">{{ translate('Twitter') }}</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control @error('twitter') is-invalid @enderror"
                                   placeholder="{{ translate('Twitter')}}" name="twitter" value="{{ $shop->twitter }}">
                            <small class="text-muted">{{ translate('Insert link with https ') }}</small>
                            @error('twitter')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                            @enderror
                        </div>
                    </div>
                    {{--  {{TODO : we need to change migration for Google and Youtube to Instagram and Linkedin just so we don't get confused 😃}}--}}
                    <div class="row mb-3">
                        <label class="col-md-2 col-form-label">{{ translate('Instagram') }}</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control @error('instagram') is-invalid @enderror"
                                   placeholder="{{ translate('Instagram')}}" name="instagram"
                                   value="{{ $shop->google }}">
                            <small class="text-muted">{{ translate('Insert link with https ') }}</small>
                            @error('instagram')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-md-2 col-form-label">{{ translate('LinkedIn') }}</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control @error('linkedin') is-invalid @enderror"
                                   placeholder="{{ translate('LinkedIn')}}" name="linkedin"
                                   value="{{ $shop->youtube }}">
                            <small class="text-muted">{{ translate('Insert link with https ') }}</small>
                            @error('linkedin')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="form-group mb-0 text-right">
                    <button type="submit" class="btn btn-sm btn-primary">{{translate('Save')}}</button>
                </div>
            </form>
        </div>
    </div>

@endsection
