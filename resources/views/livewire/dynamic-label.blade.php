<div class="relative ev-dynamic-label-container">

    <span class="underline">{!! $label->value !!}</span>



    {{-- <x-ev.dynamic-components.edit-dropdown>
    </x-ev.dynamic-components.edit-dropdown> --}}

    @if ($show_input_field)
        {{-- TODO: Improve UX and UI of this element --}}
        <div class="ev-dynamic-input-field">
            <label for="email" class="block text-sm font-small text-black">
                {{ translate('Edit Label') }}
            </label>

            <button wire:click.prevent="close()" class="btn btn-sm btn-danger ev-dynamic-close-button">
                {{ translate('X') }}
            </button>

            <div class="mt-1">
                <div class="form-inline">
                    @if ($type === 'text')
                        <input wire:model.defer="label.value" type="text" name="email" id="email" class="form-control"
                            placeholder="{{ translate('Enter Text') }}">
                    @elseif($type === 'textarea')
                        <textarea wire:model.defer="label.value">
                        </textarea>
                    @endif

                    <button type="button" wire:click.prevent="updateLabel()" class="btn btn-sm btn-success ml-1">
                        <!-- Heroicon name: solid/sort-ascending -->

                        <span>{{ translate('Save') }} </span>
                    </button>
                </div>

            </div>
        </div>


    @endif

    {{-- TODO: Make nice icon and general styling --}}
    <button wire:click.prevent="editLabel()" class="btn btn-sm ev-dynamic-edit-button">
        {{ svg('heroicon-o-pencil-alt') }}
    </button>

    <div class="hs-unfold ml-auto">
        <a class="js-hs-unfold-invoker btn btn-icon btn-sm btn-ghost-secondary card-unfold rounded-circle" href="javascript:;" data-hs-unfold-options="{
             &quot;target&quot;: &quot;#folderDropdown1&quot;,
             &quot;type&quot;: &quot;css-animation&quot;
           }" data-hs-unfold-target="#folderDropdown1" data-hs-unfold-invoker="">
          <i class="tio-more-vertical"></i>
        </a>

        <div id="folderDropdown1" class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-right hs-unfold-hidden hs-unfold-content-initialized hs-unfold-css-animation animated hs-unfold-reverse-y" style="min-width: 13rem; animation-duration: 300ms;" data-hs-target-height="306" data-hs-unfold-content="" data-hs-unfold-content-animation-in="slideInUp" data-hs-unfold-content-animation-out="fadeOut">
          <span class="dropdown-header">Settings</span>

          <a class="dropdown-item" href="#">
            <i class="tio-delete-outlined dropdown-item-icon"></i> Delete
          </a>
        </div>
      </div>

</div>
