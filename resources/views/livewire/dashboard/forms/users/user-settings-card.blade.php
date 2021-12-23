<div class="lw-form card rounded position-relative {{ $class }}"
     wire:key="user-settings-{{ $user->id }}"
     key="user-settings-{{ $user->id }}"
     x-cloak
     x-data="{
        show: false,
        show_permissions_panel: @entangle('show_permissions_panel').defer,
        selected_role: {{ $role ?? 'null' }},
        roles_and_permissions_map: @js($all_roles->keyBy('id')->map(fn($item) => $item->permissions->keyBy('name')->keys())),
        user: @entangle('user').defer
     }"
     x-init="">

    <x-ev.loaders.spinner class="absolute-center z-10 d-none"
                          wire:loading.class.remove="d-none"></x-ev.loaders.spinner>

    <div class="card-header d-flex align-items-center justify-content-start pointer"
         wire:loading.class="opacity-3 prevent-pointer-events"
         @click="show = !show">

        @svg('heroicon-o-chevron-right', ['class' => 'square-16 mr-2', ':style' => "show && {transform: 'rotate(90deg)'}"])
        <h4 class="h5 mb-0">{{ $user->name }} ({{ $user->email }})</h4>

        <span class="badge badge-soft-danger align-items-center px-2 py-1 ml-3 text-12 text-danger"
              :class="{'d-flex':user.banned}"
              x-show="user.banned">
              {{ translate('banned') }}
        </span>
    </div>


    <div class="card-body container-fluid" x-show="show" wire:loading.class="opacity-3 prevent-pointer-events">
        <div class="row">
            <div class="col-4">
                <x-ev.form.input name="user.name" type="text" label="{{ translate('Name') }}" :required="true" placeholder="{{ translate('User name') }}" />
            </div>
            <div class="col-5">
                <x-ev.form.input name="user.email" type="email" label="{{ translate('Email') }}" :required="true" placeholder="{{ translate('Email') }}" />
            </div>
            <div class="col-3">
                @php
                    $user_types = in_array($user->user_type, App\Models\User::$vendor_user_types, true) ? App\Models\User::getAvailableUserTypes() : App\Models\User::getAvailableUserTypes(false);
                @endphp
                <x-ev.form.select name="user.user_type" id="select-user-type-{{ $user->id }}" :items="$user_types" label="{{ translate('User type') }}">
                </x-ev.form.select>
            </div>

            <div class="col-3"
                 x-init="
                    $($refs.user_role_selector).on('select2:select', (event) => {
                      selected_role = event.target.value;
                    });

                    $watch('selected_role', (value) => {
                      $($refs.user_role_selector).val(value).trigger('change');

                      if(roles_and_permissions_map[value] !== undefined && roles_and_permissions_map[value].length > 0) {
                            show_permissions_panel = true;
                            $wire.set('role', value, true);
                            $wire.call('selectSpecificPermissions', roles_and_permissions_map[value]);
                      }
                    });
                 "
            >
                <label class="input-label">{{ translate('User role') }} <span class="text-danger">*</span></label>
                <select
                    wire:model.defer="role"
                    name="role"
                    x-ref="user_role_selector"
                    id="select-user-role-{{ $user->id }}"
                    class="js-select2-custom custom-select select2-hidden-accessible"
                    data-hs-select2-options='
                        {"minimumResultsForSearch":"Infinity" @if($user->roles->isEmpty()) ,"placeholder":"Choose role..." @endif}
                    '
                >
                    @if($user->roles->isEmpty())
                        <option></option>
                    @endif
                    @foreach($all_roles as $role)
                        <option value="{{ $role->id }}" >
                            {{ $role->name }}
                        </option>
                    @endforeach
                </select>

                @error('role')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-3 d-flex align-items-center">
                <div class="d-flex align-items-center fw-600 opacity-10 mt-5">
                    <label class="toggle-switch mr-2" >
                        <input type="checkbox"
                               class="js-toggle-switch toggle-switch-input"
                               data-hs-toggle-switch-options="[]"
                               x-ref="toggle-user-permissions-panel"
                               x-on:click="show_permissions_panel = !show_permissions_panel"
                               x-bind:checked="show_permissions_panel">
                        <span class="toggle-switch-label">
                            <span class="toggle-switch-indicator"></span>
                        </span>
                        <span class="font-size-1 text-muted ml-2">{{ translate('Show permissions panel') }}</span>
                    </label>

                </div>
            </div>
        </div>

        <div class="user-permissions-panel pt-4" x-ref="user_permissions_panel" x-show="show_permissions_panel">
            <span class="divider">{{ translate('User Permissions') }}</span>

            <div class="row mt-3">
                <div class="col-12 mb-3 d-flex justify-content-right align-items-center">
                    <div class="ml-auto"
                         x-data="{ bulk_action: null }"
                         x-init="
                            $($refs.bulk_permission_actions).on('select2:select', (event) => {
                              bulk_action = event.target.value;
                            });
                            $watch('bulk_action', (value) => {
                              $($refs.bulk_permission_actions).val(value).trigger('change');
                              $wire.call('bulkAction', $($refs.bulk_permission_actions).val());
                            });
                         ">
                        <!-- Select -->
                        <select class="js-select2-custom js-datatable-filter custom-select" size="1" style="opacity: 0;"
                                data-target-column-index="1"
                                data-hs-select2-options='{
                                              "minimumResultsForSearch": "Infinity",
                                              "customClass": "custom-select custom-select-sm",
                                              "dropdownAutoWidth": true,
                                              "width": true,
                                              "dropdownCssClass": "no-max-height"
                                            }'
                                x-ref="bulk_permission_actions"
                        >
                            <option value="">{{ translate('Bulk actions') }}</option>
                            <option value="select_all" >{{ translate('Select All') }}</option>
                            <option value="deselect_all" >{{ translate('Deselect All') }}</option>
                        </select>
                        <!-- End Select -->
                    </div>

                </div>

                <div class="col-3">
                    <h5 class="text-18 fw-700 mb-3">{{ translate('Shop') }}</h5>
                    @foreach(\Permissions::getShopPermissions() as $key => $name)
                        <div class="form-group">
                            <!-- Checkbox -->
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" id="user-{{ $user->id }}-permission-{{ $key }}" class="custom-control-input"
                                       wire:model.defer="permissions.{{ $key }}.selected">
                                <label class="custom-control-label" for="user-{{ $user->id }}-permission-{{ $key }}">{{ $name }}</label>
                            </div>
                            <!-- End Checkbox -->
                        </div>
                    @endforeach
                </div>

                <div class="col-3 column-divider">
                    <h5 class="text-18 fw-700 mb-3">{{ translate('Staff') }}</h5>
                    @foreach(\Permissions::getStaffPermissions() as $key => $name)
                        <div class="form-group">
                            <!-- Checkbox -->
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" id="user-{{ $user->id }}-permission-{{ $key }}" class="custom-control-input"
                                       wire:model.defer="permissions.{{ $key }}.selected">
                                <label class="custom-control-label" for="user-{{ $user->id }}-permission-{{ $key }}">{{ $name }}</label>
                            </div>
                            <!-- End Checkbox -->
                        </div>
                    @endforeach
                </div>

                <div class="col-3 column-divider">
                    <h5 class="text-18 fw-700 mb-3">{{ translate('Products') }}</h5>
                    @foreach(\Permissions::getProductPermissions() as $key => $name)
                        <div class="form-group">
                            <!-- Checkbox -->
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" id="user-{{ $user->id }}-permission-{{ $key }}" class="custom-control-input"
                                       wire:model.defer="permissions.{{ $key }}.selected">
                                <label class="custom-control-label" for="user-{{ $user->id }}-permission-{{ $key }}">{{ $name }}</label>
                            </div>
                            <!-- End Checkbox -->
                        </div>
                    @endforeach
                </div>

                <div class="col-3 column-divider">
                    <h5 class="text-18 fw-700 mb-3">{{ translate('Orders') }}</h5>
                    @foreach(\Permissions::getOrdersPermissions() as $key => $name)
                        <div class="form-group">
                            <!-- Checkbox -->
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" id="user-{{ $user->id }}-permission-{{ $key }}" class="custom-control-input"
                                       wire:model.defer="permissions.{{ $key }}.selected">
                                <label class="custom-control-label" for="user-{{ $user->id }}-permission-{{ $key }}">{{ $name }}</label>
                            </div>
                            <!-- End Checkbox -->
                        </div>
                    @endforeach
                </div>

                <div class="col-3 ">
                    <h5 class="text-18 fw-700 mb-3">{{ translate('Blog Posts') }}</h5>
                    @foreach(\Permissions::getBlogPermissions() as $key => $name)
                        <div class="form-group">
                            <!-- Checkbox -->
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" id="user-{{ $user->id }}-permission-{{ $key }}" class="custom-control-input"
                                       wire:model.defer="permissions.{{ $key }}.selected">
                                <label class="custom-control-label" for="user-{{ $user->id }}-permission-{{ $key }}">{{ $name }}</label>
                            </div>
                            <!-- End Checkbox -->
                        </div>
                    @endforeach
                </div>

                <div class="col-3 column-divider">
                    <h5 class="text-18 fw-700 mb-3">{{ translate('Reviews') }}</h5>
                    @foreach(\Permissions::getReviewsPermissions() as $key => $name)
                        <div class="form-group">
                            <!-- Checkbox -->
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" id="user-{{ $user->id }}-permission-{{ $key }}" class="custom-control-input"
                                       wire:model.defer="permissions.{{ $key }}.selected">
                                <label class="custom-control-label" for="user-{{ $user->id }}-permission-{{ $key }}">{{ $name }}</label>
                            </div>
                            <!-- End Checkbox -->
                        </div>
                    @endforeach
                </div>
            </div>
        </div>


    </div>

    <div class="card-footer" :class="{ 'd-flex': show }" x-show="show" wire:loading.class="opacity-3 prevent-pointer-events">
        <button type="button" class="btn btn-primary btn-xs ml-auto"
                @click="
                    $wire.set('role', $('#select-user-role-{{ $user->id }}').val(), true);
                    $wire.set('user.user_type', $('#select-user-type-{{ $user->id }}').val(), true);
                    $wire.save();
                ">
            {{ translate('Save') }}
        </button>
    </div>

</div>
