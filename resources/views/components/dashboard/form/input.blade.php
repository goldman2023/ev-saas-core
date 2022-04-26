<div x-data="{
  placeholder: @js($placeholder),
  nullable: @js($nullable),
  required: @js($required),
}" class="w-full">
  <input type="{{ $type }}" 
          class="form-standard @error($field) is-invalid @enderror"
          x-bind:placeholder="placeholder"
          @if($type === 'number')
            @if(!empty($min) || $min === 0) min="{{ $min }}" @endif
            @if(!empty($max) || $max === 0) max="{{ $max }}" @endif
            @if($step) step="{{ $step }}" @endif
          @endif
          wire:model.defer="{{ $field }}" />

  @if(!empty($field))
    <x-system.invalid-msg field="{{ $field }}"></x-system.invalid-msg>
  @endif
</div>
