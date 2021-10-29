@if($categories)
    <div class="row mt-2">
        @foreach ($categories as $key => $category)
            <div class="col-sm-4 col-6 mb-3">
                <a class="card card-bordered card-hover-shadow h-100"
                   href="{{ route('products.category', $category->slug) }}">
                    <div class="card-body d-flex align-items-center">
                        <div class="media align-items-center d-block d-sm-flex text-sm-left text-center w-100">
                            {{-- TODO: Show last product image if there is no icon --}}
                            <x-tenant.system.image class="d-inline d-sm-inline avatar avatar-sm avatar-circle mr-sm-3 mb-2 mb-sm-0" :image="$category->icon" fit="cover">
                            </x-tenant.system.image>
                            <div class="media-body">
                                <h5 class="text-hover-primary mb-0">
                                    {{ $category->getTranslation('name') }}
                                    <div>
                                        <small>
                                            {{ translate('Products') }}: {{ $category->products_count ?? '?' }}
                                        </small>
                                    </div>
                                </h5>
                            </div>

                            <div class="align-self-center text-muted text-hover-primary pl-2 ml-auto">
                                @svg('heroicon-s-chevron-right', ["class" => 'ev-icon__xs mr-2'])
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>
@endif

