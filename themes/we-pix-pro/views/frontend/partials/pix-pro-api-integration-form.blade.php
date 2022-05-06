{{-- PixPro API --}}
<li class="col-span-1 flex flex-col text-center bg-white rounded-lg shadow divide-y divide-gray-200 border border-gray-200">
    <div class="flex-1 flex flex-col p-8">
        <img class="mx-auto h-[32px]" src="https://images.we-saas.com/insecure/fill/0/0/ce/0/plain/https://ev-saas.fra1.digitaloceanspaces.com/uploads/200203e2-4466-464d-a2fe-df1bc05bc2fa/1649756663_Logo%20(6).svg@webp" loading="lazy">
        <h3 class="mt-6 text-gray-900 text-sm font-medium">{{ translate('PixPro API') }}</h3>
    </div>
    <div>
      <div class="-mt-px flex divide-x divide-gray-200">
        <div class="w-0 flex-1 flex">
          <div @click="$dispatch('display-modal', {'id': 'app-settings-pix_pro_api'})" class="cursor-pointer relative -mr-px w-0 flex-1 inline-flex items-center justify-center py-4 text-sm text-gray-700 font-medium border border-transparent rounded-bl-lg hover:text-gray-500">
            @svg('heroicon-o-pencil', ['class' => 'w-5 h-5'])
            <span class="ml-2">{{ translate('Edit') }}</span>
          </div>
        </div>
      </div>
    </div>
</li>
<x-system.form-modal id="app-settings-pix_pro_api" title="PixPro API">
    <!-- PixPro API Enabled-->
    <div class="flex flex-col mb-3" x-data="{}">
        <label class="block text-sm font-medium text-gray-900 mb-2">
            {{ translate('Enable PixPro API') }}
        </label>

        <div class="mt-1 sm:mt-0 sm:col-span-2">
            <x-dashboard.form.toggle field="settings.pix_pro_api_enabled" />
        </div>
    </div>
    <!-- END PixPro API Enabled -->

    <!-- PixPro API Endpoint-->
    <div class="flex flex-col mb-3" x-data="{}">
        <label class="block text-sm font-medium text-gray-900 mb-2">
            {{ translate('PixPro API Endpoint') }}
        </label>

        <div class="mt-1 sm:mt-0 sm:col-span-2">
            <x-dashboard.form.input field="settings.pix_pro_api_endpoint" />
        </div>
    </div>
    <!-- END sPixPro API Endpoint -->

    <!-- PixPro API Username-->
    <div class="flex flex-col mb-3" x-data="{}">
        <label class="block text-sm font-medium text-gray-900 mb-2">
            {{ translate('PixPro API Username') }}
        </label>

        <div class="mt-1 sm:mt-0 sm:col-span-2">
            <x-dashboard.form.input field="settings.pix_pro_api_username" />
        </div>
    </div>
    <!-- END PixPro API Username -->

    <!-- PixPro API Password-->
    <div class="flex flex-col mb-3" x-data="{}">
        <label class="block text-sm font-medium text-gray-900 mb-2">
            {{ translate('PixPro API Password') }}
        </label>

        <div class="mt-1 sm:mt-0 sm:col-span-2">
            <x-dashboard.form.input field="settings.pix_pro_api_password" />
        </div>
    </div>
    <!-- END PixPro API Password -->

    <div class="w-full flex justify-end mt-4" x-data="{}">
        <button type="button" class="btn btn-primary ml-auto btn-sm" @click="
            $wire.set('settings.pix_pro_api_enabled', settings.pix_pro_api_enabled, true);
        "  wire:click="saveIntegrations('integrations.pix_pro_api')">
            {{ translate('Save') }}
        </button>
    </div>
</x-system.form-modal>
{{-- END PixPro API  --}}