<x-livewire-tables::bs4.table.cell>
    <x-ev.form.file-selector name="rows.{{ $row->name }}.image"
                             template="avatar"
                             selectedFile="{{ $row->image ?? null }}"
                             errorBagName="rows.{{ $row->name }}"
                             :multiple="false"
                             :sortable="false">
    </x-ev.form.file-selector>
</x-livewire-tables::bs4.table.cell>

<x-livewire-tables::bs4.table.cell>
    <span class="text-primary-600 font-medium hover:text-primary-900">{{ $row->name }}</span>
</x-livewire-tables::bs4.table.cell>

@php
if($this->attributes->isNotEmpty()) {
    foreach($this->attributes as $att) {
        $att = (object) $att;
@endphp
<x-livewire-tables::bs4.table.cell>
    <x-ev.form.select name="rows.{{ $row->name }}.variant.{{ $att->id }}.attribute_value_id"
                      error-bag-name="rows.{{ $row->name }}"
                      :items="$att->attribute_values"
                      value-property="id"
                      label-property="values"
                      :multiple="false"
                      data-attribute-id="{{ $att->id }}"
                      selected="{{ $row->variant[$att->id]['attribute_value_id'] }}"
                      data-type="{{ $att->type }}"
                      :disabled="true"
                      :is-wired="true">
    </x-ev.form.select>
</x-livewire-tables::bs4.table.cell>
@php
    }
}
@endphp


<x-livewire-tables::bs4.table.cell>
    <x-ev.form.input name="rows.{{ $row->name }}.price"
                     type="number"
                     min="0"
                     error-bag-name="rows.{{ $row->name }}"
                     value="{{ $row->price ?: 0 }}"
                     wireType="defer">
    </x-ev.form.input>
</x-livewire-tables::bs4.table.cell>

<x-livewire-tables::bs4.table.cell>
    <x-ev.form.input name="rows.{{ $row->name }}.temp_stock.qty"
                     type="number"
                     min="0"
                     error-bag-name="rows.{{ $row->name }}.temp_stock"
                     value="{{ $row->temp_stock->qty ?: 0 }}"
                     wireType="defer">
    </x-ev.form.input>
</x-livewire-tables::bs4.table.cell>

<x-livewire-tables::bs4.table.cell>
    <x-ev.form.input name="rows.{{ $row->name }}.temp_stock.sku"
                     type="text"
                     error-bag-name="rows.{{ $row->name }}.temp_stock"
                     value="{{ $row->temp_stock->sku ?: '' }}"
                     wireType="defer">
    </x-ev.form.input>
</x-livewire-tables::bs4.table.cell>

