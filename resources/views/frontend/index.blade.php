@extends('frontend.layouts.app')

@section('content')

<section>
    <x-default.brands.brands-list>
    </x-default.brands.brands-list>
</section>

<section class="overflow-hidden">
    <x-default.hero.product-hero></x-default.hero.product-hero>
</section>

<section>
    <div class="container">
        <div class="row">
            <div class="col-12 mt-3">
                <x-default.products.recently-viewed-products></x-default.products.recently-viewed-products>

            </div>
        </div>
    </div>
</section>

<section class="space-1">
    <x-default.products.product-list :slider="false">
    </x-default.products.product-list>
</section>



<section>
    <x-default.promo.reviews></x-default.promo.reviews>
</section>


@guest
<section>
    <x-default.forms.contact-form></x-default.forms.contact-form>
</section>
@endguest

@endsection
