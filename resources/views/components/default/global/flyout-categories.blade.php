<x-default.global.flyout-panel id="categories-panel" title="{{ translate('Categories') }}">

    <h3 class="h4 mb-3 pb-2 border-bottom d-flex align-items-center" x-data="{}">
        <span>{{ translate('Categories') }}</span>
    </h3>

    <div class="c-flyout-panel__items d-flex flex-column mb-1 flex-grow-1">
        <!-- Apps Section -->
        <div class="container-fluid">
            <div class="row">
                <!-- Navbar -->
                <div class="categories-navbar col-12 px-0">
                    @if($categories?->isNotEmpty())
                        @foreach($categories as $parent)
                            @if($parent->products_count > 0)
                                <div class="mt-0 mb-2 border-bottom" x-data="{
                                    show: false,
                                }">
                                    <h2 class="h4" data-toggle="collapse" href="#flyout-categories-parent-{{ $parent->id }}" role="button"
                                        aria-expanded="false" aria-controls="flyout-categories-parent-{{ $parent->id }}" @click="show = !show">
                                        {{ $parent->name }}
                                    </h2>

                                    <div class="collapse" id="flyout-categories-parent-{{ $parent->id }}">
                                        @if(!empty($parent->children) && $parent->children->isNotEmpty())
                                            @foreach($parent->children as $child)
                                                @if($child->products_count > 0)
                                                    <a class="dropdown-item d-flex justify-content-between align-items-center pl-3 pr-0" href="{{ $child->permalink }}">
                                                        {{ $child->name }}
                                                        <span class="badge border badge-pill">{{ $child->products_count }}</span>
                                                    </a>
                                                @endif
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    @endif

                </div>
                <!-- End Navbar -->
            </div>
        </div>
        <!-- End Apps Section -->
    </div>
</x-default.global.flyout-panel>
