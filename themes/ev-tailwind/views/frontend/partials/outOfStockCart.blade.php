<div class="modal-body p-4 added-to-cart">
    <div class="text-center text-danger">
        <h2>{{translate('oops..')}}</h2>
        <h3>{{translate('This item is out of stock!')}}</h3>
    </div>
    <div class="text-center mt-5">
        <button class="btn btn-outline-primary" data-dismiss="modal">{{translate('Back to shopping')}}</button>
    </div>
</div>

<!-- This example requires Tailwind CSS v2.0+ -->
<div class="rounded-md bg-red-50 p-4 {{ $class ?? '' }}">
    <div class="flex">
        <div class="flex-shrink-0">
            <!-- Heroicon name: solid/x-circle -->
            <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
            </svg>
        </div>
        <div class="ml-3">
            <h3 class="text-sm font-medium text-red-800">
                {{ translate('oops..') }}
            </h3>
            <div class="mt-2 text-sm text-red-700">
                <p>{{translate('This item is out of stock!')}}</p>
            </div>
        </div>
    </div>
</div>

