<x-panels.flyout-panel id="categories-panel" title="{{ translate('Categories') }}" framework="tailwind">

    <h3 class="h4 mb-3 pb-2 border-bottom d-flex align-items-center" x-data="{}">
        <span>{{ translate('Categories') }}</span>
    </h3>

    <div class="c-flyout-panel__items d-flex flex-column mb-1 flex-grow-1">
        <!-- Apps Section -->
        <div class="container-fluid">
            <div class="row">
                <!-- Navbar -->
                <div class="categories-navbar col-12 px-2">
                    @if($categories?->isNotEmpty())
                        @foreach($categories as $parent)
                            @if($parent->products_count > 0)
                                <div class="mt-0 pb-2 mb-2 border-bottom" x-data="{
                                    show: false,
                                }">
                                    <h2 class="h4 d-flex align-items-center justify-content-between mb-0" data-toggle="collapse" href="#flyout-categories-parent-{{ $parent->id }}" role="button"
                                        aria-expanded="false" aria-controls="flyout-categories-parent-{{ $parent->id }}" @click="show = !show">
                                        <span>{{ $parent->name }}</span>

                                        @if(!empty($parent->children) && $parent->children->isNotEmpty())
                                            <span class="transition ease-in-out duration-300 mr-1 d-flex align-items-center" x-bind:style="show && { transform: 'rotate(90deg)' }">
                                                @svg('lineawesome-chevron-circle-right-solid', ['class' => 'square-18'])
                                            </span>
                                        @endif
                                    </h2>

                                    <div class="collapse pt-2" id="flyout-categories-parent-{{ $parent->id }}">
                                        @if(!empty($parent->children) && $parent->children->isNotEmpty())
                                            @foreach($parent->children as $child)
                                                {{-- @if($child->products_count > 0) --}}
                                                    <a class="dropdown-item d-flex justify-content-between align-items-center pl-3 pr-0" href="{{ $child->getPermalink('products') }}">
                                                        {{ $child->name }}
                                                        <span class="badge border badge-pill">{{ $child->products_count }}</span>
                                                    </a>
                                                {{-- @endif --}}
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
</x-panels.flyout-panel>

