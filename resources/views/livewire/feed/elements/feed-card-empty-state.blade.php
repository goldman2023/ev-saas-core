<div @attributes class="mb-3 bg-white sm:rounded-lg w-full {{ $dynamic_class }}">
    <div class="animate-pulse flex space-x-4">
        <div class="rounded-full bg-slate-500 h-10 w-10"></div>
        <div class="flex-1 space-y-6 py-1">
            <div class="h-2 bg-slate-400 rounded"></div>
            <div class="space-y-3">
                <div class="grid grid-cols-3 gap-4">
                    <div class="h-2 bg-slate-300 rounded col-span-2"></div>
                    <div class="h-2 bg-slate-300 rounded col-span-1"></div>
                </div>
                <div class="h-2 bg-slate-400 rounded"></div>
            </div>
        </div>
    </div>
</div>
