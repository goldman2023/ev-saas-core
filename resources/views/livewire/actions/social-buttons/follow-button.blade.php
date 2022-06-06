<div wire:click="fireSocialAction()">
    @if($added)
        <button type="button"
            class="inline-flex items-center px-3 py-0.5 rounded-full bg-indigo-50 text-sm font-medium text-indigo-700 hover:bg-indigo-100 {{ $class }}">
            {{ svg($action['icon_success'], ['class'=> 'h-5 w-5 text-indigo-400 max-w-[16px] mr-2']) }}

            <span>
                {{ !empty($action_text_success) ? $action_text_success : $action['action_success'] }}
            </span>
        </button>
    @else
        <button type="button"
            class="inline-flex items-center px-3 py-0.5 rounded-full bg-indigo-600 text-sm font-medium text-white hover:bg-indigo-300 {{ $class }}">
            {{ svg($action['icon'], ['class'=> 'max-w-[16px] text-indigo-100 mr-3 -ml-1 mr-0.5 h-5 w-5']) }}
            <span>
                {{ !empty($action_text) ? $action_text : $action['action'] }}
            </span>
        </button>
    @endif
</div>
