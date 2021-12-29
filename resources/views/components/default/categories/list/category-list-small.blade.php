<div>
    <!-- Category List Small -->
    <!-- Component used: https://htmlstream.com/front/snippets/ecommerce.html#component-1 -->

    <!-- Categories Section -->
    <div class="container space-1 position-relative">
        <!-- Title -->
        <div class="w-md-80 w-lg-40 text-center mx-md-auto mb-3 mb-md-9">
            <x-ev.label tag="h2" class="h1" :label="ev_dynamic_translate('Categories Title', true)">
            </x-ev.label>
        </div>
        <!-- End Title -->
        <div class="row mb-2 @if ($slider) ev-horizontal-slider flex-nowrap @endif" style="overflow: auto;">
            @foreach ($categories as $category)
                <!-- Card -->
                <div class="col-sm-4 col-10 mb-3">
                    <a class="card card-bordered card-hover-shadow h-100" href="{{ route('products.category', $category->slug) }}">
                        <div class="card-body">
                            <div class="media align-items-center">
                                    <x-tenant.system.image class="avatar avatar-sm  mr-3" :image="$category->banner">
                                    </x-tenant.system.image>
                                <div class="media-body">
                                    <h5 class="text-hover-primary mb-0">{{ $category->name }}</h5>
                                    <small>
                                      {{ $category->products_count }}  {{ translate('Products') }}
                                    </small>
                                </div>

                                <div class="align-self-center text-muted text-hover-primary pl-2 ml-auto">
                                    <i class="fas fa-angle-right"></i>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- End Card -->
            @endforeach
        </div>

        <div class="text-center">
            <p class="small">
                <x-ev.label :label="ev_dynamic_translate('Categories List Footer Text', true)">
                </x-ev.label>
            </p>
        </div>
    </div>
    <!-- End Categories Section -->
</div>

@push('footer_scripts')

@endpush
