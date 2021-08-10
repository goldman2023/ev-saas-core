<a href="{{ route('wishlists.index') }}" class="d-flex align-items-center justify-content-center text-reset mr-3">
    <i class="la la-heart-o la-2x opacity-80"></i>
    <span class="flex-grow-1 ml-1">
        @if (Auth::check())
            <span class="badge badge-primary badge-inline badge-pill">{{ count(auth()->user()->wishlists) }}</span>
        @else
            <span class="badge badge-primary badge-inline badge-pill">0</span>
        @endif
        {{-- <span class="nav-box-text d-none d-xl-block opacity-70">{{translate('Company Matches')}}</span> --}}
    </span>
</a>
