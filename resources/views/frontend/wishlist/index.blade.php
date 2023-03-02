@extends('frontend.layouts.user_panel')

@section('panel_content')
<x-dashboard.section-headers.section-header title="{{ translate('Your saved items') }}" text="">
    <x-slot name="content">

    </x-slot>
</x-dashboard.section-headers.section-header>
<div class="container mb-3">
    <div class="w-full">

        <div class="w-full">
            @foreach ($wishlists as $key => $wishlist)
            @if($wishlist->count() > 0)
            <div class="grid gap-6 grid-cols-12">
                @foreach($wishlist as $item)
                @if($item->subject_type == 'App\Models\Product')
                <div class="col-span-12 mb-3">
                    <x-default.products.product-card :product="$item->subject"></x-default.products.product-card>
                </div>
                @endif

                @endforeach
            </div>
            @else

            @endif
            @endforeach
        </div>
    </div>

</div>


@endsection
