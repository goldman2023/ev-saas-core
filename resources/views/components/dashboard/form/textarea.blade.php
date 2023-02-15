<div x-data="{
    required: @js($required),
    disabled: @js($disabled)
  }" class="w-full {{ $class }}">

    <textarea
        @if(!empty($textareaId)) id="{{ $textareaId }}" @endif

        class="{{ $textareaClass }} @error($errorField) is-invalid @enderror"

        @if(!empty($placeholder))
            placeholder="{{ $placeholder }}"
        @endif

        @if($rows > 0)
            rows="{{ $rows }}"
        @endif
        
        @if($x)
            x-model="{{ $field }}"
        @else
            wire:model.defer="{{ $field }}"
        @endif

        x-bind:disabled="disabled"
    >
        @if(!empty($text))
            {{ $text }}
        @endif
    </textarea>

    {{ $slot }}

    @if(!empty($errorField))
      <x-system.invalid-msg field="{{ $errorField }}"></x-system.invalid-msg>
    @endif
  </div>
  