{{-- Tracking number --}}
<div class="sm:grid sm:grid-cols-3 sm:items-center sm:gap-4 sm:pt-5">
    <label class="flex items-center text-sm font-medium text-gray-700">
        <span class="mr-2">{{ translate('Is manufacturing order?') }}</span>
    </label>

    <div class="sm:col-span-2">
        <x-dashboard.form.toggle field="wef.is_manufacturing_order" />
    </div>
</div>
{{-- END Tracking number --}}