<div wire:click="addToWishlist()" class="inline-flex items-center text-sm">
    @if($added)
    <button type="button" class="inline-flex space-x-2 text-gray-400 hover:text-gray-500 hover:bg-gray-300 p-1.5 rounded">
        <svg class="h-5 w-5 text-indigo-600" x-description="Heroicon name: solid/thumb-up" xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
            <path
                d="M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.43a2 2 0 001.106 1.79l.05.025A4 4 0 008.943 18h5.416a2 2 0 001.962-1.608l1.2-6A2 2 0 0015.56 8H12V4a2 2 0 00-2-2 1 1 0 00-1 1v.667a4 4 0 01-.8 2.4L6.8 7.933a4 4 0 00-.8 2.4z">
            </path>
        </svg>

        <span class="font-medium text-indigo-900"> {{ $action['action_success'] }} {{ $count }}</span>
        <span class="sr-only">likes</span>
    </button>

    @else

    <button type="button" class="inline-flex space-x-2 text-gray-400 hover:text-gray-500 hover:bg-gray-300 p-1.5 rounded">
        <svg class="h-5 w-5" x-description="Heroicon name: solid/thumb-up" xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
            <path
                d="M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.43a2 2 0 001.106 1.79l.05.025A4 4 0 008.943 18h5.416a2 2 0 001.962-1.608l1.2-6A2 2 0 0015.56 8H12V4a2 2 0 00-2-2 1 1 0 00-1 1v.667a4 4 0 01-.8 2.4L6.8 7.933a4 4 0 00-.8 2.4z">
            </path>
        </svg>

        <span class="font-medium text-gray-900"> {{ $action['action'] }} {{ $count }}</span>

        <span class="sr-only">likes</span>
    </button>



    @endif

</div>
