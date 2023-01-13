<div class="mb-4 border-b border-gray-200 dark:border-gray-700" 
    wire:key="{{ $tabsId }}-tab-header-wrapper"  
    wire:ignore.self
>
    <ul class="flex overflow-x-auto sm:flex-wrap -mb-px text-sm font-medium text-center" 
        id="{{ $tabsId }}-tab-header" data-tabs-toggle="#{{ $tabsId }}-tab" role="tablist"  
        wire:key="{{ $tabsId }}-tab-header"  
        wire:ignore.self
    >

        @foreach($enum::values() as $key => $status)
            <li class="mr-2" role="presentation" wire:ignore.self>
                <button
                    wire:ignore.self
                    wire:key="{{ $tabsId }}-nav-{{ $key }}"

                    class="inline-block p-4 rounded-t-lg border-b-2 text-blue-600 hover:text-blue-600 dark:text-blue-500 dark:hover:text-blue-500 border-blue-600 dark:border-blue-500"
                    id="{{ $tabsId }}-nav-{{ $key }}" data-tabs-target="#{{ $tabsId }}-tab-{{ $key }}" type="button" role="tab"
                    aria-controls="{{ $tabsId }}-nav-{{ $status }}" @if($key==0) aria-selected="true" @endif>
                        <span>{{ $enum::labels()[$key] ?? '?' }}</span>
                        @if($isWef)
                            ({{ $model::whereWEF($property, $key)->count() }})
                        @else
                            ({{ $model::where($property, $key)->count() }})
                        @endif
                </button>
            </li>
        @endforeach
    </ul>
</div>