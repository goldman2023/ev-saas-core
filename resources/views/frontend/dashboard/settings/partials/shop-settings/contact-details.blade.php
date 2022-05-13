<div id="contactDetails" class="p-4 border bg-white border-gray-200 rounded-lg shadow mt-5" x-data="{
        currentContact: null,
        currentIndex: null,
        contactTemplate: {
            department_name: '',
            email: '',
            phones: [],
            is_primary: false
        },
        init() {
            if(settings.contact_details === null || settings.contact_details === undefined) {
                settings.contact_details = [];
            }
        },
        addNew() {
            if(settings.contact_details.length <= 0) {
                settings.contact_details.push(this.contactTemplate);
                this.currentContact = settings.contact_details[0];
                this.currentIndex = 0;
            } else {
                settings.contact_details.forEach(function(contact, index) {
                    if(contact.department_name === '' || contact.email === '') {
                        settings.contact_details.splice(index, 1);
                    }
                });

                settings.contact_details.push(this.contactTemplate);
                this.currentContact = settings.contact_details[settings.contact_details.length - 1];
                this.currentIndex = settings.contact_details.length - 1;
            }

            $dispatch('display-flyout-panel', {'id': 'contact-panel'});
        },
        edit(index) {
            this.currentContact = settings.contact_details[index];
            this.currentIndex = index;
            $dispatch('display-flyout-panel', {'id': 'contact-panel'});
        },
        remove(index) {
            return null;
        }
    }" x-init="init(); currentIndex = 0; currentContact = settings.contact_details[0]; ">

    
    <div class="w-full flex justify-between items-center border-b border-gray-200 mb-3 pb-3">
        <div class="shrink-0">
            <h3 class="text-lg leading-6 font-medium text-gray-900 mb-1">{{ translate('Contact details') }}</h3>
            <p class="flex items-center-1 max-w-2xl text-sm text-gray-500"> {{ translate('Add one or multiple contacts to your shop') }}</p>
        </div>
        <div class="grow-0">
            <button type="button" class="btn-primary" @click="addNew()">
                {{-- @svg('heroicon-o-chevron-left', ['class' => 'h-4 h-4 mr-2']) --}}
                <span>{{ translate('Add new') }}</span>
            </button>
        </div>
    </div>

    <div class="mt-6 sm:mt-5 space-y-6 sm:space-y-5">
        @if(!empty($settings['contact_details'] ?? null))
            <ul role="list" class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                @foreach($settings['contact_details'] as $index => $contact)
                    <li class="col-span-1 bg-white rounded-lg shadow divide-y divide-gray-200  border border-gray-200">
                        <div class="w-full flex items-center justify-between p-6 space-x-6">
                            <div class="flex-1 truncate">
                                <div class="flex items-center space-x-3">
                                    <h3 class="text-gray-900 text-sm font-medium truncate">{{ $contact['department_name'] ?? '' }}</h3>
                                    @if($contact['is_primary'] ?? false)
                                        <span class="badge-success !text-green-800 !bg-green-100">
                                            {{ translate('Primary') }}
                                        </span>
                                    @endif
                                </div>
                                <p class="mt-1 text-gray-500 text-sm truncate">
                                    {{ $contact['email'] ?? '' }}
                                </p>

                                @if(!empty($contact['phones'] ?? false))
                                    <div class="w-full flex items-center flex-wrap mt-3">
                                        @foreach($contact['phones'] as $phone)
                                            <span class="badge-info mr-2" >{{ $phone }}</span>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div>
                            <div class="-mt-px flex divide-x divide-gray-200">
                                <div class="w-0 flex-1 flex">
                                    <button @click="remove({{ $index }})" class="relative -mr-px w-0 flex-1 inline-flex items-center justify-center py-4 text-sm bg-danger text-white font-medium border border-transparent rounded-bl-lg">
                                        @svg('heroicon-o-trash', ['class' => 'w-5 h-5 text-white'])
                                        <span class="ml-3">{{ translate('Remove') }}</span>
                                    </button>
                                </div>
                                <div class="-ml-px w-0 flex-1 flex">
                                    <button @click="edit({{ $index }})" class="relative w-0 flex-1 inline-flex items-center justify-center py-4 text-sm text-gray-700 font-medium border border-transparent rounded-br-lg hover:text-gray-500">
                                        @svg('heroicon-o-pencil', ['class' => 'w-5 h-5'])
                                        <span class="ml-3">{{ translate('Edit') }}</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        @else
            <x-dashboard.empty-states.no-items-in-collection 
                icon="heroicon-o-phone" 
                title="{{ translate('No contacts yet') }}" 
                text="{{ translate('Add shop contact details so customers can contact you!') }}"
                {{-- link-href-route="blog.post.create" --}}
                link-text="{{ translate('Add new Contact') }}"
                on-click="addNew()">

            </x-dashboard.empty-states.no-items-in-collection>
        @endif
    </div>

    {{-- Contact Flyout --}}
    <x-panels.flyout-panel id="contact-panel">
        <h3 class="text-18 mb-3 pb-2 border-b flex items-center" x-data="{}">
            @svg('heroicon-o-home', ['class' => 'w-[18px] h-[18px] mr-2'])
            <span>{{ translate('Contact') }}</span>
        </h3>

        <div class="flex flex-col mb-1 grow">
            {{-- Department Name --}}
            <div class="w-full">
                <label class="block text-sm font-medium text-gray-700">{{ translate('Department name') }}</label>
                <div class="mt-1">
                  <input type="text" class="form-standard" x-model="currentContact.department_name">
                </div>
            </div>
            {{-- END Department Name --}}

            {{-- Email --}}
            <div class="w-full mt-4">
                <label class="block text-sm font-medium text-gray-700">{{ translate('Email') }}</label>
                <div class="mt-1">
                  <input type="email" class="form-standard " x-model="currentContact.email">
                </div>
            </div>
            {{-- END Email --}}

            {{-- Phones --}}
            <div class="w-full mt-4">
                <label class="block text-sm font-medium text-gray-700 ">{{ translate('Phones') }}</label>
                <div class="mt-1">
                    <x-dashboard.form.text-repeater field="currentContact.phones" limit="3" placeholder="{{ translate('Phone') }}"></x-dashboard.form.text-repeater>
                </div>
            </div>
            {{-- END Phones --}}

            {{-- Is primary? --}}
            <div class="flex items-center mt-5">
                <button type="button" @click="currentContact.is_primary = !currentContact.is_primary" 
                            :class="{'bg-primary':currentContact.is_primary, 'bg-gray-200':!currentContact.is_primary}" 
                            class="relative inline-flex flex-shrink-0 h-6 w-11 border-2 border-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary" role="switch" >
                    <span :class="{'translate-x-5':currentContact.is_primary, 'translate-x-0':!currentContact.is_primary}" class="pointer-events-none inline-block h-5 w-5 rounded-full bg-white shadow transform ring-0 transition ease-in-out duration-200"></span>
                </button>
                <span class="ml-3" @click="currentContact.is_primary = !currentContact.is_primary">
                  <span class="text-sm font-medium text-gray-900 cursor-pointer">{{ translate('Is this your primary contact?') }}</span>
                </span>
            </div>
            {{-- END Is primary? --}}

            <button type="button" class="w-full btn btn-primary ml-auto btn-sm mt-6" @click="
                    settings.contact_details[currentIndex] = currentContact;
                    $wire.saveContactDetails(settings.contact_details, currentContact);
                ">
                {{ translate('Save') }}
            </button>
        </div>
    </x-panels.flyout-panel>
    {{-- END Contact Flyout --}}
</div>

{{-- <div class="card mb-3 mb-lg-5 position-relative mt-5"
     id="contactDetailsSection"
     x-data="{
        currentContact: settings.contact_details[0],
        showModal(contact) {
            this.currentContact = contact;
            $('#updateContactDetailsModal').modal('toggle');
            this.initToggleSwitch();
        },
        hideModal(contact) {
            $('#updateContactDetailsModal').modal('hide');
            this.reset();
        },
        initToggleSwitch() {
            $('#updateContactDetailsModal').find('.js-toggle-switch').each(function () {
                var addressToggleSwitch = new HSToggleSwitch($(this)).init();
            });
        },
        addNew() {
            settings.contact_details[settings.contact_details.length] = {
                'department_name': '',
                'email': '',
                'phones': [],
                'is_primary': false
            };
            this.currentContact = settings.contact_details[settings.contact_details.length-1];
            this.showModal(this.currentContact);
        },
        reset() {
            settings.contact_details = settings.contact_details.filter(contact => contact.email.length > 2 && contact.department_name.length > 2);
        },
        saveContactDetails() {
            $wire.saveContactDetails(settings.contact_details, this.currentContact);
        },
        removeContactDetails() {
            $wire.removeContactDetails(settings.contact_details, this.currentContact);
        }
     }"
     @contact-details-modal-hide.window="hideModal()"
>
    <x-ev.loaders.spinner class="absolute-center z-10 d-none"
                          wire:target="saveContactDetails"
                          wire:loading.class.remove="d-none"></x-ev.loaders.spinner>

    <div class="card-header">
        <h2 class="card-title h4">{{ translate('Contact details') }}</h2>
        <div class="pointer btn btn-xs btn-primary" @click="addNew()">
            {{ translate('Add contact details') }}
        </div>
    </div>

    <div class="card-body"
         wire:loading.class="opacity-3 prevent-pointer-events"
         wire:target="saveContactDetails">

        <div class="row">
            <template x-for="contact in settings.contact_details">
                <div class="col-4 px-2 mb-3">
                    <div class="card w-100 pointer h-100 position-relative" @click="showModal(contact)">

                        <div class="card-body position-relative">
                            <template x-if="contact.is_primary">
                                <span class="position-absolute badge badge-primary text-10" style="right: 10px; top: 10px;">
                                    {{ translate('Primary') }}
                                </span>
                            </template>

                            <h3 class="card-title text-18" x-text="contact.department_name"></h3>
                            <p class="card-text mb-2" x-text="contact.email"></p>

                            <template x-if="contact.phones.length > 0">
                                <div class="d-flex align-items-center flex-wrap">
                                    <template x-for="phone in contact.phones">
                                        <span class="badge badge-info mr-2 mb-2" x-text="phone"></span>
                                    </template>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </template>

            <template x-if="settings.contact_details.length <= 0">
                <div class="col-12">
                    <span>{{ translate('There are no contact details yet...') }}</span>
                </div>
            </template>
        </div>
    </div>


    <!-- Address change Modal -->
    <div id="updateContactDetailsModal" class="modal fade" tabindex="-1" role="dialog" x-data="{}">
        <div class="modal-dialog modal-dialog-centered" role="document"
             @click.outside="reset()"
             wire:target="saveContactDetails()"
             wire:loading.class="prevent-pointer-events opacity-4"
        >
            <x-ev.loaders.spinner class="absolute-center z-10 d-none"
                                  wire:target="saveContactDetails()"
                                  wire:loading.class.remove="d-none"></x-ev.loaders.spinner>

            <div class="modal-content">
                <!-- Header -->
                <div class="modal-top-cover bg-dark text-center">
                    <figure class="position-absolute right-0 bottom-0 left-0" style="margin-bottom: -1px;">
                        <svg preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" viewBox="0 0 1920 100.1"
                             style="vertical-align: middle;">
                            <path fill="#fff" d="M0,0c0,0,934.4,93.4,1920,0v100.1H0L0,0z"/>
                        </svg>
                    </figure>

                    <div class="modal-close" @click="reset()">
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
                      @svg('heroicon-o-phone', ['class' => 'square-24'])
                    </span>
                </div>

                <div class="modal-body row">
                    <div class="col-6">
                        <div class="form-group">
                            <label class="input-label " for="modal_contact_details_department_name">{{ translate('Department name') }}</label>
                            <input type="text"
                                   id="modal_contact_details_department_name"
                                   name="modal_contact_details_department_name"
                                   x-model="currentContact.department_name"
                                   class="form-control">
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="form-group">
                            <label class="input-label " for="modal_contact_details_email">{{ translate('Email') }}</label>
                            <input type="email"
                                   id="modal_contact_details_email"
                                   name="modal_contact_details_email"
                                   x-model="currentContact.email"
                                   class="form-control">
                        </div>
                    </div>

                    <div class="col-12">
                        <!-- Form Group -->
                        <div class="js-add-field row form-group"
                             x-data="{
                                phones_limit: 3,
                                addNewPhoneNumber() {
                                    if(currentContact.phones.length < 3)
                                        currentContact.phones.push('');
                                },
                                removePhoneNumber(index) {
                                    currentContact.phones.splice(index, 1);
                                },
                             }"
                        >
                            <label for="phoneFieldLabel" class="col-sm-3 col-form-label input-label">
                                {{ translate('Phones') }}
                            </label>

                            <div class="col-sm-9">
                                <template x-if="currentContact.phones.length <= 1">
                                    <div class="d-flex">
                                        <input type="text" class="form-control" name="phoneNumberField"
                                               placeholder="{{ translate('Phone number 1') }}"
                                               x-model="currentContact.phones[0]">
                                    </div>
                                </template>
                                <template x-if="currentContact.phones.length > 1">
                                    <template x-for="[key, value] of Object.entries(currentContact.phones)">
                                        <div class="d-flex" :class="{'mt-2': key > 0}">
                                            <input type="text" class="form-control" name="phoneNumberField"
                                                   x-bind:placeholder="'{{ translate('Phone number') }} '+(Number(key)+1)"
                                                   x-model="currentContact.phones[key]">
                                            <template x-if="key > 0">
                                                <span class="ml-2 d-flex align-items-center pointer" @click="removePhoneNumber(key)">
                                                    @svg('heroicon-o-trash', ['class' => 'square-22 text-danger'])
                                                </span>
                                            </template>
                                        </div>
                                    </template>
                                </template>

                                <template x-if="currentContact.phones.length < phones_limit">
                                    <a href="javascript:;"
                                       class="js-create-field form-link btn btn-xs btn-no-focus btn-ghost-primary"
                                       @click="addNewPhoneNumber()">
                                        <i class="tio-add"></i> {{ translate('Add phone') }}
                                    </a>
                                </template>
                            </div>
                        </div>
                        <!-- End Form Group -->
                    </div>

                    <div class="col-12">
                        <label class="toggle-switch mx-2" for="customSwitchModalEg">
                            <input type="checkbox" x-model="currentContact.is_primary" class="js-toggle-switch toggle-switch-input" id="customSwitchModalEg">
                            <span class="toggle-switch-label">
                                <span class="toggle-switch-indicator"></span>
                            </span>

                            <span class="ml-3">{{ translate('Use as primary contact') }}</span>
                        </label>
                    </div>

                </div>
                <div class="modal-footer">
                    <template x-if="settings.contact_details.length > 1">
                        <button type="button"
                                class="btn btn-primary mr-auto d-flex align-items-center justify-content-center"
                                @click="removeContactDetails()">
                            @svg('heroicon-o-trash', ['class' => 'square-22'])
                        </button>
                    </template>

                    <button type="button" class="btn btn-white" data-dismiss="modal" @click="reset()">{{ translate('Close') }}</button>
                    <button type="button" class="btn btn-primary" @click="saveContactDetails()">{{ translate('Save') }}</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End Modal -->
</div> --}}
