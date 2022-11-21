{{-- Core Meta --}}
<div class="mt-8 p-4 border bg-white border-gray-200 rounded-lg shadow" x-data="{
    core_meta_template: {
        key: '{{ $field }}',
        // TODO: Add core meta field for subject
        value: ''
    },
}">
    <div class="w-full flex items-center justify-between border-b border-gray-200 pb-3 mb-4">
        <h3 class="text-lg leading-6 font-medium text-gray-900 uppercase">{{ $field }}</h3>
    </div>

    <div class="w-full">
        <ul class="w-full">
            <li class="grid grid-cols-12 gap-4 mb-4 items-center">
                <div class="col-span-5">
                    <div class="hidden">
                        <x-dashboard.form.input disabled field="meta.key" placeholder="{{ translate('meta_key') }}"
                            :x="true"></x-dashboard.form.input>
                    </div>
                </div>
                <div class="col-span-6">
                    <x-dashboard.form.input field="meta.value" placeholder="{{ translate('meta_value') }}" :x="true">
                    </x-dashboard.form.input>
                </div>

            </li>
        </ul>
    </div>
</div>
{{-- END Core Meta --}}
