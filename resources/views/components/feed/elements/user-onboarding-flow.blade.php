<!-- This example requires Tailwind CSS v2.0+ -->
<div class="flow-root">

</div>


<!-- This example requires Tailwind CSS v2.0+ -->
<nav aria-label="Progress">
    <ol role="list" class="overflow-hidden">
        @foreach($steps as $step)
        <li class="relative pb-10">
            @if(!$loop->last)
            <div class="-ml-px absolute mt-0.5 top-4 left-4 w-0.5 h-full bg-indigo-600" aria-hidden="true"></div>
            @endif
            <!-- Complete Step -->
            <a href="{{ $step['route'] }}" class="relative flex items-start group">
                <span class="h-9 flex items-center">
                    @if($step['completed'])
                    <span
                        class="relative z-10 w-8 h-8 flex items-center justify-center bg-indigo-600 rounded-full group-hover:bg-indigo-800">
                        <!-- Heroicon name: solid/check -->

                        <svg class="w-5 h-5 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                            fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd"
                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                clip-rule="evenodd" />
                        </svg>
                    </span>
                    @else
                    <span
                        class="relative z-10 w-8 h-8 flex items-center justify-center bg-gray-600 rounded-full group-hover:bg-indigo-800">
                        <!-- Heroicon name: solid/check -->

                        <svg class="h-5 w-5 text-white" x-description="Heroicon name: solid/user" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                          </svg>
                    </span>
                    @endif

                </span>
                <span class="ml-4 min-w-0 flex flex-col">
                    <span class="text-xs font-semibold tracking-wide uppercase">
                        {{ $step['title'] }}
                    </span>
                    <span class="text-sm text-gray-500">
                       {{ $step['action']}}
                    </span>
                </span>
            </a>
        </li>
        @endforeach
    </ol>
</nav>
