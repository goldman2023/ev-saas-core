<div class="w-full livewire-file-manager-form" x-data="{
    {{ $field }}: @js(!empty($subject->{$field}) ? $subject->{$field}->map(fn($item, $key) => toJSONMedia($item)) : []),
    onSave() {
        $wire.set('subject.{{ $field }}', this.{{ $field }}, true);
    }
}">
    <x-dashboard.form.file-selector
        id="{{ $field.'-'.Uuid::generate(4)->string }}"
        field="{{ $field }}"
        file-type="{{ \App\Enums\FileTypesEnum::image()->value }}"
        :selected-image="$subject->{$field}"
        :multiple="$multiple"
        :subject="$subject"
        add-new-item-label="{{ $addNewItemLabel }}"
        wrapper-class="{{ $wrapperClass }}">
    </x-dashboard.form.file-selector>

    <button type="button" class="btn-primary" @click="onSave()" wire:click="saveFiles">
        {{ translate('Save') }}
    </button>

    <x-system.invalid-msg field="subject.{{ $field }}"></x-system.invalid-msg>
</div>