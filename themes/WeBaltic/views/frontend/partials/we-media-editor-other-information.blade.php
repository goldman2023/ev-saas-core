{{-- Other Information (WEF & CoreMeta)--}}
<div class="relative py-5 mt-2">
    <div class="absolute inset-0 flex items-center" aria-hidden="true">
      <div class="w-full border-t border-gray-300"></div>
    </div>
    <div class="relative flex justify-center">
      <span class="bg-white px-2 text-sm text-gray-500">{{ translate('Other information') }}</span>
    </div>
</div>
<div class="grid grid-cols-1 gap-y-3">
    {{-- <livewire:dashboard.forms.wef.single-wef-form 
    :subject="$upload" 
    wef-key="notes" 
    wef-label="{{ translate('Notes') }}" 
    data-type="string" 
    form-type="plain_text" 
    key="{{ \UUID::generate(4)->string }}" />

<livewire:dashboard.forms.wef.single-wef-form 
    :subject="$upload" 
    wef-key="number_wef" 
    wef-label="{{ translate('Number') }}"
    data-type="decimal" 
    form-type="number"
    :custom-properties="['min_value' => 0, 'max_value' => 10000, 'unit' => 'kg']"
    key="{{ \UUID::generate(4)->string }}" />

<livewire:dashboard.forms.wef.single-wef-form 
    :subject="$upload" 
    wef-key="date_wef" 
    wef-label="{{ translate('Date') }}"
    data-type="date" 
    form-type="date"
    :custom-properties="['with_time' => true, 'range' => true]"
    key="{{ \UUID::generate(4)->string }}" />

<livewire:dashboard.forms.wef.single-wef-form 
    :subject="$upload" 
    wef-key="text_list" 
    wef-label="{{ translate('Text List') }}"
    data-type="array" 
    form-type="text_list"
    :custom-properties="['min_rows' => 0, 'max_rows' => 3]"
    key="{{ \UUID::generate(4)->string }}" />

<livewire:dashboard.forms.wef.single-wef-form 
    :subject="$upload" 
    wef-key="dropdown_wef" 
    wef-label="{{ translate('Dropdown') }}"
    data-type="array"
    form-type="dropdown"
    :predefined-items="['value-1' => 'Value 1', 'value-2' => 'Value 2']"
    :custom-properties="['multiple' => true]"
    key="{{ \UUID::generate(4)->string }}" />

<livewire:dashboard.forms.wef.single-wef-form
    :subject="$upload"
    wef-key="textarea_wef"
    wef-label="{{ translate('Text area') }}"
    data-type="string"
    form-type="textarea"
    :custom-properties="['rows' => 5, 'max_chars' => 500]"
    key="{{ \UUID::generate(4)->string }}" /> --}}
</div>
{{-- END Other Information (WEF & CoreMeta) --}}