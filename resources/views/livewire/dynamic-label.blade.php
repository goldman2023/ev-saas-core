<div class="position-relative relative ev-dynamic-label-container z-index-100">

    <span class="underline">{!! $label->value !!}</span>



    {{-- <x-ev.dynamic-components.edit-dropdown>
    </x-ev.dynamic-components.edit-dropdown> --}}

    @if ($show_input_field)
        <div
        style="z-index: 999"
            class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-card hs-unfold-content-initialized hs-unfold-css-animation animated slideInUp hs-unfold-reverse-y">
            {{-- TODO: Improve UX and UI of this element --}}
            <div class="card ev-dynamic-input-field">

               <div class="card-header">
                    {{ translate('Edit Label') }}
               </div>


                <div class="card-body">
                    <div class="">
                        <div class="form">
                            @if ($type === 'text')
                                <input wire:model.defer="label.value" type="text" name="email" id="email"
                                    class="form-control" placeholder="{{ translate('Enter Text') }}">
                            @elseif($type === 'textarea')
                                <textarea wire:model.defer="label.value">
                            </textarea>
                            @endif


                        </div>

                    </div>
                </div>

                <div class="card-footer">
                    <button type="button" wire:click.prevent="updateLabel()" class="btn btn-sm btn-success ml-1">
                        <!-- Heroicon name: solid/sort-ascending -->

                        <span>{{ translate('Save') }} </span>
                    </button>
                    <button wire:click.prevent="close()" class="btn btn-sm btn-danger ev-dynamic-close-button">
                        <span>{{ translate('Cancel') }} </span>
                    </button>
                </div>


            </div>

        </div>
    @endif



    <div class="hs-unfold ml-auto">
        <button wire:click.prevent="editLabel()"
            class="js-hs-unfold-invoker btn btn-icon btn-sm btn-ghost-secondary card-unfold rounded-circle"
            href="javascript:;">
            @svg('heroicon-o-pencil-alt')
            {{ translate('edit') }}
        </button>

        <div id="folderDropdown1"
            class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-right hs-unfold-hidden hs-unfold-content-initialized hs-unfold-css-animation animated hs-unfold-reverse-y"
            style="min-width: 13rem; animation-duration: 300ms;" data-hs-target-height="306" data-hs-unfold-content=""
            data-hs-unfold-content-animation-in="slideInUp" data-hs-unfold-content-animation-out="fadeOut">
            <span class="dropdown-header">Settings</span>

            <a class="dropdown-item" href="#">
                <i class="tio-delete-outlined dropdown-item-icon"></i> Delete
            </a>
        </div>
    </div>

</div>
