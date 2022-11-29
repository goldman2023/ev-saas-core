<livewire:dashboard.forms.wef.single-wef-form 
    :subject="$upload" 
    wef-key="notes" 
    wef-label="{{ translate('Notes') }}" 
    data-type="string" 
    form-type="plain_text" 
    key="{{ 'wef-notes-'.($upload?->id ?? 0).'-'.now() }}" />

<livewire:dashboard.forms.wef.single-wef-form 
    :subject="$upload" 
    wef-key="number_wef" 
    wef-label="{{ translate('Number') }}"
    data-type="decimal" 
    form-type="number"
    :custom-properties="['min_value' => 0, 'max_value' => 10000, 'unit' => 'kg']"
    key="{{ 'wef-number_wef-'.($upload?->id ?? 0).'-'.now() }}" />

<livewire:dashboard.forms.wef.single-wef-form 
    :subject="$upload" 
    wef-key="date_wef" 
    wef-label="{{ translate('Date') }}"
    data-type="date" 
    form-type="date"
    :custom-properties="['with_time' => true, 'range' => true]"
    key="{{ 'wef-date_wef-'.($upload?->id ?? 0).'-'.now() }}" />