<div class="mt-8">
    <h3 class="text-lg font-medium text-gray-900">Change fallback subdomain</h3>
    <div class="shadow overflow-hidden sm:rounded-md mt-2">
        <div class="px-4 py-5 bg-white sm:p-6">
            <div>
                <label for="fallback_domain" class="block text-sm font-medium leading-5 text-gray-700">Domain
                </label>
                <div class="mt-1 flex rounded-md shadow-sm">
                    <input id="fallback_domain" wire:model="domain" class="form-input flex-1 block w-full rounded-none rounded-l-md transition duration-150 ease-in-out sm:text-sm sm:leading-5" />
                    <span class="flex items-center px-3 rounded-r-md border-t border-b border-r border-gray-300 bg-gray-50 text-gray-500 text-sm">
                        <span>
                            .{{ config('tenancy.central_domains')[0] }}
                        </span>
                    </span>
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