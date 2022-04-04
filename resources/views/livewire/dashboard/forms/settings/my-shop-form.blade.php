@push('head_scripts')
<link href="https://cdn.jsdelivr.net/npm/froala-editor@latest/css/froala_editor.pkgd.min.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/froala-editor@latest/js/froala_editor.pkgd.min.js"></script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.11/themes/airbnb.min.css">
{{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css"> --}}
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
@endpush
<div class="w-full" x-data="{
        current: 'basicInformation',
        thumbnail: @js(['id' => $shop->thumbnail->id ?? null, 'file_name' => $shop->thumbnail->file_name ?? '']),
        cover: @js(['id' => $shop->cover->id ?? null, 'file_name' => $shop->cover->file_name ?? '']),
        meta_img: @js(['id' => $shop->meta_img->id ?? null, 'file_name' => $shop->meta_img->file_name ?? '']),
        content: @js($shop->content ?? ''),
        settings: @entangle('settings').defer,
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
                            :class="{'text-primary': current === 'companyInfoSection', 'text-gray-500 hover:bg-gray-50 hover:text-gray-900': current !== 'companyInfoSection'}"
                            class="flex items-center px-3 py-2 text-sm font-medium rounded-md"
                            @click="current = 'companyInfoSection'">

                            @svg('heroicon-o-office-building', ['class' => 'flex-shrink-0 -ml-1 mr-3 h-6 w-6'])
                            <span class="truncate">{{ translate('Company information') }}</span>
                        </a>

                        <a href="#"
                            :class="{'text-primary': current === 'contactDetails', 'text-gray-500 hover:bg-gray-50 hover:text-gray-900': current !== 'contactDetails'}"
                            class="flex items-center px-3 py-2 text-sm font-medium rounded-md"
                            @click="current = 'contactDetails'">

                            @svg('heroicon-o-phone', ['class' => 'flex-shrink-0 -ml-1 mr-3 h-6 w-6'])
                            <span class="truncate">{{ translate('Contact details') }}</span>
                        </a>

                        <a href="#"
                            :class="{'text-primary': current === 'addressesSection', 'text-gray-500 hover:bg-gray-50 hover:text-gray-900': current !== 'addressesSection'}"
                            class="flex items-center px-3 py-2 text-sm font-medium rounded-md"
                            @click="current = 'addressesSection'">

                            @svg('heroicon-o-location-marker', ['class' => 'flex-shrink-0 -ml-1 mr-3 h-6 w-6'])
                            <span class="truncate">{{ translate('Addresses') }}</span>
                        </a>

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
                    {{-- Shop Media --}}
                    <div class="p-0 border bg-white border-gray-200 rounded-lg shadow">
                        <div class="w-full border-b border-gray-200">
                            <x-dashboard.form.image-selector field="cover" template="cover" id="my-shop-cover-image"
                                error-field="shop.cover" :selected-image="$shop->cover">
                            </x-dashboard.form.image-selector>
                        </div>

                        <div class="w-full pt-3 pb-5 pr-4 pl-[140px] relative">
                            <div class="bg-white rounded-lg absolute left-6 bottom-6 border border-gray-200">
                                <x-dashboard.form.image-selector field="thumbnail" template="avatar"
                                    id="my-shop-thumbnail-image" error-field="shop.thumbnail"
                                    :selected-image="$shop->thumbnail"></x-dashboard.form.image-selector>
                            </div>

                            <div class="w-full flex flex-col">
                                <strong class="block text-gray-700">{{ $shop->name }}</strong>
                                <span class="text-gray-500 truncate max-w-lg">{{ $shop->excerpt }}</span>
                            </div>
                        </div>

                        {{-- TODO: Save media change! --}}
                    </div>
                    {{-- END Shop Media --}}

                    {{-- Basic Information --}}
                    <div id="basicInformation" class="p-4 border bg-white border-gray-200 rounded-lg shadow mt-5">
                        <div>
                            <h3 class="text-lg leading-6 font-medium text-gray-900">{{ translate('Basic Information') }}
                            </h3>
                            {{-- <p class="mt-1 max-w-2xl text-sm text-gray-500">This information will be displayed
                                publicly so be careful what you share.</p> --}}
                        </div>

                        <div class="mt-6 sm:mt-5 space-y-6 sm:space-y-5">
                            <!-- Title -->
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5"
                                x-data="{}">
                                <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                    {{ translate('Title') }}
                                    <span class="text-danger relative top-[-2px]">*</span>
                                </label>

                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                    <input type="text" class="form-standard @error('shop.name') is-invalid @enderror"
                                        placeholder="{{ translate('My shop name') }}" wire:model.defer="shop.name" />

                                    <x-system.invalid-msg field="shop.name"></x-system.invalid-msg>
                                </div>
                            </div>
                            <!-- END Title -->

                            <!-- Tagline -->
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5"
                                x-data="{}">

                                <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                    {{ translate('Tagline') }}
                                </label>

                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                    <input type="text"
                                        class="form-standard @error('settings.tagline') is-invalid @enderror"
                                        placeholder="{{ translate('My shop tagline/motto/catchphrase') }}"
                                        wire:model.defer="settings.tagline" />

                                    <x-system.invalid-msg field="settings.tagline"></x-system.invalid-msg>
                                </div>
                            </div>
                            <!-- END Tagline -->

                            <!-- Email -->
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5"
                                x-data="{}">

                                <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                    {{ translate('Email') }}
                                    <span class="text-danger relative top-[-2px]">*</span>
                                </label>

                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                    <input type="email"
                                        class="form-standard @error('settings.email') is-invalid @enderror"
                                        placeholder="{{ translate('My shop email') }}"
                                        wire:model.defer="settings.email" />

                                    <x-system.invalid-msg field="settings.email"></x-system.invalid-msg>
                                </div>
                            </div>
                            <!-- END Email -->

                            {{-- Phones --}}
                            <div
                                class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                                <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                    {{ translate('Phones') }}
                                    <span class="text-danger relative top-[-2px]">*</span>
                                </label>

                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                    <x-dashboard.form.text-repeater field="settings.phones" limit="3"
                                        placeholder="{{ translate('Phone') }}"></x-dashboard.form.text-repeater>
                                    {{-- <x-system.invalid-msg field="settings.phones"></x-system.invalid-msg> --}}
                                </div>
                            </div>
                            {{-- END Phones --}}

                            {{-- Websites --}}
                            <div
                                class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                                <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                    {{ translate('Websites') }}
                                </label>

                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                    <x-dashboard.form.text-repeater field="settings.websites" limit="3"
                                        placeholder="{{ translate('Website') }}"></x-dashboard.form.text-repeater>
                                    {{-- <x-system.invalid-msg field="settings.websites"></x-system.invalid-msg> --}}
                                </div>
                            </div>
                            {{-- END Websites --}}

                            <!-- Excerpt -->
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5"
                                x-data="{}">

                                <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                    {{ translate('Excerpt') }}
                                </label>

                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                    <textarea type="text"
                                        class="form-standard h-[80px] @error('shop.excerpt') is-invalid @enderror"
                                        placeholder="{{ translate('Write a short promo description for your shop') }}"
                                        wire:model.defer="shop.excerpt">
                                </textarea>

                                    <x-system.invalid-msg class="w-full" field="shop.excerpt"></x-system.invalid-msg>
                                </div>
                            </div>
                            <!-- END Excerpt -->

                            <!-- Content -->
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5"
                                x-data="{}" wire:ignore>

                                <label class="col-span-3 block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                    {{ translate('Content') }}
                                </label>

                                <div class="mt-1 sm:mt-0 sm:col-span-3">
                                    <x-dashboard.form.froala field="content" id="shop-content-wysiwyg">
                                    </x-dashboard.form.froala>

                                    <x-system.invalid-msg class="w-full" field="shop.content"></x-system.invalid-msg>
                                </div>
                            </div>
                            <!-- END Content -->

                            {{-- Save basic information --}}
                            <div class="flex sm:items-start sm:border-t sm:border-gray-200 sm:pt-5" x-data="{}">
                                <button type="button" class="btn btn-primary ml-auto btn-sm" @click="
                                    $wire.set('shop.thumbnail', thumbnail.id, true);
                                    $wire.set('shop.cover', cover.id, true);
                                    $wire.set('settings.websites', settings.websites, true);
                                    $wire.set('settings.phones', settings.phones, true);
                                    $wire.set('shop.content', content, true);
                                " wire:click="saveBasicInformation()">
                                    {{ translate('Save') }}
                                </button>
                            </div>
                            {{-- END Save basic information --}}

                        </div>
                    </div>
                    {{-- END Basic Information --}}

                    {{-- Company Info Card --}}
                    <div id="companyInfoSection" class="p-4 border bg-white border-gray-200 rounded-lg shadow mt-5">
                        <div>
                            <h3 class="text-lg leading-6 font-medium text-gray-900">{{ translate('Company information')
                                }}</h3>
                            {{-- <p class="mt-1 max-w-2xl text-sm text-gray-500">This information will be displayed
                                publicly so be careful what you share.</p> --}}
                        </div>

                        <div class="mt-6 sm:mt-5 space-y-6 sm:space-y-5">
                            <!-- Tax Number -->
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5"
                                x-data="{}">

                                <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                    {{ translate('Company TAX number') }}
                                </label>

                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                    <input type="text"
                                        class="form-standard @error('settings.tax_number') is-invalid @enderror"
                                        placeholder="{{ translate('Company tax number') }}"
                                        wire:model.defer="settings.tax_number" />

                                    <x-system.invalid-msg field="settings.tax_number"></x-system.invalid-msg>
                                </div>
                            </div>
                            <!-- END Tax Number -->

                            <!-- Registration Number -->
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5"
                                x-data="{}">
                                <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                    {{ translate('Company registration number') }}
                                </label>

                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                    <input type="text"
                                        class="form-standard @error('settings.registration_number') is-invalid @enderror"
                                        placeholder="{{ translate('Company registration number') }}"
                                        wire:model.defer="settings.registration_number" />

                                    <x-system.invalid-msg field="settings.registration_number"></x-system.invalid-msg>
                                </div>
                            </div>
                            <!-- END Registration Number -->


                            {{-- Save basic information --}}
                            <div class="flex sm:items-start sm:border-t sm:border-gray-200 sm:pt-5" x-data="{}">
                                <button type="button" class="btn btn-primary ml-auto btn-sm" @click=""
                                    wire:click="saveCompanyInfo()">
                                    {{ translate('Save') }}
                                </button>
                            </div>
                            {{-- END Save basic information --}}

                        </div>
                    </div>
                    {{-- END Company Info Card --}}

                    {{-- Contact Details --}}
                    @include('frontend.dashboard.settings.partials.shop-settings.contact-details')
                    {{-- END Contact Details --}}
                    @if(!$onboarding)
                    <!-- Addresses -->
                    <livewire:dashboard.forms.addresses.addresses-form component-id="addressesSection"
                        :addresses="$shop->addresses" type="shop_address">
                    </livewire:dashboard.forms.addresses.addresses-form>
                    <!-- END Addresses -->
                    @endif
                </div>
            </div>
        </div>
    </div>

</div>
