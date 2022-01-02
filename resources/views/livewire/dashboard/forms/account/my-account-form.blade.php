<div class="my-account-form lw-form row"
     x-data="{
            current: 'basicInformation',
            me: @entangle('me').defer,
            fileChosen(event, property_name) {
              this.fileToDataUrl(event, src => this[property_name] = src)
            },
            fileToDataUrl(event, callback) {
              if (! event.target.files.length) return

              let file = event.target.files[0],
                  reader = new FileReader()

              reader.readAsDataURL(file)
              reader.onload = e => callback(e.target.result)
            },
        }"
        x-init="$watch('current', function(value) {
            $([document.documentElement, document.body]).animate({
                scrollTop: $('#'+value).offset().top - $('#header').outerHeight()
            }, 500);
        })">
    <div class="col-lg-3">
        <!-- Navbar -->
        <div class="navbar-vertical navbar-expand-lg mb-3 mb-lg-5">
            <!-- Navbar Toggle -->
            <button type="button" class="navbar-toggler btn btn-block btn-white mb-3" aria-label="Toggle navigation" aria-expanded="false" aria-controls="navbarVerticalNavMenu" data-toggle="collapse" data-target="#navbarVerticalNavMenu">
                <span class="d-flex justify-content-between align-items-center">
                  <span class="h5 mb-0">Nav menu</span>

                  <span class="navbar-toggle-default">
                    <i class="tio-menu-hamburger"></i>
                  </span>

                  <span class="navbar-toggle-toggled">
                    <i class="tio-clear"></i>
                  </span>
                </span>
            </button>
            <!-- End Navbar Toggle -->

            <div id="navbarVerticalNavMenu" class="collapse navbar-collapse">
                <!-- Navbar Nav -->
                <ul id="navbarSettings" class="js-sticky-block js-scrollspy navbar-nav navbar-nav-lg nav-tabs card card-navbar-nav flex-column w-100"
                    data-hs-sticky-block-options='{
                       "parentSelector": "#navbarVerticalNavMenu",
                       "breakpoint": "lg",
                       "startPoint": "#navbarVerticalNavMenu",
                       "endPoint": "#stickyBlockEndPoint",
                       "stickyOffsetTop": 20
                     }'>
                    <li class="nav-item w-100">
                        <a class="nav-link py-3 pointer"
                           :class="{'active': current === 'basicInformation'}"
                           @click="current = 'basicInformation';">
                            <i class="tio-user-outlined nav-icon"></i> {{ translate('Basic information') }}
                        </a>
                    </li>
                    <li class="nav-item w-100">
                        <a class="nav-link py-3 pointer"
                           :class="{'active': current === 'emailSection'}"
                           @click="current = 'emailSection';">
                            <i class="tio-online nav-icon"></i> {{ translate('Email') }}
                        </a>
                    </li>
                    <li class="nav-item w-100">
                        <a class="nav-link py-3 pointer"
                           :class="{'active': current === 'passwordSection'}"
                           @click="current = 'passwordSection';" >
                            <i class="tio-lock-outlined nav-icon"></i> {{ translate('Password') }}
                        </a>
                    </li>
                    <li class="nav-item w-100">
                        <a class="nav-link py-3 pointer"
                           :class="{'active': current === 'addressesSection'}"
                           @click="current = 'addressesSection';" >
                            <i class="tio-home-outlined nav-icon"></i> {{ translate('Addresses') }}
                        </a>
                    </li>
                    <li class="nav-item w-100">
                        <a class="nav-link py-3 pointer"
                           :class="{'active': current === 'preferencesSection'}"
                           @click="current = 'preferencesSection';">
                            <i class="tio-settings-outlined nav-icon"></i> {{ translate('Preferences') }}
                        </a>
                    </li>
                    <li class="nav-item w-100">
                        <a class="nav-link py-3 pointer"
                           :class="{'active': current === 'twoStepVerificationSection'}"
                           @click="current = 'twoStepVerificationSection';">
                            <i class="tio-fingerprint nav-icon"></i> {{ translate('Two-step verification') }}
                        </a>
                    </li>
                    <li class="nav-item w-100">
                        <a class="nav-link py-3 pointer"
                           :class="{'active': current === 'recentDevicesSection'}"
                           @click="current = 'recentDevicesSection';">
                            <i class="tio-devices-apple nav-icon"></i> {{ translate('Recent devices') }}
                        </a>
                    </li>
                    <li class="nav-item w-100">
                        <a class="nav-link py-3 pointer"
                           :class="{'active': current === 'notificationsSection'}"
                           @click="current = 'notificationsSection';">
                            <i class="tio-notifications-on-outlined nav-icon"></i> {{ translate('Notifications') }}
                        </a>
                    </li>
                    <li class="nav-item w-100">
                        <a class="nav-link py-3 pointer"
                           :class="{'active': current === 'connectedAccountsSection'}"
                           @click="current = 'connectedAccountsSection';">
                            <i class="tio-node-multiple-outlined nav-icon"></i> {{ translate('Connected accounts') }}
                        </a>
                    </li>
                    <li class="nav-item w-100">
                        <a class="nav-link py-3 pointer"
                           :class="{'active': current === 'socialAccountsSection'}"
                           @click="current = 'socialAccountsSection';">
                            <i class="tio-instagram nav-icon"></i> {{ translate('Social accounts') }}
                        </a>
                    </li>
                    <li class="nav-item w-100">
                        <a class="nav-link py-3 pointer"
                           :class="{'active': current === 'deleteAccountSection'}"
                           @click="current = 'deleteAccountSection';">
                            <i class="tio-delete-outlined nav-icon"></i> {{ translate('Delete account') }}
                        </a>
                    </li>
                </ul>
                <!-- End Navbar Nav -->
            </div>
        </div>
        <!-- End Navbar -->
    </div>

    <div class="col-lg-9">
        <!-- Thumbnail & Cover Card -->
        <div class="card mb-3 mb-lg-5 position-relative"
             id="basicInformation"
             x-data="{}"
        >

            <x-ev.loaders.spinner class="absolute-center z-10 d-none"
                                  wire:target="saveBasicInformation"
                                  wire:loading.class.remove="d-none"></x-ev.loaders.spinner>

            <div class=""
                 wire:loading.class="opacity-3 prevent-pointer-events"
                 wire:target="saveBasicInformation"
            >
                <!-- Profile Cover -->
                <div class="profile-cover">
                    <div class="profile-cover-img-wrapper"
                         x-data="{
                        name: 'me.cover',
                        imageID: {{ $me->cover->id ?? 'null' }},
                        imageURL: '{{ $me->getCover(['w'=>1200]) }}',
                    }"
                         @aiz-selected.window="
                     if(event.detail.name === name) {
                        imageURL = event.detail.imageURL;
                        $wire.set('me.cover', $('input[name=\'me.cover\']').val(), true);
                     }"
                         data-toggle="aizuploader"
                         data-type="image">

                        <img id="profileCoverImg" class="profile-cover-img" x-bind:src="imageURL">


                        <!-- Custom File Cover -->
                        <div class="profile-cover-content profile-cover-btn custom-file-manager"
                             data-toggle="aizuploader" data-type="image">
                            <div class="custom-file-btn">

                                <input type="hidden" x-bind:name="name" x-model="me.cover" class="selected-files" data-preview-width="1200">

                                <label class="custom-file-btn-label btn btn-sm btn-white shadow-lg" for="profileCoverUploader">
                                    <i class="tio-add-photo mr-sm-1"></i>
                                    <span class="d-none d-sm-inline-block">{{ translate('Update your cover') }}</span>
                                </label>
                            </div>
                        </div>
                        <!-- End Custom File Cover -->
                    </div>
                </div>
                <!-- End Profile Cover -->

                <!-- Avatar -->
                <label class="avatar avatar-xxl avatar-circle avatar-border-lg avatar-uploader mx-auto profile-cover-avatar pointer border p-1" for="avatarUploader"
                       style="margin-top: -60px;"
                       x-data="{
                        name: 'me.thumbnail',
                        imageID: {{ $me->thumbnail->id ?? 'null' }},
                        imageURL: '{{ $me->getThumbnail() }}',
                    }"
                       @aiz-selected.window="
                     if(event.detail.name === name) {
                        imageURL = event.detail.imageURL;
                        $wire.set('me.thumbnail', $('input[name=\'me.thumbnail\']').val(), true);
                     }"
                       data-toggle="aizuploader"
                       data-type="image">
                    <img id="avatarImg" class="avatar-img" x-bind:src="imageURL" >

                    <input type="hidden" x-bind:name="name" x-model="me.thumbnail" class="selected-files" data-preview-width="200">

                    <span class="avatar-uploader-trigger">
                  <i class="tio-edit avatar-uploader-icon shadow-soft"></i>
                </span>
                </label>
                <!-- End Avatar -->

                <div class="card-body">
                    @error('me.thumbnail')
                    <div class="row form-group mb-1">
                        <div class="invalid-feedback d-block mx-3 py-2 rounded bg-danger text-white px-3">{{ $message }}</div>
                    </div>
                    @enderror

                    @error('me.cover')
                    <div class="row form-group mb-1">
                        <div class="invalid-feedback d-block mx-3 py-2 rounded bg-danger text-white px-3">{{ $message }}</div>
                    </div>
                    @enderror

                    <div class="row form-group">
                        <label for="me-name" class="col-sm-3 col-form-label input-label">{{ translate('Full name') }}</label>

                        <div class="col-sm-9">
                            <div class="input-group input-group-sm-down-break">
                                <input type="text" class="form-control @error('me.name') is-invalid @enderror" name="me.name" id="me-name" placeholder="{{ translate('Your full name') }}"
                                       wire:model.defer="me.name">
                            </div>
                        </div>

                        @error('me.name')
                        <div class="invalid-feedback d-block px-3 py-2 rounded">{{ $message }}</div>
                        @enderror
                    </div>

                    {{--                <div class="row form-group">--}}
                    {{--                    <label for="me-email" class="col-sm-3 col-form-label input-label">{{ translate('Email (@)') }}</label>--}}

                    {{--                    <div class="col-sm-9">--}}
                    {{--                        <div class="input-group input-group-sm-down-break">--}}
                    {{--                            <input type="email" class="form-control @error('me.email') is-invalid @enderror" name="me.email" id="me-email" placeholder="{{ translate('Your email') }}"--}}
                    {{--                                   wire:model.defer="me.email">--}}
                    {{--                        </div>--}}
                    {{--                    </div>--}}

                    {{--                    @error('me.email')--}}
                    {{--                        <div class="invalid-feedback d-block px-3 py-2 rounded">{{ $message }}</div>--}}
                    {{--                    @enderror--}}
                    {{--                </div>--}}

                    <div class="row form-group">
                        <label for="me-phone" class="col-sm-3 col-form-label input-label">{{ translate('Phone') }} <span class="input-label-secondary">{{ translate('(Optional)') }}</span></label>

                        <div class="col-sm-9">
                            <input type="text"
                                   class="js-masked-input form-control @error('me.phone') is-invalid @enderror"
                                   name="me.phone"
                                   id="me-phone"
                                   placeholder="{{ translate('your phone number') }}"
                                   wire:model.defer="me.phone"
                            >
                        </div>

                        @error('me.phone')
                        <div class="invalid-feedback d-block px-3 py-2 rounded">{{ $message }}</div>
                        @enderror
                    </div>

                </div>

                <div class="card-footer">
                    <div class="col-12 d-flex">
                        <button type="button" class="btn btn-primary ml-auto btn-sm" wire:click="saveBasicInformation()">
                            {{ translate('Save') }}
                        </button>
                    </div>
                </div>
            </div>

            <!-- Body -->
        {{--                    <div class="card-body" data-select2-id="307">--}}
        {{--                        <div class="row" data-select2-id="306">--}}
        {{--                            <div class="col-sm-5" data-select2-id="305">--}}
        {{--                                <span class="d-block font-size-sm mb-2">Who can see your profile photo? <i class="tio-help-outlined" data-toggle="tooltip" data-placement="top" title="" data-original-title="Your visibility setting only applies to your profile photo. Your header image is always visible to anyone."></i></span>--}}

        {{--                                <!-- Select -->--}}
        {{--                                <div class="select2-custom" data-select2-id="304">--}}
        {{--                                    <select class="js-select2-custom custom-select select2-hidden-accessible" size="1" style="opacity: 0;" data-hs-select2-options='{--}}
        {{--                                        "minimumResultsForSearch": "Infinity"--}}
        {{--                                      }' data-select2-id="1" tabindex="-1" aria-hidden="true">--}}
        {{--                                        <option value="privacy1" data-option-template="<span class=&quot;media&quot;><i class=&quot;tio-earth-east tio-lg text-body mr-2&quot; style=&quot;margin-top: .125rem;&quot;></i><span class=&quot;media-body&quot;><span class=&quot;d-block&quot;>Anyone</span><small class=&quot;select2-custom-hide&quot;>Visible to anyone who can view your content. Accessible by installed apps.</small></span></span>" data-select2-id="3">Anyone</option>--}}
        {{--                                        <option value="privacy2" data-option-template="<span class=&quot;media&quot;><i class=&quot;tio-lock-outlined tio-lg text-body mr-2&quot; style=&quot;margin-top: .125rem;&quot;></i><span class=&quot;media-body&quot;><span class=&quot;d-block&quot;>Only you</span><small class=&quot;select2-custom-hide&quot;>Only visible to you.</small></span></span>" data-select2-id="4">Only you</option>--}}
        {{--                                    </select><span class="select2 select2-container select2-container--default select2-container--below" dir="ltr" data-select2-id="2" style="width: 100%; top: 0px;"><span class="selection"><span class="select2-selection custom-select" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-disabled="false" aria-labelledby="select2-z801-container"><span class="select2-selection__rendered" id="select2-z801-container" role="textbox" aria-readonly="true" title="Anyone"><span class="media"><i class="tio-earth-east tio-lg text-body mr-2" style="margin-top: .125rem;"></i><span class="media-body"><span class="d-block">Anyone</span><small class="select2-custom-hide">Visible to anyone who can view your content. Accessible by installed apps.</small></span></span></span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>--}}
        {{--                                </div>--}}
        {{--                                <!-- End Select -->--}}
        {{--                            </div>--}}
        {{--                        </div>--}}
        {{--                        <!-- End Row -->--}}
        {{--                    </div>--}}
        <!-- End Body -->
        </div>
        <!-- END Thumbnail & Cover Card -->


        <!-- Email -->
        <div class="card mb-3 mb-lg-5 position-relative"
             id="emailSection"
             x-data="{}">

            <x-ev.loaders.spinner class="absolute-center z-10 d-none"
                                  wire:target="saveEmail"
                                  wire:loading.class.remove="d-none"></x-ev.loaders.spinner>

            <div class="card-header">
                <h2 class="card-title h4">{{ translate('Email') }}</h2>
            </div>

            <div class=""
                 wire:loading.class="opacity-3 prevent-pointer-events"
                 wire:target="saveEmail"
            >
                <div class="card-body">
                    <p>{{ translate('Your current email address is:') }} <span class="font-weight-bold">{{ $me->email }}</span></p>

                    <!-- Form Group -->
                    <div class="row form-group">
                        <label for="newEmailLabel" class="col-sm-3 col-form-label input-label">{{ translate('New email address') }}</label>

                        <div class="col-sm-9">
                            <input type="text" class="form-control @error('me.email') is-invalid @enderror"
                                   name="me.email" id="me-v" placeholder="{{ translate('Your new email') }}"
                                   wire:model.defer="me.email">
                        </div>

                        @error('me.email')
                            <div class="invalid-feedback d-block px-3 py-2 rounded">{{ $message }}</div>
                        @enderror
                    </div>
                    <!-- End Form Group -->
                </div>
            </div>

            <div class="card-footer">
                <div class="col-12 d-flex">
                    <button type="button" class="btn btn-primary ml-auto btn-sm" wire:click="saveEmail()">
                        {{ translate('Save') }}
                    </button>
                </div>
            </div>
        </div>
        <!-- END Email -->

        <!-- Password -->
        <div class="card mb-3 mb-lg-5 position-relative"
             id="passwordSection"
             x-data="{
                currentPassword: '',
                newPassword: '',
                newPassword_confirmation: '',
                update() {
                    $wire.set('currentPassword', this.currentPassword, true);
                    $wire.set('newPassword', this.newPassword, true);
                    $wire.set('newPassword_confirmation', this.newPassword_confirmation, true);
                    $wire.updatePassword();
                }
             }">

            <x-ev.loaders.spinner class="absolute-center z-10 d-none"
                                  wire:target="updatePassword"
                                  wire:loading.class.remove="d-none"></x-ev.loaders.spinner>

            <div class="card-header">
                <h4 class="card-title">{{ translate('Change your password') }}</h4>
            </div>

            <!-- Body -->
            <div class=""
                 wire:loading.class="opacity-3 prevent-pointer-events"
                 wire:target="updatePassword">
                <div class="card-body">
                    <!-- Form Group -->
                    <div class="row form-group">
                        <label for="currentPasswordLabel" class="col-sm-3 col-form-label input-label">{{ translate('Current password') }}</label>

                        <div class="col-sm-9">
                            <input type="password" class="form-control @error('currentPassword') is-invalid @enderror" name="currentPassword" id="currentPasswordLabel"
                                   x-model="currentPassword"
                                   placeholder="{{ translate('Enter current password') }}">
                        </div>

                        @error('currentPassword')
                            <div class="invalid-feedback d-block px-3 py-2 rounded">{{ $message }}</div>
                        @enderror
                    </div>
                    <!-- End Form Group -->

                    <!-- Form Group -->
                    <div class="row form-group">
                        <label for="newPassword" class="col-sm-3 col-form-label input-label">{{ translate('New password') }}</label>

                        <div class="col-sm-9">
                            <input type="password" class="js-pwstrength form-control @error('newPassword') is-invalid @enderror" name="newPassword" id="newPassword"
                                   x-model="newPassword"
                                   placeholder="{{ translate('Enter new password') }}"
                                   data-hs-pwstrength-options='{
                                       "ui": {
                                         "container": "#passwordSection",
                                         "viewports": {
                                           "progress": "#passwordStrengthProgress",
                                           "verdict": "#passwordStrengthVerdict"
                                         }
                                       }
                                     }'>

                            <p id="passwordStrengthVerdict" class="form-text mb-2"></p>

                            <div id="passwordStrengthProgress"></div>
                        </div>

                        @error('newPassword')
                            <div class="invalid-feedback d-block px-3 py-2 rounded">{{ $message }}</div>
                        @enderror

                        @error('newPassword_confirmation')
                            <div class="invalid-feedback d-block px-3 py-2 rounded">{{ $message }}</div>
                        @enderror
                    </div>
                    <!-- End Form Group -->

                    <!-- Form Group -->
                    <div class="row form-group mb-0">
                        <label for="confirmNewPasswordLabel" class="col-sm-3 col-form-label input-label">{{ translate('Confirm new password') }}</label>

                        <div class="col-sm-9">
                            <div class="mb-3">
                                <input type="password" class="form-control @error('newPassword_confirmation') is-invalid @enderror" name="confirmNewPassword" id="confirmNewPasswordLabel"
                                       x-model="newPassword_confirmation"
                                       placeholder="{{ translate('Confirm your new password') }}">
                            </div>

                            <h5>{{ translate('Password requirements:') }}</h5>

                            <p class="font-size-sm mb-2">{{ translate('Ensure that these requirements are met:') }}</p>

                            <ul class="font-size-sm">
                                <li>{{ translate('Minimum 8 characters long - the more, the better') }}</li>
                                <li>{{ translate('At least one lowercase character') }}</li>
                                <li>{{ translate('At least one uppercase character') }}</li>
                                <li>{{ translate('At least one number') }}</li>
                            </ul>
                        </div>
                    </div>
                    <!-- End Form Group -->
                </div>
            </div>
            <!-- End Body -->

            <div class="card-footer">
                <div class="col-12 d-flex">
                    <button type="button" class="btn btn-primary ml-auto btn-sm" @click="update()">
                        {{ translate('Save') }}
                    </button>
                </div>
            </div>
        </div>
        <!-- END Password -->


        <!-- Addresses -->
        <div class="card mb-3 mb-lg-5 position-relative"
             id="addressesSection"
             x-data="{
                currentAddress: @js($this->me->addresses->first())
             }">

            <x-ev.loaders.spinner class="absolute-center z-10 d-none"
                                  wire:target="saveAddresses"
                                  wire:loading.class.remove="d-none"></x-ev.loaders.spinner>

            <div class="card-header">
                <h2 class="card-title h4">{{ translate('Addresses') }}</h2>
            </div>

            <div class="card-body">
                <div class="row"
                     wire:loading.class="opacity-3 prevent-pointer-events"
                     wire:target="saveAddresses"
                >
                    @if(!empty($this->me->addresses))
                        @foreach($this->me->addresses as $address)
                            <div class="col-4 px-2 mb-3">
                                <div class="card w-100 pointer"
                                     data-toggle="modal"
                                     data-target="#updateAddressModal"
                                     x-data="{
                                        address: @js($address)
                                     }"
                                     @click="
                                        currentAddress = address;
                                         $('#updateAddressModal .js-toggle-switch').each(function () {
                                            var addressToggleSwitch = new HSToggleSwitch($(this)).init();
                                        });
                                    ">
                                    <div class="card-body">
                                        <h6 class="card-subtitle">{{ \Countries::get(code: $address->country)->name ?? translate('Unknown') }}</h6>
                                        <h3 class="card-title text-18">{{ $address->address }}</h3>
                                        <p class="card-text mb-2">{{ $address->city }}, {{ $address->zip_code }}</p>

                                        @if(!empty($address->phones))
                                            <div class="d-flex align-items-center ">
                                                @foreach($address->phones as $address_phone)
                                                    <span class="badge badge-info mr-2">{{ $address_phone }}</span>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>


            <div class="card-footer">
                <div class="col-12 d-flex">
                    <button type="button" class="btn btn-primary ml-auto btn-sm" wire:click="saveEmail()">
                        {{ translate('Save') }}
                    </button>
                </div>
            </div>

            <!-- Address change Modal -->
            <template x-if="currentAddress">
                <div id="updateAddressModal" class="modal fade" tabindex="-1" role="dialog">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <!-- Header -->
                            <div class="modal-top-cover bg-dark text-center">
                                <figure class="position-absolute right-0 bottom-0 left-0" style="margin-bottom: -1px;">
                                    <svg preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" viewBox="0 0 1920 100.1"
                                         style="vertical-align: middle;">
                                        <path fill="#fff" d="M0,0c0,0,934.4,93.4,1920,0v100.1H0L0,0z"/>
                                    </svg>
                                </figure>

                                <div class="modal-close">
                                    <button type="button" class="btn btn-icon btn-sm btn-ghost-light" data-dismiss="modal" aria-label="Close">
                                        <svg width="16" height="16" viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg">
                                            <path fill="currentColor" d="M11.5,9.5l5-5c0.2-0.2,0.2-0.6-0.1-0.9l-1-1c-0.3-0.3-0.7-0.3-0.9-0.1l-5,5l-5-5C4.3,2.3,3.9,2.4,3.6,2.6l-1,1 C2.4,3.9,2.3,4.3,2.5,4.5l5,5l-5,5c-0.2,0.2-0.2,0.6,0.1,0.9l1,1c0.3,0.3,0.7,0.3,0.9,0.1l5-5l5,5c0.2,0.2,0.6,0.2,0.9-0.1l1-1 c0.3-0.3,0.3-0.7,0.1-0.9L11.5,9.5z"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <!-- End Header -->

                            <div class="modal-top-cover-icon">
                            <span class="icon icon-md icon-light icon-circle d-flex mx-auto shadow-soft">
                              @svg('heroicon-o-home', ['class' => 'square-24'])
                            </span>
                            </div>

                            <div class="modal-body row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label class="input-label " for="modal_address_address">{{ translate('Address') }}</label>
                                        <input type="text"
                                               id="modal_address_address"
                                               name="model_address_address"
                                               x-model="currentAddress.address"
                                               class="form-control"
                                               placeholder="Your address...">
                                    </div>
                                </div>

                                <div class="col-6">
                                    <label class="input-label " for="modal_address_country">{{ translate('Country') }}</label>
                                    <select class="form-control custom-select" name="modal_address_country" id="modal_address_country"
                                            data-hs-select2-options='{
                                              "minimumResultsForSearch": -1,
                                              "placeholder": "Select country..."
                                            }'>
                                        <option label="empty"></option>
                                        @foreach(\Countries::getAll() as $country)
                                            <option value="{{ $country->code }}" x-bind:selected="'{{ $country->code }}' === currentAddress.country">
                                                {{ $country->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-4">
                                    <div class="form-group">
                                        <label class="input-label" for="modal_address_city">{{ translate('City') }}</label>
                                        <input type="text"
                                               id="modal_address_city"
                                               name="model_address_city"
                                               x-model="currentAddress.city"
                                               class="form-control"
                                               placeholder="City...">
                                    </div>
                                </div>

                                <div class="col-4">
                                    <div class="form-group">
                                        <label class="input-label" for="modal_address_state">{{ translate('State') }}</label>
                                        <input type="text"
                                               id="modal_address_state"
                                               name="model_address_state"
                                               x-model="currentAddress.state"
                                               class="form-control"
                                               placeholder="State...">
                                    </div>
                                </div>

                                <div class="col-4">
                                    <div class="form-group">
                                        <label class="input-label" for="modal_address_zip_code">{{ translate('Zip Code') }}</label>
                                        <input type="text"
                                               id="modal_address_zip_code"
                                               name="model_address_zip_code"
                                               x-model="currentAddress.zip_code"
                                               class="form-control"
                                               placeholder="Zip code...">
                                    </div>
                                </div>

                                <div class="col-12">
                                    <label class="toggle-switch mx-2" for="customSwitchModalEg">
                                        <input type="checkbox" x-model="currentAddress.set_default" class="js-toggle-switch toggle-switch-input" id="customSwitchModalEg">
                                        <span class="toggle-switch-label">
                                      <span class="toggle-switch-indicator"></span>
                                    </span>

                                        <span class="ml-3">{{ translate('Default address') }}</span>
                                    </label>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-white" data-dismiss="modal">{{ translate('Close') }}</button>
                                <button type="button" class="btn btn-primary">{{ translate('Save') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </template>
            <!-- End Modal -->
        </div>
        <!-- END Addresses -->
    </div>
</div>
