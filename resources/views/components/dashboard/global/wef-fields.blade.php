 {{-- WEF Fields --}}
 <div class="mt-8 border bg-white border-gray-200 rounded-lg shadow select-none" x-data="{
    open: false,
    }" :class="{'p-4': open}" wire:ignore>
    
    <div class="w-full flex items-center justify-between cursor-pointer " @click="open = !open"
        :class="{'border-b border-gray-200 pb-4 mb-4': open, 'p-4': !open}">
        <h3 class="text-lg leading-6 font-medium text-gray-900">{{ translate('Fields') }}</h3>
        @svg('heroicon-o-chevron-down', ['class' => 'h-4 w-4', ':class' => "{'rotate-180':open}"])
    </div>

    <div class="w-full" x-show="open">

        @if(!empty($wefFields))
            @foreach($wefFields as $wef_field)
                <div class="flex flex-col py-2">
                    <livewire:dashboard.forms.wef.single-wef-form
                        :subject="$model"
                        :wef-key="$wef_field['wef_key'] ?? ''" 
                        :wef-label="$wef_field['wef_label'] ?? ''"
                        :data-type="$wef_field['data_type'] ?? ''"
                        :form-type="$wef_field['form_type'] ?? ''"
                        :custom-properties="$wef_field['custom_properties'] ?? []"
                        :positioning="$wef_field['positioning'] ?? 'vertical'"
                        key="{{ \UUID::generate(4)->string }}" />
                </div>
            @endforeach
        @endif

    </div>
</div>
{{-- END WEF Fields --}}
