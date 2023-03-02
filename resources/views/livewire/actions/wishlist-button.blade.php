<div
wire:loading.class="opacity-30 pointer-events-none"
    class="relative w-full block items-center text-sm text-gray-700 font-medium border border-transparent rounded-br-lg hover:text-gray-500">

    <div wire:click="fireSocialAction()">

        <button
            class="relative w-auto whitespace-nowrap flex-1 inline-flex items-center justify-center py-4 text-sm text-gray-700 font-medium border border-transparent rounded-br-lg hover:text-gray-500">
            @if($added)
            {{ $action['action_success'] }}

            {{ svg($action['icon_success'], ['class'=> 'w-8 h-8']) }}

            @else
            {{ $action['action'] }}

            {{ svg($action['icon'], ['class'=> 'w-8 text-gray-900 mr-2']) }}

            @endif
        </button>



    </div>

    @if($selectedAction == 'Notify' && $added)
    @auth
    <div class="w-full text-sm font-normal flex">
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
