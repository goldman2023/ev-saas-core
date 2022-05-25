<div x-data="{
  nullable: @js($nullable),
  required: @js($required),
}" class="w-full {{ $class }}">
  <input type="{{ $type }}" 
          class="form-standard @error($field) is-invalid @enderror"
          placeholder="{{ $placeholder }}"
          @if($type === 'number')
            @if(!empty($min) || $min === 0) min="{{ $min }}" @endif
            @if(!empty($max) || $max === 0) max="{{ $max }}" @endif
            @if($step) step="{{ $step }}" @endif
          @endif

          @if($x)
            x-model="{{ $field }}"
          @else
            wire:model.defer="{{ $field }}"
          @endif
  />
  {{ $slot }}
  @if(!empty($field))
    <x-system.invalid-msg field="{{ $field }}"></x-system.invalid-msg>
  @endif
</div>
