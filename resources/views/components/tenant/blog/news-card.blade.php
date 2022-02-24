<div class="flex flex-col rounded-lg shadow-lg overflow-hidden">
    <div class="flex-shrink-0">

        <x-tenant.system.image class="h-48 w-full object-cover" :image="$item->banner"></x-tenant.system.image>
    </div>
    <div class="flex-1 bg-white p-6 flex flex-col justify-between">
        <div class="flex-1">
            <p class="text-sm font-medium text-indigo-600">
                <a href="#" class="hover:underline">
                    {{ $item->category->name }}
                </a>
            </p>
            <a href="{{ route('news.details', $item->slug) }}" class="block mt-2">
                <p class="text-xl font-semibold text-gray-900">
                    {{ $item->title }}
                </p>
                <p class="mt-3 text-base text-gray-500">
                    {{ $item->short_description }}
                </p>
            </a>
        </div>
        <div class="mt-6 flex items-center">
            <div class="flex-shrink-0">
                <a href="#">
                    <span class="sr-only">Brenna Goyette</span>
                    <!--  TODO: Make this dynamic -->
                    <img class="h-10 w-10 rounded-full"
                        src="https://images.unsplash.com/photo-1550525811-e5869dd03032?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                        alt="">
                </a>
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium text-gray-900">
                    @if ($item->user != null)
                    <a href="#" class="hover:underline">
                        {{ $item->user->name }}
                    </a>
                    @endif
                </p>
                <div class="flex space-x-1 text-sm text-gray-500">
                    <time datetime="{{ $item->created_at }}">
                        {{ $item->created_at->diffForHumans() }}
                    </time>
                    <span aria-hidden="true">
                        &middot;
                    </span>

                    <span>
                        {{$item->estimated_time ." " . translate('min. Read')}}

                    </span>


                    <span>
                        {{-- TODO: Add views --}}
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
