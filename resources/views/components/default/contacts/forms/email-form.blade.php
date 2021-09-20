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
