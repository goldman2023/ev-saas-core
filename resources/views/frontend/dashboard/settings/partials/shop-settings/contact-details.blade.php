<div class="card mb-3 mb-lg-5 position-relative"
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
                    <div class="card w-100 pointer h-100 position-relative"
                         @click="showModal(contact)">

                        <div class="card-body position-relative">
                            <template x-if="contact.is_primary">
                                <span class="position-absolute badge badge-primary text-10" style="right: 10px; top: 10px;">
                                    {{ translate('Primary') }}
                                </span>
                            </template>

{{--                            <h6 class="card-subtitle" x-text="currentContact.department_name"></h6>--}}
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
    <div id="updateContactDetailsModal" class="modal fade" tabindex="-1" role="dialog"
         x-data="{

         }">
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
</div>
