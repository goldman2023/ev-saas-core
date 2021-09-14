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

            <!-- Leaflet -->
            <div id="" class="min-h-300rem mb-5">
                <x-ev.dynamic-image :src="ev_dynamic_translate('#get-in-touch-image', true)" alt="Any alt text" :widthInfos="[[300, '200w'], [1000, '1000w']]">
                </x-ev.dynamic-image>
            </div>
            <!-- End Leaflet -->

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
        </div>

        <div class="col-lg-6">
            <div class="ml-lg-5">
                <!-- Form -->
                <form class="js-validate card shadow-lg mb-4">
                    <div class="card-header border-0 bg-light text-center py-4 px-4 px-md-6">
                        <h2 class="h4 mb-0">
                            <x-ev.label :label="ev_dynamic_translate('Contact Form Title', true)">
                            </x-ev.label>
                        </h2>
                    </div>

                    <div class="card-body p-4 p-md-6">
                        <div class="row">

                            <div class="col-sm-12">
                                <!-- Form Group -->
                                <div class="js-form-message form-group">
                                    <label for="lastNameExample1" class="input-label">
                                        {{ translate('Phone') }}
                                    </label>
                                    <input type="text" class="form-control" name="lastNameExample1"
                                        id="lastNameExample1" placeholder="+370...." aria-label="Gaga" required
                                        data-msg="Please enter last your name">
                                </div>
                                <!-- End Form Group -->
                            </div>

                            <div class="col-sm-12">
                                <!-- Form Group -->
                                <div class="js-form-message form-group">
                                    <label for="emailAddressExample1" class="input-label">
                                        {{ translate('Email address') }}
                                    </label>
                                    <input type="email" class="form-control" name="emailAddressExample1"
                                        id="emailAddressExample1" placeholder="nayagaga@pixeel.com"
                                        aria-label="alex@pixeel.com" required
                                        data-msg="Please enter a valid email address">
                                </div>
                                <!-- End Form Group -->
                            </div>

                            <div class="col-sm-12">
                                <!-- Form Group -->
                                <div class="js-form-message form-group">
                                    <label for="message" class="input-label">{{ translate('Message')  }}</label>
                                    <div class="input-group">
                                        <textarea class="form-control" rows="4" name="message" id="message"
                                            placeholder="{{ translate('Hi there, I would like to ...') }}"
                                            aria-label="Hi there, I would like to ..."
                                            data-msg="Please enter a text"></textarea>
                                    </div>
                                </div>
                                <!-- End Form Group -->
                            </div>
                        </div>

                        <button type="submit" class="btn btn-block btn-primary transition-3d-hover">
                            {{ translate('Send Request') }}
                        </button>
                    </div>
                </form>
                <!-- End Form -->

                <div class="text-center">
                    <p class="small">
                        <x-ev.label class="small" :label="ev_dynamic_translate('Contact Form Bottom Text', true)">
                        </x-ev.label>

                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
