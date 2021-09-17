<div class="container space-2">
    <div class="row">
        <div class="col-lg-6 mb-9 mb-lg-0">
            <div class="mb-5">
                <x-ev.label tag="h1" class="display-4" :label="ev_dynamic_translate('Get in touch', true)">
                </x-ev.label>
                <p>
                    <x-ev.label :label="ev_dynamic_translate('We\'d love to talk about how we can help you.', true)">
                    </x-ev.label>
                </p>
            </div>

            <div class="row">
                <div class="col-sm-6">
                    <div class="mb-3">
                        <span class="d-block h5 mb-1">
                            <x-ev.label :label="ev_dynamic_translate('Call us:', true)">
                            </x-ev.label>
                        </span>
                        <x-ev.label tag="span" class="d-block text-body font-size-1"
                            :label="ev_dynamic_translate('Phone Number', true)">
                        </x-ev.label>

                    </div>

                    <div class="mb-3">
                        <span class="d-block h5 mb-1">
                            <x-ev.label :label="ev_dynamic_translate('Email us:', true)">
                            </x-ev.label>
                        </span>
                        <span class="d-block text-body font-size-1">
                            <x-ev.label :label="ev_dynamic_translate('Contact Email Value', true)">
                            </x-ev.label>
                        </span>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="mb-3">
                        <span class="d-block h5 mb-1">
                            <x-ev.label :label="ev_dynamic_translate('Address:', true)">
                            </x-ev.label>
                        </span>
                        <span class="d-block text-body font-size-1">
                            <x-ev.label :label="ev_dynamic_translate('Address value', true)">
                            </x-ev.label>
                        </span>
                    </div>
                </div>
            </div>
            <!-- Leaflet -->
            <div id="" class="min-h-300rem mb-5">
                <x-ev.dynamic-image :src="ev_dynamic_translate('#get-in-touch-image', true)" alt="Any alt text"
                    :widthInfos="[[300, '200w'], [1000, '1000w']]">
                </x-ev.dynamic-image>
            </div>
            <!-- End Leaflet -->

            @if ($map)
                <iframe width="600" height="450" style="border:0" loading="lazy" allowfullscreen src="https://www.google.com/maps/embed/v1/place?key=AIzaSyBLQOzlf945klIbLyJ796I2hgv-nMHjt_o
    &q={{ $address }}">
                </iframe>
            @endif


        </div>

        <div class="col-lg-6">
            <div class="ml-lg-5">
                <!-- Form -->
                @if ($form === 'email-form')
                    <x-default.contacts.forms.email-form></x-default.contacts.forms.email-form>
                @elseif($form === 'calendly-form')
                    <x-default.contacts.forms.calendly-form></x-default.contacts.forms.calendly-form>
                @endif
                <!-- End Form -->

                <div class="text-center">
                    <p class="small">
                        <x-ev.label class="small"
                            :label="ev_dynamic_translate('Contact Form Bottom Text', true)">
                        </x-ev.label>

                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
