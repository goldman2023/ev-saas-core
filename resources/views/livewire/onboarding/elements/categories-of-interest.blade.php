<div class="flow-root h-full mt-0 md:mt-6">
    <h4 class="text-lg font-medium text-gray-900 mb-5">{{ translate('I\'m interested in') }}:</h4>
    <div class="w-full h-[90%] relative overflow-y-auto">
        <ul role="list" class="absolute w-full h-full top-0 -my-5 divide-y divide-gray-200 pr-3">
            @if(\Categories::getAll()->isNotEmpty())
                @foreach(\Categories::getAll() as $category)
                    <li class="py-4">
                        <div class="flex items-center space-x-4">
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 truncate">{{ $category->name }}</p>
                                <p class="text-12 text-gray-500 truncate">{{ '@'.$category->slug }}</p>
                            </div>
                            <div class="flex items-center">
                                <button type="button" wire:click="followCategory({{ $category->id }})" class="inline-flex border-circle border-gray-200 items-center">
                                    @if(in_array($category->id, $followed_categories_ids))
                                        @svg('heroicon-s-check-circle', ['class' => 'h-6 w-6 text-success'])
                                    @else
                                        @svg('heroicon-o-check-circle', ['class' => 'h-6 w-6 text-gray-300'])
                                    @endif
                                </button>
                                {{-- <a href="#" class="inline-flex items-center shadow-sm px-2.5 py-0.5 border border-gray-300 text-sm leading-5 font-medium rounded-full text-gray-700 bg-white hover:bg-gray-50"> View </a> --}}
                            </div>
                        </div>
                    </li>
                @endforeach
            @endif
        </ul>
    </div>
</div>