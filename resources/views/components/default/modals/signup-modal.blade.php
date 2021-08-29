<div class="modal fade" id="{{ $id }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <!-- Header -->
            <div class="modal-close">
                <button type="button" class="btn btn-icon btn-sm btn-ghost-secondary" data-dismiss="modal" aria-label="Close">
                    <svg width="10" height="10" viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg">
                        <path fill="currentColor" d="M11.5,9.5l5-5c0.2-0.2,0.2-0.6-0.1-0.9l-1-1c-0.3-0.3-0.7-0.3-0.9-0.1l-5,5l-5-5C4.3,2.3,3.9,2.4,3.6,2.6l-1,1 C2.4,3.9,2.3,4.3,2.5,4.5l5,5l-5,5c-0.2,0.2-0.2,0.6,0.1,0.9l1,1c0.3,0.3,0.7,0.3,0.9,0.1l5-5l5,5c0.2,0.2,0.6,0.2,0.9-0.1l1-1 c0.3-0.3,0.3-0.7,0.1-0.9L11.5,9.5z"/>
                    </svg>
                </button>
            </div>
            <!-- End Header -->

            <!-- Body -->
            <div class="modal-body p-sm-5">
                <form class="js-validate">
                    <!-- Sign in -->
                    <div id="signinModalForm">
                        <div class="text-center mb-5">
                            <h2>Sign in</h2>
                            <p>Don't have an account yet?
                                <a class="js-animation-link" href="javascript:;"
                                   data-hs-show-animation-options='{
                       "targetSelector": "#signupModalForm",
                       "groupName": "idForm"
                     }'>Sign up here</a>
                            </p>
                        </div>

                        <a class="btn btn-block btn-white mb-2" href="#">
                <span class="d-flex justify-content-center align-items-center">
                  <img class="avatar avatar-xss mr-2" src="../../assets/svg/brands/google.svg" alt="Image Description">
                  Sign in with Google
                </span>
                        </a>

                        <a class="js-animation-link btn btn-block btn-primary mb-2" href="#"
                           data-hs-show-animation-options='{
                   "targetSelector": "#signinWithEmailModalForm",
                   "groupName": "idForm"
                 }'>Sign in with Email</a>
                    </div>
                    <!-- End Sign in -->

                    <!-- Sign in with Modal -->
                    <div id="signinWithEmailModalForm" style="display: none; opacity: 0;">
                        <div class="text-center mb-5">
                            <h2>Sign in</h2>
                            <p>Don't have an account yet?
                                <a class="js-animation-link" href="javascript:;"
                                   data-hs-show-animation-options='{
                       "targetSelector": "#signupModalForm",
                       "groupName": "idForm"
                     }'>Sign up here</a>
                            </p>
                        </div>

                        <!-- Form Group -->
                        <div class="js-form-message form-group">
                            <label class="input-label" for="signinModalFormSrEmail">Your email</label>
                            <input type="email" class="form-control" name="email" id="signinModalFormSrEmail" placeholder="email@address.com" aria-label="email@address.com" required data-msg="Please enter a valid email address.">
                        </div>
                        <!-- End Form Group -->

                        <!-- Form Group -->
                        <div class="js-form-message form-group">
                            <label class="input-label" for="signinModalFormSrPassword">
                  <span class="d-flex justify-content-between align-items-center">
                    Password
                    <a class="js-animation-link link text-muted" href="javascript:;"
                       data-hs-show-animation-options='{
                         "targetSelector": "#forgotPasswordModalForm",
                         "groupName": "idForm"
                       }'>Forgot Password?</a>
                  </span>
                            </label>
                            <input type="password" class="form-control" name="password" id="signinModalFormSrPassword" placeholder="8+ characters required" aria-label="8+ characters required" required data-msg="Your password is invalid. Please try again.">
                        </div>
                        <!-- End Form Group -->

                        <button type="submit" class="btn btn-block btn-primary">Sign in</button>
                    </div>
                    <!-- End Sign in with Modal -->

                    <!-- Sign up -->
                    <div id="signupModalForm" style="display: none; opacity: 0;">
                        <div class="text-center mb-5">
                            <h2>Sign up</h2>
                            <p>Already have an account?
                                <a class="js-animation-link" href="javascript:;"
                                   data-hs-show-animation-options='{
                       "targetSelector": "#signinModalForm",
                       "groupName": "idForm"
                     }'>Sign in here</a>
                            </p>
                        </div>

                        <a class="btn btn-block btn-white mb-2" href="#">
                <span class="d-flex justify-content-center align-items-center">
                  <img class="avatar avatar-xss mr-2" src="../../assets/svg/brands/google.svg" alt="Image Description">
                  Sign up with Google
                </span>
                        </a>

                        <a class="js-animation-link btn btn-block btn-primary mb-2" href="#"
                           data-hs-show-animation-options='{
                   "targetSelector": "#signupWithEmailModalForm",
                   "groupName": "idForm"
                 }'>Sign up with Email</a>

                        <div class="text-center mt-3">
                            <p class="font-size-1 mb-0">By continuing you agree to our <a href="#">Terms and Conditions</a></p>
                        </div>
                    </div>
                    <!-- End Sign up -->

                    <!-- Sign up with Modal -->
                    <div id="signupWithEmailModalForm" style="display: none; opacity: 0;">
                        <div class="text-center mb-5">
                            <h2>Sign up</h2>
                            <p>Already have an account?
                                <a class="js-animation-link" href="javascript:;"
                                   data-hs-show-animation-options='{
                       "targetSelector": "#signinModalForm",
                       "groupName": "idForm"
                     }'>Sign in here</a>
                            </p>
                        </div>

                        <!-- Form Group -->
                        <div class="js-form-message form-group">
                            <label class="input-label" for="signupModalFormSrEmail">Your email</label>
                            <input type="email" class="form-control" name="email" id="signupModalFormSrEmail" placeholder="email@address.com" aria-label="email@address.com" required data-msg="Please enter a valid email address.">
                        </div>
                        <!-- End Form Group -->

                        <!-- Form Group -->
                        <div class="js-form-message form-group">
                            <label class="input-label" for="signupModalFormSrPassword">Password</label>
                            <input type="password" class="form-control" name="password" id="signupModalFormSrPassword" placeholder="8+ characters required" aria-label="8+ characters required" required data-msg="Your password is invalid. Please try again.">
                        </div>
                        <!-- End Form Group -->

                        <!-- Form Group -->
                        <div class="js-form-message form-group">
                            <label class="input-label" for="signupModalFormSrConfirmPassword">Confirm password</label>
                            <input type="password" class="form-control" name="confirmPassword" id="signupModalFormSrConfirmPassword" placeholder="8+ characters required" aria-label="8+ characters required" required data-msg="Password does not match the confirm password.">
                        </div>
                        <!-- End Form Group -->

                        <button type="submit" class="btn btn-block btn-primary">Sign up</button>

                        <div class="text-center mt-3">
                            <p class="font-size-1 mb-0">By continuing you agree to our <a href="#">Terms and Conditions</a></p>
                        </div>
                    </div>
                    <!-- End Sign up with Modal -->

                    <!-- Forgot Password -->
                    <div id="forgotPasswordModalForm" style="display: none; opacity: 0;">
                        <div class="text-center mb-5">
                            <h2>Forgot password?</h2>
                            <p>Enter the email address you used when you joined and we'll send you instructions to reset your password.</p>
                        </div>

                        <!-- Form Group -->
                        <div class="js-form-message form-group">
                            <label class="input-label" for="resetPasswordSrEmail" tabindex="0">
                <span class="d-flex justify-content-between align-items-center">
                  Your email
                  <a class="js-animation-link d-flex align-items-center link text-muted" href="javascript:;"
                     data-hs-show-animation-options='{
                       "targetSelector": "#signinModalForm",
                       "groupName": "idForm"
                     }'>
                    <i class="fas fa-angle-left mr-2"></i> Back to Sign in
                  </a>
                </span>
                            </label>
                            <input type="email" class="form-control" name="email" id="resetPasswordSrEmail" tabindex="1" placeholder="Enter your email address" aria-label="Enter your email address" required data-msg="Please enter a valid email address.">
                        </div>
                        <!-- End Form Group -->

                        <button type="submit" class="btn btn-block btn-primary">Submit</button>
                    </div>
                    <!-- End Forgot Password -->
                </form>
            </div>
            <!-- End Body -->

            <!-- Footer -->
            <div class="modal-footer d-block text-center py-sm-5">
                <small class="text-cap mb-4">Trusted by the world's best teams</small>

                <div class="w-85 mx-auto">
                    <div class="row justify-content-between">
                        <div class="col">
                            <img class="img-fluid" src="../../assets/svg/brands/gitlab-gray.svg" alt="Image Description">
                        </div>
                        <div class="col">
                            <img class="img-fluid" src="../../assets/svg/brands/fitbit-gray.svg" alt="Image Description">
                        </div>
                        <div class="col">
                            <img class="img-fluid" src="../../assets/svg/brands/flow-xo-gray.svg" alt="Image Description">
                        </div>
                        <div class="col">
                            <img class="img-fluid" src="../../assets/svg/brands/layar-gray.svg" alt="Image Description">
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Footer -->
        </div>
    </div>
</div>
<!-- End Sign Up Modal -->
