<div class="card card-flush">
    <div class="row align-items-md-center">
        <div class="col-md-6">
            <x-tenant.system.image class="card-img rounded-2" :image="$item->getThumbnail(['w'=>600]) ?? ''">
            </x-tenant.system.image>
        </div>
        <!-- End Col -->

        <div class="col-md-6">
            <div class="card-body">
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
                <h3 class="h3">
                    <a class="text-dark" href="
                        {{  $item->getPermalink() }}">
                        {{ $item->title }}
                    </a>
                </h3>
                <p class=" card-text">
                        {!! $item->description !!}
                        </p>

                        <a class="card-link" href="{{ route('news.details', $item->slug) }}">
                            {{ translate('Read more') }} <i class="bi-chevron-right small ms-1"></i></a>
            </div>
        </div>
        <!-- End Col -->
    </div>
    <!-- End Row -->
</div>
