<div
    class="relative w-full block items-center text-sm text-gray-700 font-medium border border-transparent rounded-br-lg hover:text-gray-500">

    <div wire:click="addToWishlist()">

        <button
            class="relative w-auto whitespace-nowrap flex-1 inline-flex items-center justify-center py-4 text-sm text-gray-700 font-medium border border-transparent rounded-br-lg hover:text-gray-500">
            @if($added)
            {{ svg($action['icon_success'], ['class'=> 'w-5 h-5']) }}
            {{ $action['action_success'] }}

            @else
            {{ svg($action['icon'], ['class'=> 'w-5 text-gray-900 mr-2']) }}
            {{ $action['action'] }}

            @endif
        </button>



    </div>

    @if($selectedAction == 'Notify' && $added)
    @auth
    <div class="w-full text-sm font-normal block">
        {{ svg('heroicon-s-check', ['class'=> 'w-4 text-green-400 mr-2']) }} {{ translate('You will get an email notification once product is back in stock!') }}
    </div>
    @else
        <div class="w-full text-sm font-normal block">
            <a href="{{ route('user.registration') }}" class="w-full text-sm font-normal flex" target="_blank">
                {{ svg('heroicon-s-identification', ['class'=> 'w-6 text-red-400 mr-2']) }}

                {{ translate('Register and get notified via email') }}
            </a>
        </div>
    @endauth
    @endif

</div>
