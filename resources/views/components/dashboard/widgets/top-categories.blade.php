<x-dashboard.elements.card>
    <div class="bg-white px-4 py-5 shadow sm:rounded-lg sm:px-6">
        <x-slot name="cardHeader" class="font-bold mb-3">
            <div class="mb-3">
                {{translate('Your Categories') }}
            </div>
        </x-slot>

        <x-slot name="cardBody" class="flow-root mt-6">
            <ul role="list" class="-my-5 divide-y divide-gray-200">
                @foreach ($categories as $category)
                @if($category->products()->count() > 0)
                    <li class="py-4">
                        <div class="flex items-center space-x-4">
                            <div class="flex-shrink-0">
                                <img class="h-8 w-8 rounded-full"
                                    src="https://images.unsplash.com/photo-1519345182560-3f2917c472ef?ixlib=rb-1.2.1&amp;ixid=eyJhcHBfaWQiOjEyMDd9&amp;auto=format&amp;fit=facearea&amp;facepad=2&amp;w=256&amp;h=256&amp;q=80"
                                    alt="">
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 truncate">
                                    {{ $category->name }}
                                </p>
                                <p class="text-sm text-gray-500 truncate">
                                    321 Views / {{ $category->products()->count() }} {{ translate('Products') }}
                                </p>
                            </div>
                            <div>
                                <a href="{{ $category->getPermalink() }}" target="blank"
                                    class="inline-flex items-center shadow-sm px-2.5 py-0.5 border border-gray-300 text-sm leading-5 font-medium rounded-full text-gray-700 bg-white hover:bg-gray-50">
                                    {{ translate('View') }}
                                </a>
                            </div>
                        </div>
                    </li>
                @endif
                @endforeach
            </ul>
        </x-slot>


        <x-slot name="cardFooter">
            <a href="{{ route('categories.index') }}" type="button" class="btn btn-secondary">
                {{ translate('View all categories') }}
            </a>
        </x-slot>

    </div>
</x-dashboard.elements.card>
