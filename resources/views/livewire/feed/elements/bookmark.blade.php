<div>
    <form wire:submit.prevent="storeBookmark" class="pb-10 border-b-2">
        <div>
            <label class="block text-sm font-medium text-gray-700" for="title">
                Link
                <input wire:model.debounce.500ms="link" type="text" placeholder="https://"
                       class="py-2 pr-4 pl-2 mt-2 w-full text-sm rounded-lg border border-gray-400 sm:text-base focus:outline-none focus:border-blue-400"/>
            </label>
            @error('link') <span class="mt-4 text-sm text-red-500">{{ $message }}</span> @enderror
        </div>



        @if ($description)
            <p class="block mt-4 text-sm font-medium text-gray-700">Description</p>
            <p class="mt-2">{{ $description }}</p>
        @endif

        @if($image)
            <img src="{{ $image }}" alt="{{ $title }}" class="object-contain mt-4 w-full max-h-64">
        @endif

        <span wire:loading="updatedLink" class="mt-2 text-indigo-500">Fetching data...</span>

        @if($message)
            <span class="mt-4 text-red-500">{{ $message }}</span>
        @endif

        <div class="flex items-center mt-4">

        </div>
    </form>



</div>
