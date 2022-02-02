<div class="card w-100 mb-3">
    {{-- TODO: Make link dynamic in component settings --}}
    <a href="{{ route('ev-products.create') }}" class="card-body d-flex flex-column">
        <div class="pb-2">
            @svg('heroicon-o-credit-card', ['class' => 'square-32'])
        </div>
        <h5 class="text-20">
            {{ $title }}
        </h5>
        <p class="text-dark text-14 mb-4">
            {{ $description }}
        </p>
        <span class="text-link d-flex align-items-center mt-auto">
            {{ translate('Create') }}
            @svg('heroicon-o-arrow-narrow-right', ['class' => 'square-16 ml-2'])
        </span>
    </a>
</div>
