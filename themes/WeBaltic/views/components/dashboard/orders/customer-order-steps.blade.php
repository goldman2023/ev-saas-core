<div class="mb-6 md:sticky top-[65px] z-[1000]">
    <nav class="w-full" aria-label="Progress">
      <ol role="list" class="overflow-hidden rounded-lg lg:flex lg:rounded-xl lg:border lg:border-gray-300">
        @foreach($steps as $key => $step)
            @if($key < $order_cycle_status)
                <li class="relative overflow-hidden lg:flex-1 bg-white">
                    <div class="border border-gray-200 overflow-hidden border-b-0 rounded-t-md lg:border-0">
                        <!-- Completed Step -->
                        <div class="group">
                            <span class="absolute top-0 left-0 h-full w-1 bg-transparent group-hover:bg-gray-200 lg:bottom-0 lg:top-auto lg:h-1 lg:w-full" aria-hidden="true"></span>
                            <span class="px-6 py-5 flex items-start text-sm font-medium">
                                <span class="flex-shrink-0">
                                    <span class="flex h-10 w-10 items-center justify-center rounded-full bg-indigo-600">
                                        @svg('heroicon-s-check', ['class' => 'h-6 w-6 text-white'])
                                    </span>
                                </span>
                                <span class="mt-0.5 ml-4 flex min-w-0 flex-col">
                                    <span class="text-sm font-medium">{{ $step }}</span>
                                    <span class="text-sm text-12 text-gray-500">{{ $steps_description[$key] ?? '' }}</span>
                                </span>
                            </span>
                        </div>

                        @if($key !== 0)
                            <!-- Separator -->
                            <div class="absolute inset-0 top-0 left-0 hidden w-3 lg:block" aria-hidden="true">
                                <svg class="h-full w-full text-gray-300" viewBox="0 0 12 82" fill="none" preserveAspectRatio="none">
                                <path d="M0.5 0V31L10.5 41L0.5 51V82" stroke="currentcolor" vector-effect="non-scaling-stroke" />
                                </svg>
                            </div>
                        @endif
                    </div>
                </li>
            @elseif($key == $order_cycle_status)
                <li class="relative overflow-hidden lg:flex-1 bg-white">
                    <div class="border border-gray-200 overflow-hidden lg:border-0">
                        <!-- Current Step -->
                        <div aria-current="step">
                            <span class="absolute top-0 left-0 h-full w-1 bg-indigo-600 lg:bottom-0 lg:top-auto lg:h-1 lg:w-full" aria-hidden="true"></span>
                            <span class="px-6 py-5 flex items-start text-sm font-medium lg:pl-9">
                                <span class="flex-shrink-0">
                                    <span class="flex h-10 w-10 items-center justify-center rounded-full border-2 border-indigo-600">
                                        @svg('heroicon-s-check', ['class' => 'h-6 w-6 text-primary'])
                                    </span>
                                </span>
                                <span class="mt-0.5 ml-4 flex min-w-0 flex-col">
                                    <span class="text-sm font-medium text-indigo-600">{{ $step }}</span>
                                    <span class="text-sm text-12 text-gray-500">{{ $steps_description[$key] ?? '' }}</span>
                                </span>
                            </span>
                        </div>
                
                        <!-- Separator -->
                        <div class="absolute inset-0 top-0 left-0 hidden w-3 lg:block" aria-hidden="true">
                            <svg class="h-full w-full text-gray-300" viewBox="0 0 12 82" fill="none" preserveAspectRatio="none">
                            <path d="M0.5 0V31L10.5 41L0.5 51V82" stroke="currentcolor" vector-effect="non-scaling-stroke" />
                            </svg>
                        </div>
                    </div>
                </li>
            @elseif($key > $order_cycle_status)
                <li class="relative overflow-hidden lg:flex-1 bg-white">
                    <div class="border border-gray-200 overflow-hidden border-t-0 rounded-b-md lg:border-0">
                        <!-- Upcoming Step -->
                        <div class="group">
                            <span class="absolute top-0 left-0 h-full w-1 bg-transparent group-hover:bg-gray-200 lg:bottom-0 lg:top-auto lg:h-1 lg:w-full" aria-hidden="true"></span>
                            <span class="px-6 py-5 flex items-start text-sm font-medium lg:pl-9">
                                <span class="flex-shrink-0">
                                    <span class="flex h-10 w-10 items-center justify-center rounded-full border-2 border-gray-300">
                                        @svg('heroicon-s-check', ['class' => 'h-6 w-6 text-gray-400'])
                                    </span>
                                </span>
                                <span class="mt-0.5 ml-4 flex min-w-0 flex-col">
                                    <span class="text-sm font-medium text-gray-500">{{ $step }}</span>
                                    <span class="text-sm text-12 text-gray-500">{{ $steps_description[$key] ?? '' }}</span>
                                </span>
                            </span>
                        </div>
                
                        <!-- Separator -->
                        <div class="absolute inset-0 top-0 left-0 hidden w-3 lg:block" aria-hidden="true">
                            <svg class="h-full w-full text-gray-300" viewBox="0 0 12 82" fill="none" preserveAspectRatio="none">
                            <path d="M0.5 0V31L10.5 41L0.5 51V82" stroke="currentcolor" vector-effect="non-scaling-stroke" />
                            </svg>
                        </div>
                    </div>
                </li>
            @endif
        @endforeach
        
      </ol>
    </nav>
</div>
