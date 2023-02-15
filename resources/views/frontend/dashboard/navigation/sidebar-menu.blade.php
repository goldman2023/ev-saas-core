{{-- Dashboard Sidebar Navigation --}}
<nav class="px-3 mt-6 pb-5">
    <div class="space-y-1 mb-6">
        @if($menu = \WE::getDashboardMenu())
            @foreach($menu as $section)
                @if($section['label'] === 'hr')
                    <div class="w-full border-t border-gray-300"></div>
                @else
                    <h6 class="text-14 font-semibold text-gray-900">{{ $section['label'] }}</h6>
                @endif

                @if(!empty($section['items']))
                    <div class="flex-1 px-2 space-y-1">

                        @foreach($section['items'] as $key => $item)
                            @if(!empty($item['children'] ?? false))
                                <div class="space-y-1 {{ $item['is_active'] }}" x-data="{
                                        expanded:  @if($item['is_active']) true @else false @endif,
                                    }">
                                    <!-- Current: "bg-gray-100 text-gray-900", Default: "bg-white text-gray-600 hover:bg-gray-50 hover:text-gray-900" -->
                                    <button type="button"
                                        class="@if($item['is_active']) bg-gray-200 rounded @endif text-gray-700 hover:text-gray-900 group w-full flex items-center pl-2 pr-1 py-2 text-left text-sm font-medium rounded-md focus:outline-none focus:ring-2 focus:ring-primary"
                                        @click="expanded = !expanded">
                                            @svg($item['icon'], ['class' => 'mr-3 flex-shrink-0 h-6 w-6'])

                                            <span class="flex-1">{{ $item['label'] }}</span>

                                        <!-- Expanded: "text-gray-400 rotate-90", Collapsed: "text-gray-300" -->
                                        <svg class=" ml-3 flex-shrink-0 h-5 w-5 transform transition-colors ease-in-out duration-150"
                                            :class="{'rotate-90 text-gray-400':expanded}">
                                            <path d="M6 6L14 10L6 14V6Z" fill="currentColor" />
                                        </svg>
                                    </button>
                                    <!-- Expandable link section, show/hide based on state. -->
                                    <div class="space-y-1" x-cloak x-show="expanded">
                                        @foreach($item['children'] as $child)
                                            <a href="{{ $child['route'] }}"
                                                class="@if($child['is_active']) bg-gray-200 rounded @endif text-gray-700 group w-full flex items-center pl-7 pr-2 py-2 text-sm font-medium rounded-md hover:text-gray-900">
                                                @svg($child['icon'], ['class' => 'mr-2 flex-shrink-0 h-6 w-6 '])
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
                            {{-- TODO: create a propper active class name for identfying  --}}
                            <div class="{{ $key > 0 ? 'space-y-1':'' }} {{ $item['is_active'] }} @if($item['is_active']) bg-gray-200 rounded @endif" >
                                <a href="{{ $item['route'] }}" class="@if($item['is_active']) text-black rounded @else text-gray-700 @endif hover:text-gray-900 group w-full flex items-center pl-2 py-2 text-sm font-medium rounded-md">

                                    @svg($item['icon'], ['class' => 'mr-3 flex-shrink-0 h-6 w-6 '])

                                    <span class="flex-1">{{ $item['label'] }}</span>

                                    @if(($item['badge'] ?? null) && $item['badge']['content'] instanceof \Closure && $count = $item['badge']['content']() ?? null)
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
{{-- END Dashboard Sidebar Navigation --}}
