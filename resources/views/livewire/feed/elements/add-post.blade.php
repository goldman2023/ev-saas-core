<div class="bg-gray-50 px-4 py-6 sm:px-6">
    <div class="flex space-x-3">
        <div class="flex-shrink-0">
            <img class="h-10 w-10 rounded-full"
                src="{{ auth()->user()->getThumbnail() }}"
                alt="">
        </div>
        <div class="min-w-0 flex-1">
                <div>
                    <label for="content" class="sr-only">About</label>
                    <textarea id="content" name="content" rows="3"
                        wire:model="content"
                        class="shadow-sm block w-full focus:ring-blue-500 focus:border-blue-500 sm:text-sm border border-gray-300 rounded-md"
                        placeholder="{{ translate('What\'s on your mind?') }}"></textarea>
                </div>
                <div class="mt-3 flex items-center justify-between">
                    <a href="#"
                        class="group inline-flex items-start text-sm space-x-2 text-gray-500 hover:text-gray-900">
                        <svg class="flex-shrink-0 h-5 w-5 text-gray-400 group-hover:text-gray-500"
                            x-description="Heroicon name: solid/question-mark-circle"
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                            fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd"
                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <span>
                            {{ translate('Post will be visible publicly') }}
                        </span>
                    </a>
                    <button
                    wire:click="addFeedPost"
                    type="submit"
                        class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        {{ translate('Add a post') }}
                    </button>
                </div>
        </div>
    </div>
</div>
