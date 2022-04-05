@push('head_scripts')
<link href="https://cdn.jsdelivr.net/npm/froala-editor@latest/css/froala_editor.pkgd.min.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/froala-editor@latest/js/froala_editor.pkgd.min.js"></script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.11/themes/airbnb.min.css">
{{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css"> --}}
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
@endpush

<div class="w-full" x-data="{
        current: 'basicInformation',
        thumbnail: @js(['id' => $me->thumbnail->id ?? null, 'file_name' => $me->thumbnail->file_name ?? '']),
        cover: @js(['id' => $me->cover->id ?? null, 'file_name' => $me->cover->file_name ?? '']),
        meta: @js($meta),
    }" x-init="$watch('current', function(value) {
        $([document.documentElement, document.body]).animate({
            scrollTop: $('#'+value).offset().top - $('#topbar').outerHeight() - 20
        }, 500);
    })" @validation-errors.window="$scrollToErrors($event.detail.errors, 700);" x-cloak>
    <div class="w-full relative">
        <x-ev.loaders.spinner class="absolute-center z-10 hidden" wire:loading.class.remove="hidden">
        </x-ev.loaders.spinner>

        <div class="w-full" wire:loading.class="opacity-30 pointer-events-none">

            <div class="grid grid-cols-12 gap-8 mb-10">
                @if(!$onboarding)
                <div class="col-span-12 lg:col-span-3">

                    <nav class="space-y-1 p-4 bg-white rounded-lg border border-gray-200">
                        <a href="#"
                            :class="{'text-primary': current === 'basicInformation', 'text-gray-500 hover:bg-gray-50 hover:text-gray-900': current !== 'basicInformation'}"
                            class="flex items-center px-3 py-2 text-sm font-medium rounded-md"
                            @click="current = 'basicInformation'">

                            @svg('heroicon-o-user', ['class' => 'flex-shrink-0 -ml-1 mr-3 h-6 w-6'])
                            <span class="truncate">{{ translate('Basic information') }}</span>
                        </a>

                        <a href="#"
                            :class="{'text-primary': current === 'passwordSection', 'text-gray-500 hover:bg-gray-50 hover:text-gray-900': current !== 'passwordSection'}"
                            class="flex items-center px-3 py-2 text-sm font-medium rounded-md"
                            @click="current = 'passwordSection'">

                            @svg('heroicon-o-lock-closed', ['class' => 'flex-shrink-0 -ml-1 mr-3 h-6 w-6'])
                            <span class="truncate">{{ translate('Password') }}</span>
                        </a>

                        <a href="#"
                            :class="{'text-primary': current === 'addressesSection', 'text-gray-500 hover:bg-gray-50 hover:text-gray-900': current !== 'addressesSection'}"
                            class="flex items-center px-3 py-2 text-sm font-medium rounded-md"
                            @click="current = 'addressesSection'">

                            @svg('heroicon-o-location-marker', ['class' => 'flex-shrink-0 -ml-1 mr-3 h-6 w-6'])
                            <span class="truncate">{{ translate('Addresses') }}</span>
                        </a>

                        <a href="#"
                            :class="{'text-primary': current === 'socialAccountsSection', 'text-gray-500 hover:bg-gray-50 hover:text-gray-900': current !== 'socialAccountsSection'}"
                            class="flex items-center px-3 py-2 text-sm font-medium rounded-md"
                            @click="current = 'socialAccountsSection'">

                            @svg('heroicon-o-share', ['class' => 'flex-shrink-0 -ml-1 mr-3 h-6 w-6'])
                            <span class="truncate">{{ translate('Social accounts') }}</span>
                        </a>

                        {{-- <a href="#"
                            :class="{'text-primary': current === 'socialAccountsSection', 'text-gray-500 hover:bg-gray-50 hover:text-gray-900': current !== 'socialAccountsSection'}"
                            class="flex items-center px-3 py-2 text-sm font-medium rounded-md"
                            @click="current = 'socialAccountsSection'">

                            @svg('heroicon-o-share', ['class' => 'flex-shrink-0 -ml-1 mr-3 h-6 w-6'])
                            <span class="truncate">{{ translate('Connected accounts') }}</span>
                        </a> --}}

                    </nav>

                </div>
                @endif

                @php
                    $form_container_class = 'lg:col-span-9';
                    if($onboarding) {
                        $form_container_class = 'lg:col-span-12';
                    }
                @endphp
                <div class="col-span-12 {{ $form_container_class }}">
                    {{-- Account Media --}}
                    <div class="p-0 border bg-white border-gray-200 rounded-lg shadow">
                        <div class="w-full border-b border-gray-200">
                            <x-dashboard.form.image-selector field="cover" template="cover" id="my-account-cover-image"
                                error-field="me.cover" :selected-image="$me->cover"></x-dashboard.form.image-selector>
                        </div>

                        <div class="w-full pt-3 pb-5 pr-4 pl-[140px] relative">
                            <div class="bg-white rounded-lg absolute left-6 bottom-6 border border-gray-200">
                                <x-dashboard.form.image-selector field="thumbnail" template="avatar"
                                    id="my-account-thumbnail-image" error-field="me.thumbnail"
                                    :selected-image="$me->thumbnail"></x-dashboard.form.image-selector>
                            </div>

                            <div class="w-full flex flex-col">
                                <strong class="block text-gray-700">{{ $me->name .' '.$me->surname }}</strong>
                                <span class="text-gray-500">{{ $me->email }}</span>
                            </div>
                        </div>

                        {{-- TODO: Save media change! --}}
                    </div>
                    {{-- END Account Media --}}

                    {{-- Basic Information --}}
                    <div id="basicInformation" class="p-4 border bg-white border-gray-200 rounded-lg shadow mt-5">
                        <div>
                            <h3 class="text-lg leading-6 font-medium text-gray-900">{{ translate('Basic Information') }}
                            </h3>
                            {{-- <p class="mt-1 max-w-2xl text-sm text-gray-500">This information will be displayed
                                publicly so be careful what you share.</p> --}}
                        </div>

                        <div class="mt-6 sm:mt-5 space-y-6 sm:space-y-5">
                            <!-- First name -->
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5"
                                x-data="{}">

                                <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                    {{ translate('First name') }}
                                    <span class="text-danger relative top-[-2px]">*</span>
                                </label>

                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                    <input type="text" class="form-standard @error('me.name') is-invalid @enderror"
                                        placeholder="{{ translate('My first name') }}" wire:model.defer="me.name" />

                                    <x-system.invalid-msg field="me.name"></x-system.invalid-msg>
                                </div>
                            </div>
                            <!-- END First name -->

                            <!-- Last name -->
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5"
                                x-data="{}">
                                <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                    {{ translate('Last name') }}
                                    <span class="text-danger relative top-[-2px]">*</span>
                                </label>

                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                    <input type="text" class="form-standard @error('me.surname') is-invalid @enderror"
                                        placeholder="{{ translate('My last name') }}" wire:model.defer="me.surname" />

                                    <x-system.invalid-msg field="me.surname"></x-system.invalid-msg>
                                </div>
                            </div>
                            <!-- END Last name -->

                            <!-- Headline -->
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5"
                                x-data="{}">

                                <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                    {{ translate('Headline') }}
                                    <span class="text-danger relative top-[-2px]">*</span>
                                </label>

                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                    <input type="text" class="form-standard @error('meta.headline.value') is-invalid @enderror"
                                        placeholder="{{ translate('My unique headline') }}" wire:model.defer="meta.headline.value" />

                                    <x-system.invalid-msg field="meta.headline.value"></x-system.invalid-msg>
                                </div>
                            </div>
                            <!-- END Headline -->

                            <!-- Email -->
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5"
                                x-data="{}">

                                <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                    {{ translate('Email') }}
                                    {{-- <span class="text-danger relative top-[-2px]">*</span> --}}
                                </label>

                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                    <input disabled type="email" class="opacity-50 form-standard @error('me.email') is-invalid @enderror"
                                        placeholder="{{ translate('My Email') }}" wire:model.defer="me.email" />

                                    <x-system.invalid-msg field="me.email"></x-system.invalid-msg>
                                </div>
                            </div>
                            <!-- END Email -->

                            <!-- Phone -->
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5"
                                x-data="{}">

                                <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                    {{ translate('Phone') }}
                                </label>

                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                    <input type="text" class="form-standard @error('me.phone') is-invalid @enderror"
                                        placeholder="{{ translate('My mobile phone') }}" wire:model.defer="me.phone" />

                                    <x-system.invalid-msg field="me.phone"></x-system.invalid-msg>
                                </div>
                            </div>
                            <!-- END Phone -->

                            @if(!$onboarding)
                            <!-- Birthday -->
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5"
                                x-data="{
                                    getDateOptions() {
                                        return {
                                            mode: 'single',
                                            enableTime: false,
                                            dateFormat: 'd.m.Y.',
                                        };
                                    },
                                }" x-init="$nextTick(() => { flatpickr('#user-meta-birthday-input', getDateOptions()); });">

                                <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                    {{ translate('Birthday') }}
                                </label>

                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                    <input x-model="meta.birthday.value"
                                                        type="text"
                                                        id="user-meta-birthday-input"
                                                        class="js-flatpickr flatpickr-custom form-standard @error('meta.birthday') is-invalid @enderror"
                                                        placeholder="{{ translate('Pick a date(s)') }}"
                                                        data-input />
                                    <x-system.invalid-msg field="meta.birthday.value"></x-system.invalid-msg>
                                </div>
                            </div>
                            <!-- END Birthday -->

                            <!-- Gender -->
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5"
                                x-data="{}">

                                <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                    {{ translate('Gender') }}
                                    <span class="text-danger relative top-[-2px]">*</span>
                                </label>

                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                    <x-dashboard.form.select :items="['male' => 'Male', 'female' => 'Female', 'other' => 'Other']" selected="meta.gender.value" :nullable="false"></x-dashboard.form.select>

                                    <x-system.invalid-msg field="meta.gender.value"></x-system.invalid-msg>
                                </div>
                            </div>
                            <!-- END Gender -->
                            @endif
                            

                            {{-- <!-- Industry -->
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5"
                                x-data="{}">

                                <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                    {{ translate('Industry') }}
                                    <span class="text-danger relative top-[-2px]">*</span>
                                </label>

                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                    <x-dashboard.form.select :items="\Categories::getAll(true)->keyBy('id')->map(fn($item) => $item->name)->toArray()" selected="meta.industry.value.id"></x-dashboard.form.select>

                                    <x-system.invalid-msg field="meta.industry.value"></x-system.invalid-msg>
                                </div>
                            </div>
                            <!-- END Industry --> --}}

                            <!-- Bio -->
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5" x-data="{}" wire:ignore>

                                <label class="col-span-3 block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                    {{ translate('Bio') }}
                                    <span class="text-danger relative top-[-2px]">*</span>
                                </label>
                
                                <div class="mt-1 sm:mt-0 sm:col-span-3">
                                    <x-dashboard.form.froala field="meta.bio.value" id="user-bio-wysiwyg"></x-dashboard.form.froala>
                                    <x-system.invalid-msg class="w-full" field="meta.bio.value"></x-system.invalid-msg>
                                </div>
                            </div>
                            <!-- END Bio -->

                            {{-- Save basic information --}}
                            <div class="flex sm:items-start sm:border-t sm:border-gray-200 sm:pt-5" x-data="{}">
                                <button type="button" class="btn btn-primary ml-auto btn-sm" @click="
                                    $wire.set('me.thumbnail', thumbnail.id, true);
                                    $wire.set('me.cover', cover.id, true);
                                    $wire.set('meta.bio.value', meta.bio.value, true);
                                    {{-- $wire.set('meta.industry.value', meta.industry.value.id, true); --}}
                                    $wire.set('meta.birthday.value', meta.birthday.value, true);
                                " wire:click="saveBasicInformation()">
                                    {{ translate('Save') }}
                                </button>
                            </div>
                            {{-- END Save basic information --}}

                        </div>
                    </div>
                    {{-- END Basic Information --}}

                    @if(!$onboarding)
                    {{-- Change password --}}
                    <div id="passwordSection" class="p-4 border bg-white border-gray-200 rounded-lg shadow mt-5" x-data="{
                        currentPassword: '',
                        newPassword: '',
                        newPassword_confirmation: '',
                        reset() {
                            this.currentPassword = '';
                            this.newPassword = '';
                            this.newPassword_confirmation = '';
                        }
                    }" @init-form.window="reset()">
                        <div>
                            <h3 class="text-lg leading-6 font-medium text-gray-900">{{ translate('Change password') }}
                            </h3>
                            {{-- <p class="mt-1 max-w-2xl text-sm text-gray-500">This information will be displayed
                                publicly so be careful what you share.</p> --}}
                        </div>

                        <div class="mt-6 sm:mt-5 space-y-6 sm:space-y-5">
                            <!-- Current password -->
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5"
                                x-data="{}">

                                <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                    {{ translate('Current password') }}
                                </label>

                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                    <input type="password"
                                        class="form-standard @error('currentPassword') is-invalid @enderror"
                                        placeholder="{{ translate('Enter current password') }}"
                                        x-model="currentPassword" />

                                    <x-system.invalid-msg field="currentPassword"></x-system.invalid-msg>
                                </div>
                            </div>
                            <!-- END Current password -->

                            <!-- New password -->
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5"
                                x-data="{}">

                                <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                    {{ translate('New password') }}
                                </label>

                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                    <input type="password"
                                        class="form-standard @error('newPassword') is-invalid @enderror"
                                        placeholder="{{ translate('Enter New password') }}" x-model="newPassword" />

                                    <x-system.invalid-msg field="newPassword"></x-system.invalid-msg>
                                </div>
                            </div>
                            <!-- END New password -->

                            <!-- New password confirmation-->
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:pt-0" x-data="{}">

                                <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                    {{ translate('Confirm new password') }}
                                </label>

                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                    <input type="password" class="form-standard "
                                        placeholder="{{ translate('Confirm new password') }}"
                                        x-model="newPassword_confirmation" />
                                </div>

                                <div></div>
                                <div class="w-full sm:col-span-2">
                                    <h5 class="mb-2">{{ translate('Password requirements:') }}</h5>

                                    <ul class="text-14 text-gray-700 marker:text-sky-400 list-disc pl-4">
                                        <li>{{ translate('Minimum 8 characters long - the more, the better') }}</li>
                                        <li>{{ translate('At least one lowercase character') }}</li>
                                        <li>{{ translate('At least one uppercase character') }}</li>
                                        <li>{{ translate('At least one number') }}</li>
                                    </ul>
                                </div>
                            </div>
                            <!-- END New password confirmation -->

                            {{-- Save Change password --}}
                            <div class="flex sm:items-start sm:border-t sm:border-gray-200 sm:pt-5" x-data="{}">
                                <button type="button" class="btn btn-primary ml-auto btn-sm" @click="
                                    $wire.set('currentPassword', currentPassword, true);
                                    $wire.set('newPassword', newPassword, true);
                                    $wire.set('newPassword_confirmation', newPassword_confirmation, true);
                                " wire:click="updatePassword()">
                                    {{ translate('Save') }}
                                </button>
                            </div>
                            {{-- END Change password --}}

                        </div>
                    </div>
                    @endif
                    {{-- END Change password --}}

                    {{-- @if(!$onboarding) --}}
                    <!-- Addresses -->
                    <livewire:dashboard.forms.addresses.addresses-form component-id="addressesSection"
                        :addresses="$this->me->addresses" type="address">
                    </livewire:dashboard.forms.addresses.addresses-form>
                    {{-- @endif --}}
                    <!-- END Addresses -->
                    

                    @if(!$onboarding)
                    <!-- Social accounts -->
                    <div id="socialAccountsSection" class="hidden p-4 border bg-white border-gray-200 rounded-lg shadow mt-5"
                        x-data="{}">
                        <div class="w-full items-center border-b border-gray-200 pb-3">
                            <h3 class="text-lg leading-6 font-medium text-gray-900 mb-1">{{ translate('Social accounts')
                                }}</h3>
                            <p class="flex items-center-1 max-w-2xl text-sm text-gray-500"> {{ translate('Connect social
                                accounts to your current account') }}</p>
                        </div>

                        <div class="space-y-6 sm:space-y-5 pb-2">
                            <!-- List Item -->
                            @if(!empty(\App\Models\SocialAccount::$available_providers))
                            <ul class="mt-2 divide-y divide-gray-200">
                                @foreach(\App\Models\SocialAccount::$available_providers as $key => $provider)
                                @php
                                $social_account = $me->getSocialAccount($key);
                                @endphp
                                <li class="py-4 flex items-center justify-between">
                                    <div class="flex flex-col">
                                        <p class="text-sm font-medium text-gray-900">
                                            {{ $provider }}
                                            @if($social_account->connected ?? null)
                                            <span class="badge-success text-12 ml-2">{{ translate('active') }}</span>
                                            @else
                                            <span class="badge-danger text-12 ml-2">{{ translate('inactive') }}</span>
                                            @endif
                                        </p>
                                        <p class="text-sm text-gray-500">Nulla amet tempus sit accumsan. Aliquet turpis
                                            sed sit lacinia.</p>
                                    </div>

                                    <a class="btn-{{ ($social_account->connected ?? null) ? 'danger':'success' }}"
                                        href="{{ ($social_account->connected ?? null) ? '#' : route('social.connect', $key) }}"
                                        target="_blank">
                                        {{ ($social_account->connected ?? null) ? translate('Disconnect') :
                                        translate('Connect') }}
                                    </a>

                                    <!-- Enabled: "bg-teal-500", Not Enabled: "bg-gray-200" -->
                                    {{-- <button type="button"
                                        class="bg-gray-200 ml-4 relative inline-flex flex-shrink-0 h-6 w-11 border-2 border-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sky-500"
                                        role="switch" aria-checked="true" aria-labelledby="privacy-option-1-label"
                                        aria-describedby="privacy-option-1-description">
                                        <!-- Enabled: "translate-x-5", Not Enabled: "translate-x-0" -->
                                        <span aria-hidden="true"
                                            class="translate-x-0 inline-block h-5 w-5 rounded-full bg-white shadow transform ring-0 transition ease-in-out duration-200"></span>
                                    </button> --}}
                                </li>
                                @endforeach
                            </ul>
                            @endif
                        </div>
                    </div>

                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
