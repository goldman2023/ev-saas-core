<div x-data="{
  nullable: @js($nullable),
  required: @js($required),
  disabled: @js($disabled)
}" class="w-full {{ $class }}">
  <input 
          @if(!empty($inputId)) id="{{ $inputId }}" @endif
          type="{{ $type }}"
          class="{{ $inputClass }} @error($x && !empty($errorField) ? $errorField : $field) is-invalid @enderror"
          @if($placeholder)
          placeholder="{{ $placeholder }}"
          @endif

          @if($type === 'number')
            @if(!empty($min) || $min == 0) min="{{ $min }}" @endif
            @if(!empty($max) || $max == 0) max="{{ $max }}" @endif
            @if($step) step="{{ $step }}" @endif
          @endif

          @if($x)
            x-model="{{ $field }}"

            @if(!empty($value) && ($type === 'radio' || $type === 'checkbox'))
              :selected="{{ $field }} === '{{ $value }}'"
            @endif
          @else
            wire:model.defer="{{ $field }}"
          @endif

          {{-- Usually used for Checkboxes and Radio types --}}
          @if(!empty($value))
            value="{{ $value }}"
          @endif

          x-bind:disabled="disabled"
  />
  {{ $slot }}
  @if(!empty($field) || ($x && !empty($errorField)))
    <x-system.invalid-msg field="{{ $x && !empty($errorField) ? $errorField : $field }}"></x-system.invalid-msg>
  @endif
</div>
