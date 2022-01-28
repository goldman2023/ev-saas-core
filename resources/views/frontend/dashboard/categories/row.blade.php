{{--<tr wire:key="category-item-{{ $category->id }}">--}}
{{--    <td>--}}
{{--        {{ $category->id }}--}}
{{--        <input wire:model="categories." name=""/>--}}
{{--    </td>--}}
{{--    <td >--}}
{{--        {{ (str_repeat('-', $category->level)).$category?->getTranslation('name') ?? $category->name }}--}}
{{--    </td>--}}
{{--    <td class="hidden md:table-cell">--}}
{{--        @if($category->featured)--}}
{{--            <span class="badge badge-soft-success">--}}
{{--              <span class="legend-indicator bg-success mr-1"></span> {{ 'Featured' }}--}}
{{--            </span>--}}
{{--        @else--}}
{{--            <span class="badge badge-soft-danger">--}}
{{--              <span class="legend-indicator bg-danger mr-1"></span> {{ 'Not featured' }}--}}
{{--            </span>--}}
{{--        @endif--}}
{{--    </td>--}}
{{--    <td class="hidden md:table-cell">--}}
{{--        0--}}
{{--    </td>--}}
{{--    <td class="hidden md:table-cell">--}}
{{--        {{ $category->created_at->format('d.m.Y') }}--}}
{{--    </td>--}}
{{--    <td >--}}
{{--        <div class="btn-group" role="group">--}}
{{--              {{ route('order.details', ['id' => $category->id]) }}--}}
{{--            <a class="btn btn-sm btn-white" href="#">--}}
{{--                <i class="tio-visible-outlined"></i> {{ translate('View') }}--}}
{{--            </a>--}}
{{--        </div>--}}
{{--    </td>--}}
{{--</tr>--}}
@php
    $slug_path = preg_replace('/\.(.+?)(?=\.|$)/i', "['$1']", 'categories.'.implode('.children.', explode('.', $category->slug_path)));
@endphp
<tr :key="'category-item-'+{{$slug_path}}.id">
    <td x-text="{{$slug_path}}.id" class="align-middle"></td>
    <td x-text="'-'.repeat({{$slug_path}}.level) + {{$slug_path}}.name" class="align-middle"></td>
    <td class="hidden md:table-cell align-middle">
        <template x-if="{{$slug_path}}.featured">
            <span class="badge badge-soft-success">
              <span class="legend-indicator bg-success mr-1"></span> {{ 'Featured' }}
            </span>
        </template>
        <template x-if="!{{$slug_path}}.featured">
            <span class="badge badge-soft-danger">
              <span class="legend-indicator bg-danger mr-1"></span> {{ 'Not featured' }}
            </span>
        </template>
    </td>
    <td class="hidden md:table-cell align-middle" x-text="{{$slug_path}}.descendants_count"></td>
    <td class="hidden md:table-cell align-middle" x-text="{{$slug_path}}.created_at"></td>
    <td class="align-middle">
        <div class="btn-group" role="group">
{{--              {{ route('order.details', ['id' => $row->id]) }}--}}
            <a class="btn btn-sm btn-white d-flex align-items-center" href="{{ route('category.edit', ['id' => $category->id]) }}">
                @svg('heroicon-o-eye', ['class' => 'square-18 mr-2']) {{ translate('View') }}
            </a>
        </div>
    </td>
</tr>

@if(!empty($category->children))
    @foreach($category->children->sortBy('id') as $child)
        @include('frontend.dashboard.categories.row', ['category' => $child])
    @endforeach
@endif
