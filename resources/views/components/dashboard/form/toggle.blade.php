<div x-data="{
  label: @js($label),
}" class="w-full">

  <button type="button" @click="{{ $field }} = !{{ $field }}"
          :class="{'bg-primary':{{ $field }} , 'bg-gray-200':!{{ $field }}}"
          class="relative inline-flex flex-shrink-0 h-6 w-11 border-2 border-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary" role="switch" >
          <span :class="{'translate-x-5':{{ $field }}, 'translate-x-0':!{{ $field }}}" class="pointer-events-none inline-block h-5 w-5 rounded-full bg-white shadow transform ring-0 transition ease-in-out duration-200"></span>
  </button>

  @if(!empty($field))
    <x-system.invalid-msg field="{{ $field }}"></x-system.invalid-msg>
  @endif
</div>
