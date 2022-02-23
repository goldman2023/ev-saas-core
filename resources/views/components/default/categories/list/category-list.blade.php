<div class="row mb-2">
    @foreach ($categories as $category)
    <div class="col-md-12 mb-3">
        <!-- Card -->
        <a href="{{ $category->getPermalink()}}">
            <div class="row no-gutters align-items-center ">
                <div class="we-category-card d-flex align-items-center w-100">
                    <div class="col" style="min-width: 80px;">
                        <x-tenant.system.image class="img-fluid img-round" style="width: 60px; height: 60px;"
                            :image="$category->getThumbnail()">
                        </x-tenant.system.image>
                    </div>
                    <div class="col pl-3">
                        <span class="mb-1 fs-16 we-category-title">{{ $category->name }}</span>
                    </div>
                    <div class="col d-flex align-items-center">
                        <div class="badge badge-danger mb-0 mr-3">
                            {{ $category->products()->count() }}

                        </div>
                        <div class="d-flex align-items-center pr-3">
                            {{ svg('heroicon-o-chevron-right', ['class' => 'ev-icon__xs text-black mr-2 mb-0']) }}

                        </div>
                    </div>
                </div>

            </div>
        </a>

        <div class="card card-bordered shadow-none d-none">
            <div class="card-body d-flex align-items-center p-0">
                <div class="w-65 border-right">
                    <x-tenant.system.image class="img-fluid" :image="$category->getThumbnail()">
                    </x-tenant.system.image>
                </div>
                <div class="w-35">
                    <div class="border-bottom">
                        @php
                        $category_product_image = $category
                        ->products()
                        ->latest('id')
                        ->first();

                        $category_product_image2 = $category
                        ->products()
                        ->latest('id')
                        ->offset(1)
                        ->first();
                        @endphp
                        @if ($category_product_image)
                        <x-tenant.system.image alt="" class="img-fluid" :image="$category_product_image->thumbnail_img">
                        </x-tenant.system.image>
                        @endif

                    </div>
                    @if ($category_product_image2)
                    <x-tenant.system.image alt="" class="img-fluid" :image="$category_product_image2->thumbnail_img">
                    </x-tenant.system.image>
                    @endif
                </div>
            </div>
            <div class="card-footer d-block text-center py-4">
                <h3 class="mb-1">{{ $category->name }}</h3>
                <span class="d-block text-muted font-size-1 mb-3">
                    {{ $category->products()->count() }}
                    {{ translate('products') }}</span>

                <a class="btn btn-sm btn-outline-primary btn-pill transition-3d-hover px-5"
                    href="{{ route('category.products.index', $category->slug) }}">
                    {{ translate('View Products') }}
                </a>
            </div>
        </div>
        <!-- End Card -->
    </div>


    @endforeach
</div>
