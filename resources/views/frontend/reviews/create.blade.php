@extends('frontend.layouts.company-profile-layout')

@section('company_profile')

<div class="aiz-titlebar text-center mt-2 mb-3 mr-5">

</div>

<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="card">
            <div class="card-header">
                <h1 class="h3">{{translate('Leave a review')}}</h1>
            </div>
            <div class="card-body">
                <form action="{{ route('reviews.store') }}" method="POST">
                    @csrf
                    <div class="form-group mb-3">
                        <label for="name">{{translate('Rating')}}</label>
                        <x-star-rating> </x-star-rating>
                    </div>
                    <div class="form-group mb-3">
                        <label for="comment">{{translate('Comment')}}</label>
                        <textarea id="comment" name="comment" class="short_description form-control" rows="5"
                        placeholder="Input comment" data-test="comment" required></textarea>
                    </div>
                    <input type="hidden" name="company_name" value="{{$company_name}}" />
                    <input type="hidden" name="content_type" value="{{$content_type}}" />
                    <div class="form-group mb-3 text-right">
                        <button type="submit" class="btn btn-primary mr-5">{{translate('Save')}}</button>
                        <a href="{{ route('shop.sub-page', [$company_name, 'reviews'])}}">
                            <button type="button" class="btn btn-primary" data-test="submit">{{translate('Cancel')}}</button>
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
