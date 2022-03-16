@props(['title' => translate('Advanced options'), 'class', 'contentClass'])
<div class="w-full {{ $class }}" x-data="{
    advanced_options_show: false,
}">

    <div class="relative">
        <div class="absolute inset-0 flex items-center" aria-hidden="true">
            <div class="w-full border-t border-gray-300"></div>
        </div>
        <div class="relative flex justify-center">
            <p class="inline-flex items-center cursor-pointer px-3 py-1 border border-gray-300 rounded-full bg-gray-50 text-gray-700" x-on:click="advanced_options_show = !advanced_options_show">
                <span class="mr-2">{{ $title }}</span>
                @svg('heroicon-o-chevron-down', ['class' => 'h-4 h-5', ':class=\'{"rotate-180":advanced_options_show}\''])
            </p>
        </div>
    </div>

    
    <div class="w-full py-2 {{ $contentClass }}" 
            x-show="advanced_options_show">
        {!! $slot !!}
    </div>
</div>