<div class="row">
    {{-- TODO: this is not picking up right categories right now --}}
    @foreach (\App\Utility\CategoryUtility::get_immediate_children_ids($category_id) as $key => $id)
    <div class="col-sm-4 col-6 mb-3">
        <a class="card card-bordered card-hover-shadow h-100"
            href="{{ route('products.category', \App\Models\Category::find($id)->slug) }}">
            <div class="card-body">
                <div class="media align-items-center d-block d-sm-flex text-sm-left text-center">

                    {{-- TODO: Show last product image if there is no icon --}}
                    <x-tenant.system.image class="d-inline d-sm-inline avatar avatar-sm avatar-circle mr-sm-3 mb-2 mb-sm-0"
                        :image="\App\Models\Category::find($id)->icon">
                    </x-tenant.system.image>
                    <div class="media-body">
                        <h5 class="text-hover-primary mb-0">
                            {{ \App\Models\Category::find($id)->getTranslation('name') }}
                            <div>
                                <small>
                                    {{-- TODO: Make this dynamic --}}
                                    {{ translate('Products') }}: 5


                                </small>
                            </div>
                        </h5>
                    </div>

                    <div class="align-self-center text-muted text-hover-primary pl-2 ml-auto">

                    @svg('heroicon-s-chevron-right', ["class" => 'ev-icon__xs mr-2'])

                    </div>
                </div>
            </div>
        </a>



    </div>

    @endforeach
</div>
