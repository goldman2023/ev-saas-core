@php $index = Str::slug($index); @endphp

<x-livewire-tables::bs4.table.cell>
    <x-ev.form.file-selector name="rows.{{ $index }}.image"
                             template="avatar"
                             selectedFile="{{ $row->thumbnail ?? null }}"
                             errorBagName="rows.{{ $row->thumbnail }}"
                             :multiple="false"
                             :sortable="false"
                             wire-type="defer">
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
    <x-ev.form.select name="rows.{{ $index }}.variant.{{ $att->id }}.attribute_value_id"
                      error-bag-name="rows.{{ $index }}"
                      :items="$att->attribute_values"
                      value-property="id"
                      label-property="values"
                      :multiple="false"
                      data-attribute-id="{{ $att->id }}"
                      selected="{{ $row->variant->{$att->id}->attribute_value_id }}"
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
    <x-ev.form.input name="rows.{{ $index }}.price"
                     type="number"
                     min="0"
                     value="{{ ($row->price ?? null) ?: 0 }}"
                     wireType="defer">
    </x-ev.form.input>
</x-livewire-tables::bs4.table.cell>

<x-livewire-tables::bs4.table.cell>
    <x-ev.form.input name="rows.{{ $index }}.temp_stock.qty"
                     type="number"
                     min="0"
                     value="{{ ($row->temp_stock->qty ?? null) ?: 0 }}"
                     wireType="defer">
    </x-ev.form.input>
</x-livewire-tables::bs4.table.cell>

<x-livewire-tables::bs4.table.cell>
    <x-ev.form.input name="rows.{{ $index }}.temp_stock.sku"
                     type="text"
                     value="{{ ($row->temp_stock->sku ?? null) ?: '' }}"
                     wireType="defer">
    </x-ev.form.input>
</x-livewire-tables::bs4.table.cell>


<x-livewire-tables::bs4.table.cell>
    <button type="button" class="btn btn-danger px-2 pt-2 pb-1 mt-2" wire:click="setRemoveFlag('{{ $index }}')" style="line-height: 1;">
        @svg('heroicon-o-x', ['style' => 'width: 16px; height: 16px;'])
    </button>
</x-livewire-tables::bs4.table.cell>
