<div class="row ">
    <div class="col-sm-8 px-sm-1 position-static">
        <!-- Gallery -->
        <a class="js-fancybox-item d-block" href="javascript:;" style="height: 400px;">
            <x-tenant.system.image class="img-fluid w-100 h-100" fit="cover" :image="$product->getThumbnail(['w'=>600]) ?? ''">
            </x-tenant.system.image>
        </a>
    </div>
    <div class="col-md-4 d-none d-md-inline-block px-1">
        <!-- Gallery -->
        <a class="js-fancybox-item d-block mb-2" href="javascript:;" style="height: 196px;">
            @foreach($product->getGallery(['w' => 300]) as $item)
            <x-tenant.system.image class="img-fluid w-100 h-100" fit="cover" :image="$item ?? ''">
            </x-tenant.system.image>
            @endforeach
        </a>
        <!-- End Gallery -->
    </div>
</div>
