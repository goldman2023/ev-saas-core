<div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-4 sm:grid-cols-2">
{{--    TODO: Make these button actually function with some cart js stuff , this inline js comes from legacy version --}}
    <button type="button"
            onclick="buyNow()"
            class="w-full bg-indigo-600 border border-transparent rounded-md py-3 px-8 flex items-center justify-center text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-50 focus:ring-indigo-500">
        {{ translate('Buy Now')}}
    </button>
    <button type="button"
            onclick="addToCart()"
            class="w-full bg-indigo-50 border border-transparent rounded-md py-3 px-8 flex items-center justify-center text-base font-medium text-indigo-700 hover:bg-indigo-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-50 focus:ring-indigo-500">
        {{ translate('Add to cart')}}
    </button>
</div>
