@if(!empty($attribute) && $attribute->is_predefined)

    @foreach($attribute->attribute_predefined_values as $attribute_value)
        
        @foreach(get_attribute_value_wefs_by_attribute($attribute) as $wef_key => $data_type)
        @php
            $form_type = match ($wef_key) {
                default => 'plain_text'
            };
        @endphp
            <div class="w-full" x-show="Number(_.get(attribute_values[index], 'id', null)) === Number('{{ $attribute_value->id }}')">
                <livewire:dashboard.forms.wef.single-wef-form 
                    :subject="$attribute_value"
                    wef-key="{{ $wef_key }}"
                    wef-label="{{ $wef_key }}"
                    set-type="{{ $data_type }}"
                    get-type="{{ $data_type }}"
                    form-type="{{ $form_type }}"
                    :show-form="false"
                    key="{{ \UUID::generate(4)->string }}" />
            </div>
        @endforeach

    @endforeach

@endif
