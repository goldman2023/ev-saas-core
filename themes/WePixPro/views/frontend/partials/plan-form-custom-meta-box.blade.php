<div class="p-4 border bg-white border-gray-200 rounded-lg shadow mt-5" x-show="!non_standard">
    <div>
        <h3 class="text-lg leading-6 font-medium text-gray-900">{{ translate('Plan default features') }}</h3>
        <p class="mt-1 max-w-2xl text-sm text-gray-500">{{ translate('Here, you can define features users will have access to by default, when subscription is purchased') }}</p>
    </div>

    <div class="mt-6 sm:mt-5 space-y-6 sm:space-y-5">
        <!-- Number of images -->
        <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5" >
        
            <label for="plan-title" class="flex flex-col text-sm font-medium text-gray-700 ">
                <span class="">{{ translate('Number of images') }}</span>
                <p class="text-12 text-gray-500">{{ translate('Default number of images users can process by purchasing this plan') }}</p>
            </label>

            <div class="mt-1 sm:mt-0 sm:col-span-2">
                <x-dashboard.form.input type="number" field="model_core_meta.number_of_images" />
            </div>
        </div>
        <!-- END Number of images -->

        <!-- Includes offline processing -->
        <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5" >
        
            <label for="plan-title" class="flex flex-col text-sm font-medium text-gray-700 ">
                <span class="">{{ translate('Includes offline processing') }}</span>
                <p class="text-12 text-gray-500">{{ translate('Does it include offline processing?') }}</p>
            </label>

            <div class="mt-1 sm:mt-0 sm:col-span-2">
                <x-dashboard.form.toggle field="model_core_meta.includes_offline" />
            </div>
        </div>
        <!-- END Includes offline processing -->

        <!-- Includes cloud processing -->
        <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
        
            <label for="plan-title" class="flex flex-col text-sm font-medium text-gray-700 ">
                <span class="">{{ translate('Includes cloud processing') }}</span>
                <p class="text-12 text-gray-500">{{ translate('Does it include cloud processing?') }}</p>
            </label>

            <div class="mt-1 sm:mt-0 sm:col-span-2">
                <x-dashboard.form.toggle field="model_core_meta.includes_cloud" />
            </div>
        </div>
        <!-- END Includes cloud processing -->
    </div>
</div>