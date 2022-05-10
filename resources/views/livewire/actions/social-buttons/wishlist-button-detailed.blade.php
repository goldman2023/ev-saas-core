<div wire:click="fireSocialAction()">
    <button class="w-full mt-4 flex items-center">
        @if($added)
            {{ svg($action['icon_success'], ['class'=> 'text-danger w-5 h-5']) }}
            <span class="ml-3 leading-none block mt-1">
                {{ $action['action_success'] }}
            </span>
        @else
            {{ svg($action['icon'], ['class'=> 'w-5 h-5']) }}
            <span class="ml-3 leading-none block mt-1 font-semibold">
                {{ $action['action'] }}
            </span>
        @endif
    </button>
</div>