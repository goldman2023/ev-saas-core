<div x-data="{
    all_categories: @entangle('all_categories'),
    search_query: @entangle('search_query'),
}" x-cloak>
{{--    x-init="console.log(categories['Weapons-jm06m']['children']['Firearms-OXcMJ']['children']['T4E-guns-9rJJI'].id);"--}}
    <x-ev.loaders.spinner class="absolute-center z-10 d-none"
                          wire:loading.class.remove="d-none"></x-ev.loaders.spinner>

    <div class="container-fluid p-0" wire:loading.class="opacity-3">

        <div class="d-md-flex justify-content-between mb-3">
            <div class="d-md-flex">
                <div class="mb-3 mb-md-0 input-group">
                    <input placeholder="{{ translate('Search') }}" type="text" class="form-control"
                           @input.debounce.700ms="$wire.set('search_query', $($el).val(), true); $wire.searchByQuery();">
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th class="">
                        <span>{{ translate('ID') }}</span>
                    </th>

                    <th class="">
                        {{ translate('Name') }}
                    </th>

                    <th class="hidden md:table-cell">
                        {{ translate('Featured') }}
                    </th>

                    <th class="hidden md:table-cell">
                        {{ translate('Children') }}
                    </th>

                    <th class="hidden md:table-cell">
                        {{ translate('Date') }}
                    </th>

                    <th class="">
                        {{ translate('Actions') }}
                    </th>
                </tr>
                </thead>

                <tbody>

                    @if(!empty($all_categories))
                        @foreach($all_categories as $category)
                            <tr wire:key="category-item-{{ $category->id }}">
                                <td>
                                    {{ $category->id }}
                                </td>
                                <td >
                                    {{ (str_repeat('-', $category->level)).$category?->getTranslation('name') ?? $category->name }}
                                </td>
                                <td class="hidden md:table-cell">
                                    @if($category->featured)
                                        <span class="badge badge-soft-success">
                                          <span class="legend-indicator bg-success mr-1"></span> {{ 'Featured' }}
                                        </span>
                                    @else
                                        <span class="badge badge-soft-danger">
                                          <span class="legend-indicator bg-danger mr-1"></span> {{ 'Not featured' }}
                                        </span>
                                    @endif
                                </td>
                                <td class="hidden md:table-cell">
                                    {{ $category->descendants_count ?? 0 }}
                                </td>
                                <td class="hidden md:table-cell">
                                    {{ $category->created_at->format('d.m.Y') }}
                                </td>
                                <td >
                                    <div class="btn-group" role="group">
                                        <a class="btn btn-sm btn-white d-flex align-items-center" href="{{ route('category.edit', ['id' => $category->id]) }}">
                                            @svg('heroicon-o-eye', ['class' => 'square-18 mr-2']) {{ translate('View') }}
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>

            </table>
        </div>
        <div class="row">
            <div class="col-12 text-muted">
                Showing <strong>{{ $all_categories->count() }}</strong> results
            </div>
        </div>
    </div>
</div>
