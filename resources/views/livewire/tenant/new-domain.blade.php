<div class="mt-8">
    <h3 class="text-lg font-medium text-gray-900 px-3 md:px-0">Add a custom domain</h3>
    <div class="mt-2">
        <div class="shadow overflow-hidden sm:rounded-md">
            <div class="px-4 py-5 bg-white sm:p-6">
                <div>
                    <label for="domain" class="block text-sm font-medium leading-5 text-gray-700">Domain
                    </label>
                    <div class="mt-1 relative rounded-md shadow-sm">
                        <input id="domain" autocomplete="off" wire:model="domain" value="" class="form-input block w-full sm:text-sm sm:leading-5" placeholder="mydomain.com" />
                    </div>
                </div>
                
                @error('domain')
                <p class="text-red-500 text-xs mt-4">
                    {{ $message }}
                </p>
                @enderror
            </div>
            <div class="px-4 sm:px-6 py-2 bg-gray-50 flex justify-end">
                <button type="button" wire:click="save" class="py-1 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 shadow-sm hover:bg-indigo-500 focus:outline-none focus:shadow-outline-blue focus:bg-indigo-500 active:bg-indigo-600 transition duration-150 ease-in-out">
                    Save
                </button>
            </div>
        </div>
    </div>
</div>