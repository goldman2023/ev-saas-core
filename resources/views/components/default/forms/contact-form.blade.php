<!-- Signup Form Section -->
<div class="position-relative">
    <div class="container space-2">
        <div class="row justify-content-lg-between align-items-lg-center">
            <div class="col-lg-5 mb-7 mb-lg-0">
                <!-- Info -->
                <div class="mb-5">
                    <x-ev.label
                    tag="h2"
                    :label="ev_dynamic_translate('Contact Section Title', true)">
                    </x-ev.label>
                    <p>
                        <x-ev.label
                    :label="ev_dynamic_translate('Contact Section Description', true)">
                    </x-ev.label>
                    </p>
                </div>

                <x-ev.label
                tag="h4"
                :label="ev_dynamic_translate('Contact Section Benefits', true)">
                </x-ev.label>

                <div class="media text-body mb-3">
                        <x-heroicon-s-badge-check class="mt-1 mr-2 text-success" style="max-width:30px" />


                    <div class="media-body">
                        Unlimited access to the top 3,500+ courses
                    </div>
                </div>
                <div class="media text-body mb-3">
                    <x-heroicon-s-badge-check class="mt-1  mr-2 text-success" style="max-width:30px" />

                    <div class="media-body">
                        Fresh content taught by 1,300+ experts – for any learning style
                    </div>
                </div>
                <div class="media text-body mb-3">
                    <x-heroicon-s-badge-check class="text-success mr-2" style="max-width:30px" />

                    <div class="media-body">
                        Actionable learning insights <span
                            class="badge badge-warning badge-pill ml-1 w-auto">Beta</span>
                    </div>
                </div>
                <!-- End Info -->
            </div>

            <div class="col-lg-6">
                <!-- Signup Form -->
                <form class="js-validate card card-bordered w-md-85 w-lg-100 mx-md-auto">
                    <div class="card-header bg-primary text-white text-center py-4 px-5 px-md-6">

                        <x-ev.label
                        tag="h4"
                        class="text-white mb-0"
                        :label="ev_dynamic_translate('Contact form hero title', true)">
                        </x-ev.label>
                    </div>

                    <div class="card-body p-md-6">
                        <div class="row">
                            <div class="col-sm-6 mb-3">
                                <!-- Form Group -->
                                <div class="js-form-message form-group">
                                    <label for="firstName" class="input-label">First name</label>
                                    <input type="text" class="form-control" name="firstName" id="firstName"
                                        placeholder="Nataly" aria-label="Nataly" required
                                        data-msg="Please enter first your name">
                                </div>
                                <!-- End Form Group -->
                            </div>

                            <div class="col-sm-6 mb-3">
                                <!-- Form Group -->
                                <div class="js-form-message form-group">
                                    <label for="lastName" class="input-label">Last name</label>
                                    <input type="text" class="form-control" name="lastName" id="lastName"
                                        placeholder="Gaga" aria-label="Gaga" required
                                        data-msg="Please enter last your name">
                                </div>
                                <!-- End Form Group -->
                            </div>

                            <div class="col-sm-12 mb-3">
                                <!-- Form Group -->
                                <div class="js-form-message form-group">
                                    <label for="emailAddress" class="input-label">Email address</label>
                                    <input type="email" class="form-control" name="emailAddress" id="emailAddress"
                                        placeholder="nayagaga@pixeel.com" aria-label="alex@pixeel.com" required
                                        data-msg="Please enter a valid email address">
                                </div>
                                <!-- End Form Group -->
                            </div>

                            <div class="col-sm-6 mb-3">
                                <!-- Form Group -->
                                <div class="js-form-message form-group">
                                    <label for="password" class="input-label">Password</label>
                                    <input type="text" class="form-control" name="passowrd" id="password"
                                        placeholder="*********" aria-label="*********" required
                                        data-msg="Your password is invalid. Please try again">
                                </div>
                                <!-- End Form Group -->
                            </div>

                            <div class="col-sm-6 mb-3">
                                <!-- Form Group -->
                                <div class="js-form-message form-group">
                                    <label for="confirmPassword" class="input-label">Confirm password</label>
                                    <input type="text" class="form-control" name="confirmPassword" id="confirmPassword"
                                        placeholder="*********" aria-label="*********" required
                                        data-msg="Password does not match the confirm password">
                                </div>
                                <!-- End Form Group -->
                            </div>
                        </div>

                        <!-- Checkbox -->
                        <div class="js-form-message mb-5">
                            <div class="custom-control custom-checkbox d-flex align-items-center text-muted">
                                <input type="checkbox" class="custom-control-input" id="termsCheckboxExample1"
                                    name="termsCheckboxExample1" required
                                    data-msg="Please accept our Terms and Conditions.">
                                <label class="custom-control-label" for="termsCheckboxExample1">
                                    <small>
                                        I agree to the
                                        <a class="link-underline" href="#">Terms and Conditions</a>
                                    </small>
                                </label>
                            </div>
                        </div>
                        <!-- End Checkbox -->

                        <div class="row align-items-center">
                            <div class="col-sm-7 mb-3 mb-sm-0">
                                <p class="font-size-1 text-muted mb-0">Already have an account? <a
                                        class="font-weight-bold" href="#">Log In</a></p>
                            </div>
                            <div class="col-sm-5 text-sm-right">
                                <button type="submit" class="btn btn-sm btn-primary transition-3d-hover">Sign Up <i
                                        class="fa fa-angle-right fa-sm ml-1"></i></button>
                            </div>
                        </div>
                    </div>
                </form>
                <!-- End Signup Form -->
            </div>
        </div>
    </div>
</div>
<!-- End Signup Form Section -->

@push('footer_scripts')
    <!-- JS Plugins Init. -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
    <script src="/front/js/hs.core.js"></script>

    <script src="/front/js/hs.validation.js"></script>

    <script>
        $(document).on('ready', function() {
            // INITIALIZATION OF FORM VALIDATION
            // =======================================================
            $('.js-validate').each(function() {
                var validation = $.HSCore.components.HSValidation.init($(this));
            });
        });
    </script>
@endpush
