<div class="lw-form card rounded position-relative {{ $class }}"
     wire:key="user-settings-{{ $user->id }}"
     key="user-settings-{{ $user->id }}"
     x-cloak
     x-data="{
        show: false,
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
                <x-ev.form.select name="user.user_type" :items="$user_types" label="{{ translate('User type') }}">
                </x-ev.form.select>
            </div>
        </div>

        <span class="divider">{{ translate('User Permissions') }}</span>

        <div class="row mt-3">
            <div class="col-3">
                <h5 class="text-18 fw-700 mb-3">{{ translate('Shop') }}</h5>
                @foreach(\Permissions::getShopPermissions() as $key => $name)
                    <div class="form-group">
                        <!-- Checkbox -->
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" id="permission-{{ $key }}" class="custom-control-input">
                            <label class="custom-control-label" for="permission-{{ $key }}">{{ $name }}</label>
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
                            <input type="checkbox" id="permission-{{ $key }}" class="custom-control-input">
                            <label class="custom-control-label" for="permission-{{ $key }}">{{ $name }}</label>
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
                            <input type="checkbox" id="permission-{{ $key }}" class="custom-control-input">
                            <label class="custom-control-label" for="permission-{{ $key }}">{{ $name }}</label>
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
                            <input type="checkbox" id="permission-{{ $key }}" class="custom-control-input">
                            <label class="custom-control-label" for="permission-{{ $key }}">{{ $name }}</label>
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
                            <input type="checkbox" id="permission-{{ $key }}" class="custom-control-input">
                            <label class="custom-control-label" for="permission-{{ $key }}">{{ $name }}</label>
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
                            <input type="checkbox" id="permission-{{ $key }}" class="custom-control-input">
                            <label class="custom-control-label" for="permission-{{ $key }}">{{ $name }}</label>
                        </div>
                        <!-- End Checkbox -->
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="card-footer" :class="{ 'd-flex': show }" x-show="show" wire:loading.class="opacity-3 prevent-pointer-events">
        <button type="button" class="btn btn-primary btn-xs ml-auto"
                @click="$wire.set('user.user_type', $('select[name=\'user.user_type\']').val(), true); $wire.save()">
            {{ translate('Save') }}
        </button>
    </div>

</div>
