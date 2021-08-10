<!-- Signup Form Section -->
<div id="hireUsSection" class="bg-dark"
     style="background-image: url(https://htmlstream.com/front/assets/svg/components/abstract-shapes-20.svg);">
    <div class="container-xl container-fluid space-1 space-md-2 px-4 px-md-8 px-lg-10">
        <div class="row justify-content-lg-between align-items-lg-center">
            <div class="col-md-10 col-lg-5 mb-9 mb-lg-0">
                <h1 class="text-white display-1">
                    @php
                        $header_logo = get_setting('header_logo');
                    @endphp
                    @if($header_logo != null)
                        <img src="{{ uploaded_asset($header_logo) }}" alt="{{ env('APP_NAME') }}"
                             class="mw-100 h-50px h-md-50px" height="50">
                    @endif
                </h1>
                <p class="text-white text-2xl" style="font-size: 20px; font-weight: 600;"
                   data-test="landing-heading"
                >
                    BECOME A PART OF SOMETHING SPECIAL
                </p>

                <div class="w-50">
                    <ul class="list-checked list-checked-sm list-checked-success text-white">
                        <li class="list-checked-item text-white">Companies</li>
                        <li class="list-checked-item">News</li>
                        <li class="list-checked-item">Events</li>
                        <li class="list-checked-item">Jobs</li>
                        <li class="list-checked-item">Members</li>
                    </ul>
                </div>
            </div>

            <div class="col-lg-6">
                <!-- Form -->
                <!-- TODO: Move this to global blade component -->
                @php
                    $messages =  session('flash_notification', collect())->toArray()
                @endphp
                @if($messages)
                    <div id="form-notification" data-test="form-notification">
                        <div class="alert alert-success text-white">
                            @foreach (session('flash_notification', collect())->toArray() as $message)
                                {{ $message['message'] }}
                            @endforeach

                        </div>
                    </div>

                @else
                    <form class="js-validate card shadow-lg" method="POST"
                          id="early-bird-form"
                          action="{{ route('mailchimp.subscribe', ['early-bird']) }}">
                        @csrf
                        <div class="card-body p-4 p-md-7">
                            <div class="mb-4">
                                <h3>Get Early-Bird access to B2BWood</h3>
                            </div>

                            <div class="row mx-n2">
                                <div class="col-sm-6 px-2">
                                    <!-- Form Group -->
                                    <div class="js-form-message form-group">
                                        <label class="sr-only" for="firstName">Full name</label>
                                        <input type="text" class="form-control" name="name" data-test="name" id="firstName"
                                               placeholder="Full name" aria-label="First name" required=""
                                               data-msg="Please enter full your name">
                                    </div>
                                    <!-- End Form Group -->
                                </div>

                                <div class="col-sm-6 px-2">
                                    <!-- Form Group -->
                                    <div class="js-form-message form-group">
                                        <label class="sr-only" for="lastName">Company name</label>
                                        <input type="text" class="form-control" name="company" data-test="company" id="CompanyName"
                                               placeholder="Company name" aria-label="Company name" required=""
                                               data-msg="Please enter company your name">
                                    </div>
                                    <!-- End Form Group -->
                                </div>

                                <div class="col-sm-6 px-2">
                                    <!-- Form Group -->
                                    <div class="js-form-message form-group">
                                        <label class="sr-only" for="workEmailAddress">Email</label>
                                        <input type="email" class="form-control" name="email" data-test="email"
                                               id="workEmailAddress" placeholder="Email"
                                               aria-label="Work email" required=""
                                               data-msg="Please enter a valid email address">
                                    </div>
                                    <!-- End Form Group -->
                                </div>

                                <div class="col-sm-6 px-2">
                                    <!-- Form Group -->
                                    <div class="js-form-message form-group">
                                        <label class="sr-only" for="companyWebsite">Phone Number<span
                                                class="text-muted font-weight-normal ml-1">(optional)</span></label>
                                        <input type="text" class="form-control" name="phone" data-test="phone"
                                               id="companyWebsite" placeholder="Phone number"
                                               aria-label="Company website"
                                               data-msg="Please enter company website.">
                                    </div>
                                    <!-- End Form Group -->
                                </div>
                            </div>

                            <!-- Checkbox -->
                            <div class="js-form-message mb-5">
                                <div class="custom-control custom-checkbox d-flex align-items-center text-muted">
                                    <input type="checkbox" class="custom-control-input" id="termsCheckbox"
                                           name="termsCheckbox" checked="">
                                    <label class="custom-control-label small" for="termsCheckbox">
                                        Yes, I'd like to receive occasional marketing emails from Front. I have the
                                        right to opt out at any time. <a class="link-underline"
                                                                         href="./page-privacy.html">View privacy
                                            policy.</a>
                                    </label>
                                </div>
                            </div>
                            <!-- End Checkbox -->

                            <button type="submit" class="btn btn-block btn-primary"
                            id="early-bird-submit" data-test="submit"
                            >Get Started</button>


                            <div class="text-center mt-3">
                                We respect your privacy and information
                            </div>
                        </div>
                    </form>
                    <!-- End Form -->
                @endif

            </div>
        </div>
    </div>
</div>
<!-- End Signup Form Section -->
