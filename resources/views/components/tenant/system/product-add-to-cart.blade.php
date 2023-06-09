<div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-4 sm:grid-cols-12 items-center">
{{--    TODO: Make these button actually function with some cart js stuff , this inline js comes from legacy version --}}
    <div class="col-span-2">
        <label for="quantity" class="sr-only">Quantity</label>
        <select name="quantity" class="rounded-md border border-gray-300 text-base font-medium text-gray-700 text-left shadow-sm focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                x-model="quantity">
            @for($i=1;$i<=30;$i++)
                <option value="{{$i}}">{{$i}}</option>
            @endfor
        </select>
    </div>

    <button type="button"
            class="col-span-5 bg-indigo-600 border border-transparent rounded-md py-3 px-8 flex items-center justify-center text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-50 focus:ring-indigo-500">
        {{ translate('Buy Now')}}
    </button>
    <button type="button"
            @click="$dispatch('add-to-cart', {id:id,quantity:quantity,colors:colors})"
            class="col-span-5 bg-indigo-50 border border-transparent rounded-md py-3 px-8 flex items-center justify-center text-base font-medium text-indigo-700 hover:bg-indigo-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-50 focus:ring-indigo-500">
        {{ translate('Add to cart')}}
    </button>
</div>
