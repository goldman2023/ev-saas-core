<div x-data="{
  placeholder: @js($placeholder),
  nullable: @js($nullable),
  required: @js($required),
}" class="w-full">
  <input type="text" 
          class="form-standard @error($field) is-invalid @enderror"
          x-bind:placeholder="placeholder"
          wire:model.defer="{{ $field }}" />

  @if(!empty($field))
    <x-system.invalid-msg field="{{ $field }}"></x-system.invalid-msg>
  @endif
</div>
