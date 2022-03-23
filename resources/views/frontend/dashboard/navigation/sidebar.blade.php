<!-- Navigation -->
<nav class="px-3 mt-6">
    {{-- <x-dashboard.elements.support-card></x-dashboard.elements.support-card> --}}
    <div class="space-y-1">
        @if($menu = \EVS::getDashboardMenu())
        @foreach($menu as $section)
        @if($section['label'] === 'hr')
        <div class="w-full border-t border-gray-300"></div>
        @else
        <h6 class="text-14 font-semibold gray-100">{{ $section['label'] }}</h6>
        @endif

        @if(!empty($section['items']))
        <div class="flex-1 px-2 space-y-1">

            @foreach($section['items'] as $key => $item)
            @if(!empty($item['children'] ?? false))
            <div class="space-y-1" x-data="{
                                        expanded: false,
                                    }">
                <!-- Current: "bg-gray-100 text-gray-900", Default: "bg-white text-gray-600 hover:bg-gray-50 hover:text-gray-900" -->
                <button type="button"
                    class="bg-white text-gray-600 hover:bg-gray-50 hover:text-gray-900 group w-full flex items-center pl-2 pr-1 py-2 text-left text-sm font-medium rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"
                    @click="expanded = !expanded">
                    @svg($item['icon'], ['class' => 'mr-3 flex-shrink-0 h-6 w-6 text-gray-400
                    group-hover:text-gray-500'])
                    <span class="flex-1">{{ $item['label'] }}</span>

                    <!-- Expanded: "text-gray-400 rotate-90", Collapsed: "text-gray-300" -->
                    <svg class="text-gray-300 ml-3 flex-shrink-0 h-5 w-5 transform group-hover:text-gray-400 transition-colors ease-in-out duration-150"
                        :class="{'rotate-90 text-gray-400':expanded}">
                        <path d="M6 6L14 10L6 14V6Z" fill="currentColor" />
                    </svg>
                </button>
                <!-- Expandable link section, show/hide based on state. -->
                <div class="space-y-1" x-show="expanded">
                    @foreach($item['children'] as $child)
                    <a href="{{ $child['route'] }}"
                        class="group w-full flex items-center pl-7 pr-2 py-2 text-sm font-medium text-gray-600 rounded-md hover:text-gray-900 hover:bg-gray-50">
                        @svg($child['icon'], ['class' => 'mr-2 flex-shrink-0 h-6 w-6 text-gray-400
                        group-hover:text-gray-500'])
                        <span class="flex-1">{{ $child['label'] }}</span>

                        @if(($child['badge'] ?? null) && $child['badge']['content'] instanceof \Closure && $count =
                        $child['badge']['content']() ?? null)
                        <span class="badge-danger {{ $child['badge']['class'] }} text-12 ml-2 rounded">
                            {{ $count }}
                        </span>
                        @endif
                    </a>
                    @endforeach
                </div>
            </div>
            @else
            <div class="{{ $key > 0 ? 'space-y-1':'' }}">
                <a href="{{ $item['route'] }}"
                    class=" text-gray-300 group w-full flex items-center pl-2 py-2 text-sm font-medium rounded-md">
                    @svg($item['icon'], ['class' => 'mr-3 flex-shrink-0 h-6 w-6 text-gray-400
                    group-hover:text-gray-500'])
                    <span class="flex-1">{{ $item['label'] }}</span>

                    @if(($item['badge'] ?? null) && $item['badge']['content'] instanceof \Closure && $count =
                    $item['badge']['content']() ?? null)
                    <span class="badge-danger {{ $item['badge']['class'] }} text-12 ml-2 rounded">
                        {{ $count }}
                    </span>
                    @endif
                </a>
            </div>
            @endif

            {{-- <li class="nav-item">
                <a class="nav-link {{ $item['is_active'] }}" href="{{ $item['route'] }}">
                    @svg($item['icon'], ['class' => 'nav-icon'])
                    {{ $item['label'] }}

                    @if(($item['badge'] ?? null) && $item['badge']['content'] instanceof \Closure && $count =
                    $item['badge']['content']() ?? null)
                    <span class="badge {{ $item['badge']['class'] }} text-12 ml-2 rounded">
                        {{ $count }}
                    </span>
                    @endif
                </a>
                @if(!empty($item['children'] ?? false))
                <ul class="nav nav-sub nav-sm nav-tabs nav-list-y-2 pl-3">
                    @foreach($item['children'] as $child)
                    <li class="nav-item">
                        <a class="nav-link {{ $child['is_active'] }}" href="{{ $child['route'] }}">
                            @svg($child['icon'], ['class' => 'nav-icon'])
                            {{ $child['label'] }}

                            @if(($child['badge'] ?? null) && $child['badge']['content'] instanceof \Closure && $count =
                            $child['badge']['content']() ?? null)
                            <span class="badge {{ $child['badge']['class'] }} text-12 ml-2 rounded">
                                {{ $count }}
                            </span>
                            @endif
                        </a>
                    </li>
                    @endforeach
                </ul>
                @endif
            </li> --}}
            @endforeach
        </div>
        @endif
        @endforeach
        @endif
    </div>

</nav>
