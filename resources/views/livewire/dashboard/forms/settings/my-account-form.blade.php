<div class="my-account-form lw-form row"
     x-data="{
            current: 'basicInformation',
            me: @entangle('me').defer,
            showToast($el, $event) {
                if($($el).attr('id') === $event.detail.id) {
                    $($el).find('.toast-body').text($event.detail.content);
                    $($el).addClass('d-block opacity-10');
                    setTimeout(function() {
                        $($el).removeClass('d-block opacity-10');
                    }, 4000);
                }
            },
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

    <x-ev.toast id="my-account-updated-toast"
                position="bottom-center"
                content="{{ translate('My account successfully updated!') }}"
                class="bg-success border-success text-white h3"
                @toastit.window="showToast($el, $event)"></x-ev.toast>

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
{{--                    <li class="nav-item w-100">--}}
{{--                        <a class="nav-link py-3 pointer"--}}
{{--                           :class="{'active': current === 'emailSection'}"--}}
{{--                           @click="current = 'emailSection';">--}}
{{--                            <i class="tio-online nav-icon"></i> {{ translate('Email') }}--}}
{{--                        </a>--}}
{{--                    </li>--}}
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
                           :class="{'active': current === 'socialAccountsSection'}"
                           @click="current = 'socialAccountsSection';">
                            <i class="tio-instagram nav-icon"></i> {{ translate('Social accounts') }}
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


{{--        <!-- Email -->--}}
{{--        <div class="card mb-3 mb-lg-5 position-relative"--}}
{{--             id="emailSection"--}}
{{--             x-data="{}">--}}

{{--            <x-ev.loaders.spinner class="absolute-center z-10 d-none"--}}
{{--                                  wire:target="saveEmail"--}}
{{--                                  wire:loading.class.remove="d-none"></x-ev.loaders.spinner>--}}

{{--            <div class="card-header">--}}
{{--                <h2 class="card-title h4">{{ translate('Email') }}</h2>--}}
{{--            </div>--}}

{{--            <div class=""--}}
{{--                 wire:loading.class="opacity-3 prevent-pointer-events"--}}
{{--                 wire:target="saveEmail"--}}
{{--            >--}}
{{--                <div class="card-body">--}}
{{--                    <p>{{ translate('Your current email address is:') }} <span class="font-weight-bold">{{ $me->email }}</span></p>--}}

{{--                    <!-- Form Group -->--}}
{{--                    <div class="row form-group">--}}
{{--                        <label for="newEmailLabel" class="col-sm-3 col-form-label input-label">{{ translate('New email address') }}</label>--}}

{{--                        <div class="col-sm-9">--}}
{{--                            <input type="text" class="form-control @error('me.email') is-invalid @enderror"--}}
{{--                                   name="me.email" id="me-v" placeholder="{{ translate('Your new email') }}"--}}
{{--                                   wire:model.defer="me.email">--}}
{{--                        </div>--}}

{{--                        @error('me.email')--}}
{{--                            <div class="invalid-feedback d-block px-3 py-2 rounded">{{ $message }}</div>--}}
{{--                        @enderror--}}
{{--                    </div>--}}
{{--                    <!-- End Form Group -->--}}
{{--                </div>--}}
{{--            </div>--}}

{{--            <div class="card-footer">--}}
{{--                <div class="col-12 d-flex">--}}
{{--                    <button type="button" class="btn btn-primary ml-auto btn-sm" wire:click="saveEmail()">--}}
{{--                        {{ translate('Save') }}--}}
{{--                    </button>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--        <!-- END Email -->--}}

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
        <livewire:dashboard.forms.addresses.addresses-form :addresses="$this->me->addresses" toast_it="my-account-updated-toast">
        </livewire:dashboard.forms.addresses.addresses-form>
        <!-- END Addresses -->

        <!-- Social accounts -->
        <div id="socialAccountsSection" class="card mb-3 mb-lg-5">
            <div class="card-header">
                <h4 class="card-title">{{ translate('Social accounts') }}</h4>
            </div>

            <!-- Body -->
            <div class="card-body">
                <div class="list-group list-group-lg list-group-flush list-group-no-gutters">

                    <!-- List Item -->
                    @if(!empty(\App\Models\SocialAccount::$available_providers))
                        @foreach(\App\Models\SocialAccount::$available_providers as $key => $provider)
                            <div class="list-group-item">
                                <div class="media d-flex align-items-center">
                                    <div class="pl-2">
                                        @switch($key)
                                            @case('google')
                                            <i class="tio-google list-group-icon mt-1"></i>
                                            @break

                                            @case('facebook')
                                            <i class="tio-facebook list-group-icon mt-1"></i>
                                            @break

                                            @case('twitter')
                                            <i class="tio-twitter list-group-icon mt-1"></i>
                                            @break

                                            @case('linkedin')
                                            <i class="tio-linkedin list-group-icon mt-1"></i>
                                            @break

                                            @case('pinterest')
                                            <i class="tio-pinterest list-group-icon mt-1"></i>
                                            @break

                                            @case('github')
                                            <i class="tio-github list-group-icon mt-1"></i>
                                            @break
                                        @endswitch
                                    </div>

                                    <div class="media-body">
                                        <div class="d-flex align-items-center">
                                            @php
                                                $social_account = $me->getSocialAccount($key);
                                            @endphp
                                            <div class="col-sm mb-2 mb-sm-0">
                                                <h5 class="mb-0 d-flex align-items-center">
                                                    <strong class="mr-3">{{ $provider }}</strong>
                                                    @if($social_account->connected ?? null)
                                                        <span class="badge badge-success text-12">{{ translate('active') }}</span>
                                                    @else
                                                        <span class="badge badge-danger text-12">{{ translate('inactive') }}</span>
                                                    @endif
                                                </h5>
                                                @if($social_account)
                                                    <a class="font-size-sm" href="#">{{ $social_account->profile_url ?? '' }}</a>
                                                @endif
                                            </div>

                                            <div class="col-sm-auto">
                                                <a class="btn btn-sm btn-{{ ($social_account->connected ?? null) ? 'danger':'white' }}" href="{{ ($social_account->connected ?? null) ? '#' : route('social.connect', $key) }}" target="_blank">
                                                    {{ ($social_account->connected ?? null) ? translate('Disconnect') : translate('Connect') }}
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End List Item -->
                        @endforeach
                    @endif

                </div>
            </div>
            <!-- End Body -->
        </div>
        <!-- END Social accounts -->

        <!-- Connected accounts -->
        <div id="connectedAccountsSection" class="card mb-3 mb-lg-5">
            <div class="card-header">
                <h4 class="card-title">{{ translate('Connected accounts') }}</h4>
            </div>

            <!-- Body -->
            <div class="card-body">
                <p class="card-text">{{ translate('Integrated features from these accounts make it easier to fulfil your day-to-day business activities.') }}</p>

                <!-- Form -->
                <form>
                    <div class="list-group list-group-lg list-group-flush list-group-no-gutters">
                        <!-- List Item -->
                        <div class="list-group-item">
                            <div class="media">
{{--                                <img class="avatar avatar-xs mt-1 mr-3" src="./assets/svg/brands/google.svg" alt="Image Description">--}}

                                <div class="media-body">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <h5 class="mb-0">Google</h5>
                                            <p class="font-size-sm mb-0">Calendar and contacts</p>
                                        </div>

                                        <div class="col-auto">
                                            <!-- Checkbox Switch -->
                                            <label class="toggle-switch" for="connectedAccounts1">
                                                <input id="connectedAccounts1" type="checkbox" class="toggle-switch-input">
                                                <span class="toggle-switch-label">
                                  <span class="toggle-switch-indicator"></span>
                                </span>
                                            </label>
                                            <!-- End Checkbox Switch -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End List Item -->

                        <!-- List Item -->
                        <div class="list-group-item">
                            <div class="media">
{{--                                <img class="avatar avatar-xs mt-1 mr-3" src="./assets/svg/brands/spec.svg" alt="Image Description">--}}

                                <div class="media-body">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <h5 class="mb-0">Spec</h5>
                                            <p class="font-size-sm mb-0">Project management</p>
                                        </div>

                                        <div class="col-auto">
                                            <!-- Checkbox Switch -->
                                            <label class="toggle-switch" for="connectedAccounts2">
                                                <input id="connectedAccounts2" type="checkbox" class="toggle-switch-input">
                                                <span class="toggle-switch-label">
                                  <span class="toggle-switch-indicator"></span>
                                </span>
                                            </label>
                                            <!-- End Checkbox Switch -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End List Item -->

                        <!-- List Item -->
                        <div class="list-group-item">
                            <div class="media">
{{--                                <img class="avatar avatar-xs mt-1 mr-3" src="./assets/svg/brands/slack.svg" alt="Image Description">--}}

                                <div class="media-body">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <h5 class="mb-0">Slack</h5>
                                            <p class="font-size-sm mb-0">Communication <a class="link" href="#">Learn more</a></p>
                                        </div>

                                        <div class="col-auto">
                                            <!-- Checkbox Switch -->
                                            <label class="toggle-switch" for="connectedAccounts3">
                                                <input id="connectedAccounts3" type="checkbox" class="toggle-switch-input" checked="">
                                                <span class="toggle-switch-label">
                                  <span class="toggle-switch-indicator"></span>
                                </span>
                                            </label>
                                            <!-- End Checkbox Switch -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End List Item -->

                        <!-- List Item -->
                        <div class="list-group-item">
                            <div class="media">
{{--                                <img class="avatar avatar-xs mt-1 mr-3" src="./assets/svg/brands/mailchimp.svg" alt="Image Description">--}}

                                <div class="media-body">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <h5 class="mb-0">Mailchimp</h5>
                                            <p class="font-size-sm mb-0">Email marketing service</p>
                                        </div>

                                        <div class="col-auto">
                                            <!-- Checkbox Switch -->
                                            <label class="toggle-switch" for="connectedAccounts4">
                                                <input id="connectedAccounts4" type="checkbox" class="toggle-switch-input" checked="">
                                                <span class="toggle-switch-label">
                                  <span class="toggle-switch-indicator"></span>
                                </span>
                                            </label>
                                            <!-- End Checkbox Switch -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End List Item -->

                        <!-- List Item -->
                        <div class="list-group-item">
                            <div class="media">
{{--                                <img class="avatar avatar-xs mt-1 mr-3" src="./assets/svg/brands/google-webdev.svg" alt="Image Description">--}}

                                <div class="media-body">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <h5 class="mb-0">Google Webdev</h5>
                                            <p class="font-size-sm mb-0">Tools for Web Developers <a class="link" href="#">Learn more</a></p>
                                        </div>

                                        <div class="col-auto">
                                            <!-- Checkbox Switch -->
                                            <label class="toggle-switch" for="connectedAccounts5">
                                                <input id="connectedAccounts5" type="checkbox" class="toggle-switch-input">
                                                <span class="toggle-switch-label">
                                  <span class="toggle-switch-indicator"></span>
                                </span>
                                            </label>
                                            <!-- End Checkbox Switch -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End List Item -->
                    </div>
                </form>
                <!-- End Form -->
            </div>
            <!-- End Body -->
        </div>
        <!-- END Connected accounts -->

    </div>
</div>
