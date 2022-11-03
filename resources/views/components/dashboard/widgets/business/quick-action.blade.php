<div>
    <div
        class="relative rounded-lg border border-gray-300 bg-white p-3 shadow-sm flex items-center space-x-3 hover:border-gray-400 focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
        <div class="flex-shrink-0 bg-indigo-500 p-2 rounded">
            @svg('heroicon-o-' . $icon, ['class' => 'text-white font-regular h-6 w-6'])
        </div>
        <div class="flex-1 min-w-0">
            <a href="{{ route($route) }}" class="focus:outline-none">
                <span class="absolute inset-0" aria-hidden="true"></span>
                <p class="text-sm font-medium text-gray-900">{{ $title }}</p>
                <p class="text-sm text-gray-500 truncate">
                    {{ $description }}
                </p>
            </a>
        </div>
    </div>

</div>
