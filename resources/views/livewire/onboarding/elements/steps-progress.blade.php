<div>
    <!-- This example requires Tailwind CSS v2.0+ -->
    <div class="p-3 md:p-0">
        <h4 class="sr-only">Status</h4>
        <p class="text-sm font-medium text-gray-900">{{ translate('Setup your profile') }}...</p>
        <div class="mt-3" aria-hidden="true">
            <div class="bg-gray-200 rounded-full overflow-hidden">
                <div class="h-2 bg-indigo-400 rounded-full" style="width: {{ $progress_percentage }}%"></div>
            </div>
            <div class="hidden sm:grid @if($include_work_and_education) grid-cols-3 @else grid-cols-2 @endif text-sm font-medium text-gray-600 mt-3">
                <div class="text-indigo">
                    <a href="{{ route('onboarding.step2') }}">
                        {{ translate('Profile information') }}
                    </a>
                </div>

                @if($include_work_and_education) 
                    <div class="text-center text-indigo">
                        <a href="{{ route('onboarding.work-and-education') }}">
                            {{ translate('Work and Education') }}
                        </a>
                    </div>
                @endif
                
                {{-- <div class="text-center">
                    {{ translate('Store Setup') }}
                </div> --}}
                <div class="text-right">{{ translate('Done!') }}</div>
            </div>
        </div>
    </div>

</div>
