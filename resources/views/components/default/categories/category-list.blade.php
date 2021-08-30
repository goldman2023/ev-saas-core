<div>
    <!-- Component used: https://htmlstream.com/front/snippets/ecommerce.html#component-1 -->

    <!-- Categories Section -->
    <div class="container space-2 position-relative">
        <!-- Title -->
        <div class="w-md-80 w-lg-40 text-center mx-md-auto mb-5 mb-md-9">
            <x-ev.label
            tag="h2"
            class="h1"
            :label="ev_dynamic_translate('Categories Title', true)">
            </x-ev.label>
        </div>
        <!-- End Title -->
        <div class="row mb-2 @if($slider) ev-slick @endif">
            @foreach ($categories as $category)
                <div class="col-md-4 mb-3">
                    <!-- Card -->
                    <div class="card card-bordered shadow-none d-block">
                        <div class="card-body d-flex align-items-center p-0">
                            <div class="w-65 border-right">
                                <x-tenant.system.image class="img-fluid" :image="$category->banner">
                                </x-tenant.system.image>
                            </div>
                            <div class="w-35">
                                <div class="border-bottom">
                                    <img class="img-fluid"
                                        src="https://www.timberindustrynews.com/wp-content/uploads/2018/05/Holzindustrie-Schweighofer-timber-310x220.jpg"
                                        alt="Image Description">
                                </div>
                                <img class="img-fluid"
                                    src="https://www.timberindustrynews.com/wp-content/uploads/2018/05/Holzindustrie-Schweighofer-timber-310x220.jpg"
                                    alt="Image Description">
                            </div>
                        </div>
                        <div class="card-footer d-block text-center py-4">
                            <h3 class="mb-1">{{ $category->name }}</h3>
                            <span class="d-block text-muted font-size-1 mb-3">
                                {{ $category->products()->count() }}
                                {{ translate('products') }}</span>

                            <a class="btn btn-sm btn-outline-primary btn-pill transition-3d-hover px-5" href="{{ route('products.category', $category->slug) }}">
                                {{ translate('View Products') }}
                            </a>
                        </div>
                    </div>
                    <!-- End Card -->
                </div>


            @endforeach
        </div>

        <div class="text-center">
            <p class="small">
                <x-ev.label
                :label="ev_dynamic_translate('Categories List Footer Text', true)">
                </x-ev.label>
            </p>
        </div>
    </div>
    <!-- End Categories Section -->
</div>

@push('footer_scripts')

@endpush
