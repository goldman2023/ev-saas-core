<div class="mt-7 text-20 font-semibold">
    {{ translate('Pix-Pro Settings') }}
</div>

<!-- Software download URL -->
<div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 sm:mt-2" x-data="{}">
    <label class="block text-sm font-medium text-gray-900 sm:mt-px sm:pt-2">
        {{ translate('Download Software URL') }}
    </label>

    <div class="mt-1 sm:mt-0 sm:col-span-2">
        <x-dashboard.form.input field="settings.pix_pro_software_download_url" />
    </div>
</div>
<!-- END Software download URL -->