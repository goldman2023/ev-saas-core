@if(!empty($upload))

    {{-- Proposal --}}
    @if($upload->getWEF('upload_tag') === 'proposal')
        <livewire:dashboard.forms.wef.single-wef-form 
            :subject="$upload" 
            wef-key="proposal_notes" 
            wef-label="{{ translate('Proposal notes') }}"
            set-type="array" 
            get-type="array" 
            form-type="text_list"
            :custom-properties="['min_rows' => 0]"
            key="{{ \UUID::generate(4)->string }}" />
    @endif

    {{-- Delivery to Warehouse --}}
    @if($upload->getWEF('upload_tag') === 'delivery_to_warehouse')
        <livewire:dashboard.forms.wef.single-wef-form 
            :subject="$upload" 
            wef-key="delivery_to_warehouse_notes" 
            wef-label="{{ translate('Delivery notes') }}"
            set-type="array" 
            get-type="array" 
            form-type="text_list"
            :custom-properties="['min_rows' => 0]"
            key="{{ \UUID::generate(4)->string }}" />
    @endif

@endif

{{-- Other Information (WEF & CoreMeta)--}}

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
