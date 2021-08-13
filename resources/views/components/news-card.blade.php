<!-- Property Item -->
<a class="card card-no-gutters h-100"
   href="{{ route('news.details', $item->slug) }}"
>

    <div>
        <img class="img-fluid rounded-lg" src="{{ uploaded_asset($item->banner) }}"
             data-src="{{ uploaded_asset($item->banner) }}" alt="{{ $item->title }}"
             class="img-fluid lazyload ">
    </div>

    <!-- Body -->
    <div class="card-body">
        <span class="d-block font-size-1 text-body"> {{ $item->category->name }}</span>

        @if ($item->user != null)
            <span class="d-block font-size-2 text-body"><i class="las la-user text-muted mr-1"></i></span>
        @endif
        @if($item->estimated_time != null)
            <span class="d-block font-size-2 text-body"><i class="las la-clock text-muted mr-1"></i>{{$item->estimated_time ." " . translate('min. Read')}}</span>
        @endif
        <div class="row align-items-center">
            <div class="col">
                <h4 class="text-hover-primary">{{ $item->title }}</h4>

                <p>
                    {{ $item->short_description }}
                </p>
            </div>

        </div>

        <ul class="list-inline list-separator font-size-1 text-body">
            @if(visits($item)->count() != null || visits($item,'auth')->count() != null)
                <li class="list-inline-item">
                    <i class="las la-eye text-muted mr-1"></i>
                </li>
            @endif
            <li class="list-inline-item">
                <i class="las la-comment text-muted mr-1"></i> 2 {{translate('Comments')}}
            </li>
            <li class="list-inline-item">
                <i class="las la-calendar text-muted mr-1"></i> {{ $item->created_at->diffForHumans() }}
            </li>
        </ul>
    </div>
    <!-- End Body -->
</a>
<!-- End Property Item -->


