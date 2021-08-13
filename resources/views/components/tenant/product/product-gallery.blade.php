@php
    $photos = explode(',', $product->photos);
@endphp

<div class="mt-8 lg:mt-0 lg:col-start-1 lg:col-span-7 lg:row-start-1 lg:row-span-3">
    <h2 class="sr-only">{{ __("Product Images") }}</h2>

    <div class="grid grid-cols-1 lg:grid-cols-2 lg:grid-rows-3 lg:gap-8">
        @foreach ($photos as $key => $photo)
            <div class="@if($key == 0) lg:col-span-2 @endif hidden lg:block rounded-lg">
               <x-tenant.system.image :image="$photo"></x-tenant.system.image>
            </div>
        @endforeach
    </div>
</div>
