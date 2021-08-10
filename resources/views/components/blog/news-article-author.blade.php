<div class="border-top border-bottom py-4 mb-5">
    <div class="row align-items-md-center">
        <div class="col-md-7 mb-5 mb-md-0">
            <div class="media align-items-center">
                @if($blog->user->avatar)
                <div class="avatar avatar-circle">
                    <img class="avatar-img" src="{{ $blog->user->avatar != null ? $blog->user->avatar : '' }}"
                         alt="B2BWood News - Forestry industry news">
                </div>
                @endif
                <div class="media-body font-size-1">
                    {{-- TODO : add a link to author page or company page --}}
                    <span class="h6">
                                    <a href="#">
                                        {{ $blog->user->name }}
                                    </a>
                                </span>
                    <span class="d-block text-muted">
                        {{ $blog->created_at->diffForHumans() }}
                    </span>
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="d-flex justify-content-md-end align-items-center">
                <span class="d-block small font-weight-bold text-cap mr-2">{{ translate('Share:') }}</span>

                <a class="btn btn-xs btn-icon btn-soft-secondary rounded-circle ml-2" href="#">
                    <i class="la la-facebook-f"></i>
                </a>
                <a class="btn btn-xs btn-icon btn-soft-secondary rounded-circle ml-2" href="#">
                    <i class="la la-twitter"></i>
                </a>
                <a class="btn btn-xs btn-icon btn-soft-secondary rounded-circle ml-2" href="#">
                    <i class="la la-instagram"></i>
                </a>
                <a class="btn btn-xs btn-icon btn-soft-secondary rounded-circle ml-2" href="#">
                    <i class="la la-telegram"></i>
                </a>
            </div>
        </div>
    </div>
</div>
