<div class="w-full" x-data="{
        getDateOptions() {
            return {
                mode: @js($mode ?? 'single'),
                enableTime: @js($enableTime ?? false),
                dateFormat: @js($dateFormat ?? 'd.m.Y.'),
            };
        },
    }" x-init="$nextTick(() => { flatpickr('#{{ !empty($id) ? $id : str_replace('.', '_', $field) }}', getDateOptions()); });">
    <input x-model="{{ $field }}"
            type="text"
            id="{{ !empty($id) ? $id : str_replace('.', '_', $field) }}"
            class="js-flatpickr flatpickr-custom form-standard @error($field) is-invalid @enderror"
            placeholder="{{ translate('Pick a date(s)') }}"
            data-input />

    @if(!empty($field))
        <x-system.invalid-msg field="{{ $field }}"></x-system.invalid-msg>
    @endif
</div>
