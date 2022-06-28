<div class="w-full" x-data="{
        getDateOptions() {
            return {
                mode: @js($mode ?? 'single'),
                enableTime: @js($enableTime ?? false),
                altFormat: @js($dateFormat ?? 'd.m.Y'),
                dateFormat: 'U',
                altInput: true,
            };
        },
        initDateForm() {
            $nextTick(() => {
                console.log('waa');
                flatpickr('#{{ !empty($id) ? $id : str_replace('.', '_', $field) }}', this.getDateOptions()); 
            });
        }
    }" 
    x-init="initDateForm()"
    @init-form.window="initDateForm()">
    <input x-model="{{ $field }}"
            type="text"
            id="{{ !empty($id) ? $id : str_replace('.', '_', $field) }}"
            class="js-flatpickr flatpickr-custom form-standard @error($field) is-invalid @enderror"
            placeholder="{{ translate('Pick a date(s)') }}"
            {{-- TODO: Flatpickr doesn't assign autocomplete="off" attribute to newly created input: https://github.com/flatpickr/flatpickr/issues/2577 --}}
            autocomplete="off" 
            data-input />

    @if(!empty($field))
        <x-system.invalid-msg field="{{ $field }}"></x-system.invalid-msg>
    @endif
</div>
