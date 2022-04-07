<div x-data="{
  colorPicker: null,
  id: @js(str_replace('.', '-', $field)),
  initColorPicker() {
    if(!this.colorPicker) {
      console.log('#'+this.id);
      this.colorPicker = new window.iro.ColorPicker('#'+this.id, {
        width: 200,
        color: {{ $field }}
      });
      this.colorPicker.on('input:end', function(color) {
        {{ $field }} = color.hexString;
        {{-- $('#section_settings_background_color_input').val(); --}}
      });
    }
  }
}" 
class="w-full" 
x-init="initColorPicker();" wire:ignore>
  <div class="flex justify-center" :id="id"></div>

  <div class="mt-3">
    <input type="text" id="section_settings_background_color_input" x-model.lazy="{{ $field }}" class="shadow-sm focus:ring-primary focus:border-primary block w-full sm:text-sm border-gray-300 rounded-md">
  </div>
</div>


  {{-- $watch('{{ $field }}', new_color => {
    if(new_color !== this.colorPicker.color.hexString) {
      this.colorPicker.color.hexString = new_color;
      console.log(new_color);
    }
  }); --}}
  
