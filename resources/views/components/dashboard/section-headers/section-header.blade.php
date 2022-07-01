<div class="p-5 mb-5 border bg-white border-gray-200 gap-6 rounded-lg sm:flex sm:items-center sm:justify-between">
    <div class="mb-3 sm:mb-0">
        <h3 class="text-24 leading-6 font-semibold text-gray-900">{{ $title }}</h3>
        @if(!empty($text))
            <p class="mt-2 max-w-2xl text-sm text-gray-500">{!! $text !!}</p>
        @endif
    </div>
    <div class="flex sm:mt-0 sm:ml-4">
        {{ $content }}
    </div>
</div>
