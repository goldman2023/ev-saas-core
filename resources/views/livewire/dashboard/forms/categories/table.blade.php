<div x-data="{
    categories: @entangle('categories'),
    search_query: @entangle('search_query'),
}" x-cloak>
{{--    x-init="console.log(categories['Weapons-jm06m']['children']['Firearms-OXcMJ']['children']['T4E-guns-9rJJI'].id);"--}}
    <x-ev.loaders.spinner class="absolute-center z-10 d-none"
                          wire:loading.class.remove="d-none"></x-ev.loaders.spinner>

    <div class="container-fluid p-0">

        <div class="d-md-flex justify-content-between mb-3">
            <div class="d-md-flex">
                <div class="mb-3 mb-md-0 input-group">
{{--                    <input x-model.debounce.700ms="search_query" placeholder="{{ translate('Search') }}" type="text" class="form-control">--}}
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
                    @if(!empty($categories))
                        @foreach($categories as $category)
                            @include('frontend.dashboard.categories.row', ['category' => $category])
                        @endforeach
                    @endif
                </tbody>

            </table>
        </div>
        <div class="row">
            <div class="col-12 text-muted">
{{--                Showing <strong>0</strong>--}}
{{--                results--}}
            </div>
        </div>
    </div>
</div>
