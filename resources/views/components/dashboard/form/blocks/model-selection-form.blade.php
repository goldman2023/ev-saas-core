<div class="col-span-12 md:col-span-6 flex flex-col gap-y-2" x-data="{
    image_src: '{{ $defaultModel?->getThumbnail() ?? \IMG::getPlaceholder(proxify: false)['url'] ?? '' }}',
    item_title: @js($constructTitle(prefix: $itemTitlePrefix, suffix: $itemTitleSuffix)),
    item_subtitle: @js($constructSubtitle(prefix: $itemSubtitlePrefix, suffix: $itemSubtitleSuffix)),
    constructTitle(item = null, prefix = '{{ $itemTitlePrefix }}', suffix = '{{ $itemTitleSuffix }}') {
        try {
            let modelTitleProperty = @js($modelTitleProperty);
            if(Array.isArray(modelTitleProperty) && modelTitleProperty.length > 0) {
                return prefix + modelTitleProperty.reduce(
                    (accumulator, prop) => accumulator + item[prop]+' ',
                    ''
                ) + suffix;
            }

            return prefix + item[modelTitleProperty] + suffix;
        } catch(error) {
            return '{{ $emptySelectedItemTitle }}';
        }
    },
    constructSubtitle(item = null, prefix = '{{ $itemSubtitlePrefix }}', suffix = '{{ $itemSubtitleSuffix }}') {
        try {
            let modelSubtitleProperty = @js($modelSubtitleProperty);
            if(Array.isArray(modelSubtitleProperty) && modelSubtitleProperty.length > 0) {
                return prefix + modelSubtitleProperty.reduce(
                    (accumulator, prop) => accumulator + item[prop]+' ',
                    ''
                ) + suffix;
            }

            return prefix + item[modelSubtitleProperty] + suffix;
        } catch(error) {
            return '{{ $emptySelectedItemSubtitle }}';
        }
    }
}">

    @if(!$inline)
        <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
            {{ $fieldTitle }}
        </label>

        <div class="relative flex items-center space-x-3 rounded-lg border border-gray-300 bg-white px-6 py-5 shadow-sm focus-within:ring-2 focus-within:ring-indigo-500 focus-within:ring-offset-2 hover:border-gray-400"
            @click="$dispatch('display-modal', {'id': '{{ $modalId }}' })">
            <div class="flex-shrink-0">
                <img class="h-12 w-12 rounded-full object-contain p-1 border" :src="image_src" alt="">
            </div>
            <div class="min-w-0 flex-1">
                <div class="focus:outline-none cursor-pointer">
                    <span class="absolute inset-0" aria-hidden="true"></span>
                    <p class="text-sm font-medium text-gray-900" x-text="item_title"></p>
                    <p class="truncate text-sm text-gray-500" x-text="item_subtitle"></p>
                </div>
            </div>
        </div>
    @endif

    @php
        ob_start();
    @endphp
    <div class="w-full flex flex-col" :class="{'opacity-40 pointer-events-none': processing}" x-data="{
        processing: false,
        q: '',
        defaultResults: @js($defaultResults ?? []),
        results: @js($defaultResults ?? []),
        search() {
            this.processing = true;

            wetch.get('{{ $apiRoute }}?q='+this.q)
            .then(data => {
                if(data.status === 'success' && data.results) {
                    this.results = data.results;
                }
            })
            .catch(error => {
                alert(error);
            })
            .finally(() => {
                this.processing = false;
            });
        },
        reset() {
            this.q = '';
            this.results = this.defaultResults;
        },
        select(item) {
            try {
                @if(!$inline)
                    {{ $field }} = item?.id;
                    item_title = constructTitle(item);
                    item_subtitle = constructSubtitle(item);
                    image_src = window.WE.IMG.url(item.thumbnail?.file_name);

                    @php
                        echo $customSelectLogic;
                    @endphp
                @else
                    @php
                        echo $customSelectLogic;
                    @endphp
                @endif
            } catch(error) {
                console.log(error);
            }
        },
        deselect() {
            @if(!$inline)
                {{ $field }} = null,
                item_title = constructTitle();
                item_subtitle = constructSubtitle();
                image_src = window.WE.IMG.placeholderUrl();

                @php
                    echo $customDeselectLogic;
                @endphp

                this.reset();
                show = false;
            @else
                @php
                    echo $customDeselectLogic;
                @endphp
            @endif
        }
    }" x-init="$watch('q', query_string => search())">
        <div class="w-full pb-3 mb-3">
            <div class="relative mt-1 flex items-center">
                <input type="text"class="form-standard pr-12" x-model.debounce.700ms="q">
                <div class="absolute inset-y-0 right-0 flex py-1.5 pr-1.5" >
                    <kbd class="inline-flex items-center rounded border border-gray-200 px-2 font-sans text-sm font-medium text-gray-400 cursor-pointer"
                        @click="search()">
                        {{ translate('Search') }}
                    </kbd>
                </div>
            </div>
        </div>

        <template x-if="results.length > 0">
            <div class="w-full mt-3">
                <ul role="list" class="-my-5 divide-y divide-gray-200">
                    <template x-for="item in results">
                        <li class="py-4">
                            <div class="flex items-center space-x-4">
                                <div class="flex-shrink-0">
                                    <img loading="lazy" class="h-8 w-8 rounded-full" :src="window.WE.IMG.url(item.thumbnail?.file_name)" alt="">
                                </div>
                                <div class="min-w-0 flex-1">
                                <p class="truncate text-sm font-medium text-gray-900" x-text="constructTitle(item)"></p>
                                <p class="truncate text-sm text-gray-500" x-text="constructSubtitle(item)"></p>
                                </div>
                                <div>
                                    <div @click="select(item); reset(); show = false;" class="cursor-pointer inline-flex items-center rounded-full border border-gray-300 bg-white px-2.5 py-0.5 text-sm font-medium leading-5 text-gray-700 shadow-sm hover:bg-gray-50">
                                        {{ translate('Select') }}
                                    </div>
                                </div>
                            </div>
                        </li>
                    </template>
                </ul>
            </div>
        </template>


        {{-- Empty state --}}
        <template x-if="results.length <= 0">
            <div class="text-center py-2">
                @svg('heroicon-o-magnifying-glass', ['class' => 'mx-auto h-12 w-12 text-gray-400'])
                <h3 class="mt-2 text-sm font-medium text-gray-900">{{ translate('Couldn\'t find any item') }}</h3>
                <p class="mt-1 text-sm text-gray-500">{{ translate('Please try searching by different query') }}</p>
            </div>
        </template>

        @if(!$hideReset)
            {{-- Reset and clear --}}
            <div class="w-full flex justify-end mt-3 pt-3 border-t border-gray-200">
                <button type="button" class="text-12 text-danger" @click="deselect()">
                    {{ translate('Reset and clear') }}
                </button>
            </div>
        @endif
    </div>

    @php
        $selector_html = ob_get_clean();
    @endphp

    @if(!$inline)
        {{-- Model Selection Modal --}}
        <x-system.form-modal id="{{ $modalId }}" title="{{ $modalTitle }}" class="!max-w-lg">
            @php
                echo $selector_html;
            @endphp
        </x-system.form-modal>
    @else
        @php
            echo $selector_html;
        @endphp
    @endif
</div>
