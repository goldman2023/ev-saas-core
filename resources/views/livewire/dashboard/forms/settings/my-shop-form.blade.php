<div class="my-account-form lw-form row"
     x-data="{
            current: 'basicInformation',
            shop: @entangle('shop').defer,
            settings: @entangle('settings').defer,
            addresses: @entangle('addresses').defer,
            domains: @entangle('domains').defer,
            showToast($el, $event) {
                if($($el).attr('id') === $event.detail.id) {

                    $($el).find('.toast-body').text($event.detail.content);
                    $($el).addClass('d-block opacity-10');
                    setTimeout(function() {
                        $($el).removeClass('d-block opacity-10');
                    }, 4000);
                }
            },
        }"
        x-init="$watch('current', function(value) {
            $([document.documentElement, document.body]).animate({
                scrollTop: $('#'+value).offset().top - $('#header').outerHeight()
            }, 500);
        })">

    <x-ev.toast id="my-shop-updated-toast"
                position="bottom-center"
                content="{{ translate('My shop successfully updated!') }}"
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
                    <li class="nav-item w-100">
                        <a class="nav-link py-3 pointer"
                           :class="{'active': current === 'contactDetailsSection'}"
                           @click="current = 'contactDetailsSection';" >
                            <i class="tio-mobile-outlined nav-icon"></i> {{ translate('Contact details') }}
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
                           :class="{'active': current === 'addressesSection'}"
                           @click="current = 'addressesSection';" >
                            <i class="tio-world-outlined nav-icon"></i> {{ translate('Domains') }}
                        </a>
                    </li>
                </ul>
                <!-- End Navbar Nav -->
            </div>
        </div>
        <!-- End Navbar -->
    </div>

    <div class="col-lg-9">
        <!-- BasicInformation Card -->
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
                            name: 'shop.cover',
                            imageID: {{ $shop->cover->id ?? 'null' }},
                            imageURL: '{{ $shop->getCover(['w'=>1200]) }}',
                        }"
                         @aiz-selected.window="
                             if(event.detail.name === name) {
                                imageURL = event.detail.imageURL;
                                $($el).find('.selected-files').get(0).dispatchEvent(new Event('input'));
                             }"
                         data-toggle="aizuploader"
                         data-type="image">

                        <img id="profileCoverImg" class="profile-cover-img" x-bind:src="imageURL">


                        <!-- Custom File Cover -->
                        <div class="profile-cover-content profile-cover-btn custom-file-manager"
                             data-toggle="aizuploader" data-type="image">
                            <div class="custom-file-btn">
                                <input type="hidden" x-bind:name="name" x-model="shop.cover" class="selected-files" data-preview-width="1200">

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
                            name: 'shop.thumbnail',
                            imageID: {{ $shop->thumbnail->id ?? 'null' }},
                            imageURL: '{{ $shop->getThumbnail() }}',
                        }"
                       @aiz-selected.window="
                         if(event.detail.name === name) {
                            imageURL = event.detail.imageURL;
                            $($el).find('.selected-files').get(0).dispatchEvent(new Event('input'));
                         }"
                       data-toggle="aizuploader"
                       data-type="image">
                    <img id="avatarImg" class="avatar-img" x-bind:src="imageURL" >

                    <input type="hidden" x-bind:name="name" x-model="shop.thumbnail" class="selected-files" data-preview-width="200">

                    <span class="avatar-uploader-trigger">
                  <i class="tio-edit avatar-uploader-icon shadow-soft"></i>
                </span>
                </label>
                <!-- End Avatar -->

                <div class="card-body">

                    @if ($errors->has('shop.thumbnail') || $errors->has('shop.cover'))
                        <div class="mb-5">
                            @error('shop.thumbnail')
                            <div class="row form-group mb-1">
                                <div class="invalid-feedback d-block mx-3 py-2 rounded bg-danger text-white px-3">{{ $message }}</div>
                            </div>
                            @enderror

                            @error('shop.cover')
                            <div class="row form-group mb-1">
                                <div class="invalid-feedback d-block mx-3 py-2 rounded bg-danger text-white px-3">{{ $message }}</div>
                            </div>
                            @enderror
                        </div>
                    @endif


                    <!-- Shop Title -->
                    <div class="row form-group">
                        <label for="shop-name" class="col-sm-3 col-form-label input-label">{{ translate('Title') }}</label>

                        <div class="col-sm-9">
                            <div class="input-group input-group-sm-down-break">
                                <input type="text" class="form-control @error('shop.name') is-invalid @enderror" name="shop.name" id="shop-name" placeholder="{{ translate('Your full name') }}"
                                       x-model="shop.name">
                            </div>

                            @error('shop.name')
                            <div class="invalid-feedback d-block  py-2 rounded">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Shop Tagline/motto -->
                    <div class="row form-group">
                        <label for="shop-name" class="col-sm-3 col-form-label input-label">{{ translate('Tagline/Motto') }}</label>

                        <div class="col-sm-9">
                            <div class="input-group input-group-sm-down-break">
                                <input type="text" class="form-control @error('settings.shop_tagline') is-invalid @enderror" name="settings.shop_tagline" id="settings-shop_tagline" placeholder="{{ translate('Your cool tagline!') }}"
                                       x-model="settings.shop_tagline"/>
                            </div>

                            @error('settings.shop_tagline')
                            <div class="invalid-feedback d-block  py-2 rounded">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Shop Email -->
                    <div class="row form-group">
                        <label for="shop-email" class="col-sm-3 col-form-label input-label">{{ translate('Email (@)') }}</label>

                        <div class="col-sm-9">
                            <div class="input-group input-group-sm-down-break">
                                <input type="email" class="form-control @error('settings.company_email') is-invalid @enderror" name="settings.company_email" id="settings-company_email" placeholder="{{ translate('Company email') }}"
                                       x-model="settings.company_email"/>
                            </div>

                            @error('settings.company_email')
                            <div class="invalid-feedback d-block  py-2 rounded">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Company phones-->
                    <div class="row form-group" x-data="{
                        phones_limit: 3,
                        addNewPhoneNumber() {
                            if(settings.company_phones.length < 3)
                                settings.company_phones.push('');
                        },
                        removePhoneNumber(index) {
                            settings.company_phones.splice(index, 1);
                        },
                    }">
                        <label for="shop-phone" class="col-sm-3 col-form-label input-label">{{ translate('Phones') }}</label>

                        <div class="col-sm-9">
                            <template x-if="settings.company_phones.length <= 1">
                                <div class="d-flex">
                                    <input type="text" class="form-control" name="phoneNumberField"
                                           placeholder="{{ translate('Phone number 1') }}"
                                           x-model="settings.company_phones[0]">
                                </div>
                            </template>
                            <template x-if="settings.company_phones.length > 1">
                                <template x-for="[key, value] of Object.entries(settings.company_phones)">
                                    <div class="d-flex" :class="{'mt-2': key > 0}">
                                        <input type="text" class="form-control" name="phoneNumberField"
                                               x-bind:placeholder="'{{ translate('Phone number') }} '+(Number(key)+1)"
                                               x-model="settings.company_phones[key]">
                                        <template x-if="key > 0">
                                                <span class="ml-2 d-flex align-items-center pointer" @click="removePhoneNumber(key)">
                                                    @svg('heroicon-o-trash', ['class' => 'square-22 text-danger'])
                                                </span>
                                        </template>
                                    </div>
                                </template>
                            </template>

                            <template x-if="settings.company_phones.length < phones_limit">
                                <a href="javascript:;"
                                   class="js-create-field form-link btn btn-xs btn-no-focus btn-ghost-primary"
                                   @click="addNewPhoneNumber()">
                                    <i class="tio-add"></i> {{ translate('Add phone') }}
                                </a>
                            </template>

                            @error('settings.company_phones')
                            <div class="invalid-feedback d-block  py-2 rounded">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Company Websites -->
                    <div class="row form-group" x-data="{
                        limit: 3,
                        addNew() {
                            if(settings.websites.length < 3)
                                settings.websites.push('');
                        },
                        remove(index) {
                            settings.websites.splice(index, 1);
                        },
                    }">
                        <label for="shop-phone" class="col-sm-3 col-form-label input-label">{{ translate('Websites') }}</label>

                        <div class="col-sm-9">
                            <template x-if="settings.websites.length <= 1">
                                <div class="d-flex">
                                    <input type="text" class="form-control" name="phoneNumberField"
                                           placeholder="{{ translate('Website 1') }}"
                                           x-model="settings.websites[0]">
                                </div>
                            </template>
                            <template x-if="settings.websites.length > 1">
                                <template x-for="[key, value] of Object.entries(settings.websites)">
                                    <div class="d-flex" :class="{'mt-2': key > 0}">
                                        <input type="text" class="form-control" name="phoneNumberField"
                                               x-bind:placeholder="'{{ translate('Website') }} '+(Number(key)+1)"
                                               x-model="settings.websites[key]">
                                        <template x-if="key > 0">
                                                <span class="ml-2 d-flex align-items-center pointer" @click="remove(key)">
                                                    @svg('heroicon-o-trash', ['class' => 'square-22 text-danger'])
                                                </span>
                                        </template>
                                    </div>
                                </template>
                            </template>

                            <template x-if="settings.websites.length < limit">
                                <a href="javascript:;"
                                   class="js-create-field form-link btn btn-xs btn-no-focus btn-ghost-primary"
                                   @click="addNew()">
                                    <i class="tio-add"></i> {{ translate('Add website') }}
                                </a>
                            </template>

                            @error('settings.websites')
                            <div class="invalid-feedback d-block  py-2 rounded">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>


                    <div class="row form-group">
                        <label for="shop-excerpt" class="col-sm-3 col-form-label input-label">{{ translate('Short description') }}</label>

                        <div class="col-sm-9">
                            <div class="input-group input-group-sm-down-break">
                                <textarea
                                    class="form-control @error('shop.excerpt') is-invalid @enderror"
                                    name="shop.excerpt"
                                    id="shop-excerpt"
                                    placeholder="{{ translate('Short promo description') }}"
                                    x-model="shop.excerpt"></textarea>
                            </div>

                            @error('shop.excerpt')
                            <div class="invalid-feedback d-block  py-2 rounded">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>


                    <div class="row form-group">
                        <label class="col-sm-12 col-form-label input-label">{{ translate('Content') }}</label>

                        <!-- ToastUI Editor -->
                        <div class="col-sm-12 mt-2">
                            <div class="toast-ui-editor-custom input-group input-group-sm-down-break">
                                <div class="js-toast-ui-editor w-100 @error('shop.content') is-invalid @enderror"></div>

                                <input type="text"
                                       x-model="shop.content"
                                       data-textarea
                                       name="shop.content"
                                       class="d-none"
                                />
                            </div>

                            @error('shop.content')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        <!-- End ToastUI Editor -->
                    </div>
                </div>

                <div class="card-footer">
                    <div class="col-12 d-flex">
                        <button type="button" class="btn btn-primary ml-auto btn-sm" @click="$wire.saveBasicInformation()">
                            {{ translate('Save') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- END BasicInformation -->


        <!-- ContactDetails Card -->
        @include('frontend.dashboard.settings.partials.shop-settings.contact-details')
        <!-- END ContactDetails Card -->

        <!-- Addresses -->
        <livewire:dashboard.forms.addresses.addresses-form :addresses="$shop->addresses" toast_id="my-shop-updated-toast">
        </livewire:dashboard.forms.addresses.addresses-form>
        <!-- END Addresses -->
    </div>
</div>
