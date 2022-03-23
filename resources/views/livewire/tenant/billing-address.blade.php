<div class="mt-8">
    <h3 class="text-lg font-medium text-gray-900">Billing address</h3>
    <div class="mt-2 shadow overflow-hidden sm:rounded-md">
        <div class="px-4 py-5 bg-white sm:p-6 flex flex-row flex-wrap">
            <div class="w-1/2 p-2">
                <label for="line1" class="block text-sm font-medium leading-5 text-gray-700">Line 1
                </label>
                <div class="mt-1 relative rounded-md shadow-sm">
                    <input id="line1" wire:model="line1" type="text" class="form-input block w-full sm:text-sm sm:leading-5" placeholder="123 Laravel Street">
                </div>
                @error('line1')
                <p class="text-sm mt-2 text-red-500">
                    {{ $message }}
                </p>
                @enderror
            </div>
            <div class="w-1/2 p-2">
                <label for="line2" class="block text-sm font-medium leading-5 text-gray-700">Line 2
                </label>
                <div class="mt-1 relative rounded-md shadow-sm">
                    <input id="line2" wire:model="line2" type="text" class="form-input block w-full sm:text-sm sm:leading-5" placeholder="Apartment B">
                </div>
                @error('line2')
                <p class="text-sm mt-2 text-red-500">
                    {{ $message }}
                </p>
                @enderror
            </div>
            <div class="mt-4 w-1/2 p-2">
                <label for="city" class="block text-sm font-medium leading-5 text-gray-700">City
                </label>
                <div class="mt-1 relative rounded-md shadow-sm">
                    <input id="city" wire:model="city" type="text" class="form-input block w-full sm:text-sm sm:leading-5" placeholder="San Francisco">
                </div>
                @error('city')
                <p class="text-sm mt-2 text-red-500">
                    {{ $message }}
                </p>
                @enderror
            </div>
            <div class="mt-4 w-1/2 p-2">
                <label for="postal_code" class="block text-sm font-medium leading-5 text-gray-700">Postal code
                </label>
                <div class="mt-1 relative rounded-md shadow-sm">
                    <input id="postal_code" wire:model="postal_code" type="text" class="form-input block w-full sm:text-sm sm:leading-5" placeholder="12345">
                </div>
                @error('postal_code')
                <p class="text-sm mt-2 text-red-500">
                    {{ $message }}
                </p>
                @enderror
            </div>
            <div class="mt-4 w-1/2 p-2">
                <label for="country" class="block text-sm font-medium leading-5 text-gray-700">Country
                </label>
                <div class="mt-1 relative rounded-md shadow-sm">
                    <select id="country" wire:model="country" type="text" class="form-select block w-full sm:text-sm sm:leading-5">
                        @include('partials.countries')
                    </select>
                </div>
                @error('country')
                <p class="text-sm mt-2 text-red-500">
                    {{ $message }}
                </p>
                @enderror
            </div>
            <div class="mt-4 w-1/2 p-2">
                <label for="state" class="block text-sm font-medium leading-5 text-gray-700">State
                </label>
                <div class="mt-1 relative rounded-md shadow-sm">
                    <input id="state" wire:model="state" type="text" class="form-input block w-full sm:text-sm sm:leading-5" placeholder="California">
                </div>
                @error('state')
                <p class="text-sm mt-2 text-red-500">
                    {{ $message }}
                </p>
                @enderror
            </div>
            @if($success)
            <p class="text-sm mt-4 text-green-500">
                {{ $success }}
            </p>
            @endif
        </div>
        <div class="px-4 sm:px-6 py-2 bg-gray-50 flex justify-end">
            <button wire:click="save" class="py-1 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 shadow-sm hover:bg-indigo-500 focus:outline-none focus:shadow-outline-blue focus:bg-indigo-500 active:bg-indigo-600 transition duration-150 ease-in-out">
                Save billing address
            </button>
        </div>
    </div>
</div>