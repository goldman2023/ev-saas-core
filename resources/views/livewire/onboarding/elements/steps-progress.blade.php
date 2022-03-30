<div>
    <!-- This example requires Tailwind CSS v2.0+ -->
    <div>
        <h4 class="sr-only">Status</h4>
        <p class="text-sm font-medium text-gray-900">{{ translate('Setup your profile') }}...</p>
        <div class="mt-3" aria-hidden="true">
            <div class="bg-gray-200 rounded-full overflow-hidden">
                <div class="h-2 bg-indigo-600 rounded-full" style="width: {{ $progress_percentage }}%"></div>
            </div>
            <div class="hidden sm:grid grid-cols-4 text-sm font-medium text-gray-600 mt-3">
                <div class="text-indigo-600">
                    <a href="{{ route('onboarding.step1') }}">
                        {{ translate('Select your interests') }}
                    </a>
                </div>
                <div class="text-center text-indigo-600">
                    <a href="{{ route('onboarding.step2') }}">
                        {{ translate('Profile information') }}
                    </a>
                </div>
                <div class="text-center">
                    {{ translate('Store Setup') }}
                </div>
                <div class="text-right">{{ translate('Done!') }}</div>
            </div>
        </div>
    </div>

</div>
