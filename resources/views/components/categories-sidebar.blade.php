<div class="bg-white shadow-sm rounded mb-3">
    <div class="fs-15 fw-600 p-3 border-bottom">
        {{ translate('Industries')}}
    </div>

    @php
        $category_route = $type.".category";
        $index_route = "companies.index";
        if($type == "events") 
            $index_route = "events";
        
    @endphp
        
    <div class="p-3">
        <ul class="list-unstyled">
            @if (!isset($category_id))
                @foreach (\App\Models\Category::where('level', 0)->get() as $category)
                    <li class="mb-2 ml-2">
                        <a class="text-reset fs-14" href="{{ route($category_route, $category->slug) }}">{{ $category->getTranslation('name') }}</a>
                    </li>
                @endforeach
            @else
                <li class="mb-2">
                    <a class="text-reset fs-14 fw-600" href="{{ route($index_route) }}">
                        <i class="las la-angle-left"></i>
                        {{ translate('All Industries')}}
                    </a>
                </li>
                @if (\App\Models\Category::find($category_id)->parent_id != 0)
                    <li class="mb-2">
                        <a class="text-reset fs-14 fw-600" href="{{ route($category_route, \App\Models\Category::find(\App\Models\Category::find($category_id)->parent_id)->slug) }}">
                            <i class="las la-angle-left"></i>
                            {{ \App\Models\Category::find(\App\Models\Category::find($category_id)->parent_id)->getTranslation('name') }}
                        </a>
                    </li>
                @endif
                <li class="mb-2">
                    <a class="text-reset fs-14 fw-600" href="{{ route($category_route, \App\Models\Category::find($category_id)->slug) }}">
                        <i class="las la-angle-left"></i>
                        {{ \App\Models\Category::find($category_id)->getTranslation('name') }}
                    </a>
                </li>
                @foreach (\App\Utility\CategoryUtility::get_immediate_children_ids($category_id) as $key => $id)
                    <li class="ml-4 mb-2">
                        <a class="text-reset fs-14" href="{{ route($category_route, \App\Models\Category::find($id)->slug) }}">{{ \App\Models\Category::find($id)->getTranslation('name') }}</a>
                    </li>
                @endforeach
            @endif
        </ul>
    </div>
</div>