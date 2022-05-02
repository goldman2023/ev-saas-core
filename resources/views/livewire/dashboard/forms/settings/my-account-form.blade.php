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
        entity: @js($me->entity),
        onSave() {
            $wire.set('me.thumbnail', this.thumbnail.id, true);
            $wire.set('me.cover', this.cover.id, true);
            $wire.set('me.entity', this.entity, true);

            @if(collect(get_tenant_setting('user_meta_fields_in_use'))->where('onboarding', true)->count() > 0)
                @foreach(collect(get_tenant_setting('user_meta_fields_in_use'))->where('onboarding', true) as $key => $options)
                    @if(($options['type']??'string') == 'select' || ($options['type']??'string') == 'date' || ($options['type']??'string') == 'wysiwyg')
                        $wire.set('meta.{{ $key }}.value', this.meta.{{ $key }}.value, true);
                    @endif
                @endforeach
            @endif
        },
    }" x-init="$watch('current', function(value) {
        $([document.documentElement, document.body]).animate({
            scrollTop: $('#'+value).offset().top - $('#topbar').outerHeight() - 20
        }, 500);
    })" @validation-errors.window="$scrollToErrors($event.detail.errors, 700);" 
        @submit-form.window="
            onSave();
            $wire.saveBasicInformation();
        "
        x-cloak>
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

                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                                <fieldset class="mt-4">
                                  <div class="space-y-4 sm:flex sm:items-center sm:space-y-0 sm:space-x-10">
                                    <div class="flex items-center">
                                      <input id="entity_individual" name="entity_field" type="radio" x-model="entity"  value="individual" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300">
                                      <label for="entity_individual" class="ml-3 block text-sm font-medium text-gray-700"> {{ translate('Individual') }} </label>
                                    </div>
                              
                                    <div class="flex items-center">
                                      <input id="entity_company" name="entity_field" type="radio" x-model="entity"  value="company" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300">
                                      <label for="entity_company" class="ml-3 block text-sm font-medium text-gray-700"> {{ translate('Company') }} </label>
                                    </div>
                                  </div>
                                </fieldset>
                            </div>

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

                            @php 
                                if($onboarding) {
                                    $user_meta_fields_in_use = collect(get_tenant_setting('user_meta_fields_in_use'))->where('onboarding', true);
                                } else {
                                    $user_meta_fields_in_use = collect(get_tenant_setting('user_meta_fields_in_use'));
                                }
                            @endphp
                            @if($user_meta_fields_in_use->count() > 0)
                                @foreach($user_meta_fields_in_use as $key => $options)
                                    @if($onboarding && ($options['onboarding'] ?? null) != 1)
                                        @continue
                                    @endif

                                    <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5"
                                        x-data="{}" @if(in_array($key, \App\Models\UserMeta::metaForCompanyEntity())) x-show="entity === 'company'" @endif>

                                        <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                            {{  Str::title(str_replace('_', ' ', $key)) }}
                                            @if($options['required'] ?? false) <span class="text-danger">*</span>@endif
                                        </label>

                                        <div class="mt-1 sm:mt-0 sm:col-span-2">
                                            @if(($options['type']??'string') == 'string')
                                                <x-dashboard.form.input field="meta.{{ $key }}.value" />
                                            @elseif(($options['type']??'string') == 'date')
                                                <x-dashboard.form.date field="meta.{{ $key }}.value" />
                                            @elseif(($options['type']??'string') == 'select')
                                                <x-dashboard.form.select field="meta.{{ $key }}.value" selected="meta.{{ $key }}.value" :items="\App\Models\UserMeta::metaSelectValues($key)" />
                                            @elseif(($options['type']??'string') == 'wysiwyg')
                                                <x-dashboard.form.froala field="meta.{{ $key }}.value" id="wysiwyg-{{ $key }}"  />

                                            @elseif($key === 'work_experience')
                                                <div class="w-full" x-data="{
                                                    current: 0,
                                                    experiences: meta.{{ $key }}.value,
                                                    item_template: {
                                                        'title': 'Example',
                                                        'company_name': 'Example',
                                                        'employment_type': '',
                                                        'location': '',
                                                        'currently_working_there': '',
                                                        'start_date': '',
                                                        'end_date': '',
                                                        'description': '',
                                                    },
                                                    add() {
                                                        if(this.experiences === undefined || this.experiences === null) { 
                                                            this.experiences = [ {...this.item_template} ]; 
                                                        } else {
                                                            this.experiences.push({...this.item_template});
                                                        }
                                                    },
                                                    remove(index) {
                                                        this.current = 0;
                                                        this.experiences.splice(index, 1);

                                                        $wire.set('meta.{{ $key }}.value', this.experiences.filter(function(x){return x}), true);
                                                        $wire.saveWorkExperience();
                                                    }
                                                }" x-init="if(experiences === undefined || experiences === null) { 
                                                    experiences = [  ]; 
                                                }">
                                                    {{-- <template x-if="_.get('meta.{{ $key }}.value', []) != null && _.get('meta.{{ $key }}.value', []).length > 0"> --}}
                                                        <ul class="mt-4 border-t border-b border-gray-200 divide-y divide-gray-200">
                                                            <template x-for="(item, index) in experiences">
                                                                <li class="py-4 flex items-center justify-between space-x-3">
                                                                    <div class="min-w-0 flex-1 flex items-center space-x-3">
                                                                      {{-- <div class="flex-shrink-0">
                                                                        <img class="h-10 w-10 rounded-full" src="https://images.unsplash.com/photo-1517841905240-472988babdf9?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="">
                                                                      </div> --}}
                                                                      <div class="min-w-0 flex-1">
                                                                        <p class="text-sm font-medium text-gray-900 truncate" x-text="item.company_name+' ('+item.location+')'"></p>
                                                                        <p class="text-sm font-medium text-gray-500 truncate" x-text="item.title"></p>
                                                                      </div>
                                                                    </div>
                                                                    <div class="flex-shrink-0">
                                                                      <button type="button" @click="current = index; $dispatch('display-modal', {'id': 'work-experience-modal'})" class="inline-flex items-center py-2 px-3 border border-transparent rounded-full bg-gray-100 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                                                                        @svg('heroicon-s-pencil', ['class' => '-ml-1 mr-0.5 h-5 w-5 text-gray-400'])
                                                                        <span class="text-sm font-medium text-gray-900">{{ translate('Edit') }}</span>
                                                                      </button>
                                                                    </div>
                                                                </li>
                                                            </template>
                                                        </ul>
                                                    {{-- </template> --}}

                                                    <div class="btn-ghost !pl-0 !text-14 mt-1" @click="add()">
                                                        @svg('heroicon-o-plus', ['class' => 'h-3 w-3 mr-2'])
                                                        {{ translate('Add new') }}
                                                    </div>

                                                    <x-system.form-modal id="work-experience-modal" title="Work Experience" :prevent-close="true">
                                                        <!-- Workplace Title -->
                                                        <div class="flex flex-col mb-3" x-data="{}">
                                                            <label class="block text-sm font-medium text-gray-900 mb-2">
                                                                {{ translate('Title/Position') }}
                                                            </label>

                                                            <div class="mt-1 sm:mt-0 sm:col-span-2">
                                                                <x-dashboard.form.input field="experiences[current].title" :x="true"/>
                                                            </div>
                                                        </div>
                                                        <!-- END Workplace Title -->

                                                        <!-- Workplace Company name -->
                                                        <div class="flex flex-col mb-3" x-data="{}">
                                                            <label class="block text-sm font-medium text-gray-900 mb-2">
                                                                {{ translate('Company name') }}
                                                            </label>

                                                            <div class="mt-1 sm:mt-0 sm:col-span-2">
                                                                <x-dashboard.form.input field="experiences[current].company_name" :x="true" />
                                                            </div>
                                                        </div>
                                                        <!-- END Workplace Employment type  -->

                                                        <!-- Workplace Employment type -->
                                                        <div class="flex flex-col mb-3" x-data="{}">
                                                            <label class="block text-sm font-medium text-gray-900 mb-2">
                                                                {{ translate('Employment type') }}
                                                            </label>

                                                            <div class="mt-1 sm:mt-0 sm:col-span-2">
                                                                <x-dashboard.form.select field="experiences[current].employment_type" :items="\App\Enums\EmploymentTypeEnum::labels()" selected="experiences[current].employment_type" :nullable="false"></x-dashboard.form.select>
                                                            </div>
                                                        </div>
                                                        <!-- END Workplace Employment type  -->

                                                        <!-- Workplace Location -->
                                                        <div class="flex flex-col mb-3" x-data="{}">
                                                            <label class="block text-sm font-medium text-gray-900 mb-2">
                                                                {{ translate('Location') }}
                                                            </label>

                                                            <div class="mt-1 sm:mt-0 sm:col-span-2">
                                                                <x-dashboard.form.input field="experiences[current].location" :x="true" />
                                                            </div>
                                                        </div>
                                                        <!-- END Workplace Location  -->

                                                        {{-- Start/End date --}}
                                                        <div class="grid grid-cols-2 gap-6 mb-3">
                                                            <div class="col-span-1">
                                                                <label class="block text-sm font-medium text-gray-900 mb-2">
                                                                    {{ translate('Start') }}
                                                                </label>
                                                                <x-dashboard.form.date id="workplace-start-date" field="experiences[current].start_date"></x-dashboard.form.date>
                                                            </div>
                                                            <div class="col-span-1">
                                                                <label class="block text-sm font-medium text-gray-900 mb-2">
                                                                    {{ translate('End') }}
                                                                </label>
                                                                <x-dashboard.form.date id="workplace-end-date" field="experiences[current].end_date"></x-dashboard.form.date>
                                                            </div>
                                                        </div>
                                                        {{-- END Start/End date --}}

                                                        {{-- Currently working there? --}}
                                                        <div class="flex flex-col mb-3" x-data="{}">
                                                            <label class="block text-sm font-medium text-gray-900 mb-2">
                                                                {{ translate('Currently working there?') }}
                                                            </label>
                    
                                                            <div class="mt-1 sm:mt-0 sm:col-span-2">
                                                                <x-dashboard.form.toggle field="experiences[current].currently_working_there" />
                                                            </div>
                                                        </div>
                                                        {{-- END Currently working there? --}}

                                                        {{-- Description --}}
                                                        <div class="flex flex-col mb-3" x-data="{}">
                                                            <label class="block text-sm font-medium text-gray-900 mb-2">
                                                                {{ translate('Description') }}
                                                            </label>
                    
                                                            <div class="mt-1 sm:mt-0 sm:col-span-2">
                                                                <textarea x-model="experiences[current].description" rows="3" class="max-w-lg shadow-sm block w-full focus:ring-primary focus:border-primary sm:text-sm border border-gray-300 rounded-md"></textarea>
                                                            </div>
                                                        </div>
                                                        {{-- END Description --}}

                                                        <div class="w-full flex justify-between mt-4" x-data="{}">
                                                            <button type="button" class="" @click="remove(current); show = false;">
                                                                @svg('heroicon-o-trash', ['class' => 'w-5 h-5 text-danger'])
                                                            </button>

                                                            <div class="">
                                                                <button type="button" @click="show = false" class="btn btn-ghost btn-sm mr-3">
                                                                    {{ translate('Close') }}
                                                                </button>
                                                                <button type="button" class="btn btn-primary btn-sm" @click="
                                                                    $wire.set('meta.{{ $key }}.value', experiences, true);
                                                                    show = false;
                                                                " wire:click="saveWorkExperience()">
                                                                    {{ translate('Save') }}
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </x-system.form-modal>
                                                </div>
                                            @elseif($key === 'education')
                                                
                                            @endif

                                            <x-system.invalid-msg field="me.phone"></x-system.invalid-msg>
                                        </div>
                                    </div>
                                @endforeach
                            @endif

                            {{-- <!-- Bio -->
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
                            <!-- END Bio --> --}}

                            {{-- Save basic information --}}
                            <div class="flex sm:items-start sm:border-t sm:border-gray-200 sm:pt-5" x-data="{}">
                                <button type="button" class="btn btn-primary ml-auto btn-sm" @click="onSave()" wire:click="saveBasicInformation()">
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
