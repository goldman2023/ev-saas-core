<form class="lw-form js-step-form-1"
      data-hs-step-form-options='{
          "progressSelector": "#productStepFormProgress",
          "stepsSelector": "#productStepFormContent",
          "endSelector": "#uploadResumeFinishBtn",
          "isValidate": false
        }'>
        <div class="row">
            <div id="stickyBlockStartPoint" class="col-lg-4">
                <!-- Sticky Block -->
                <div class="js-sticky-block"
                     data-hs-sticky-block-options='{
                                           "parentSelector": "#stickyBlockStartPoint",
                                           "breakpoint": "lg",
                                           "startPoint": "#stickyBlockStartPoint",
                                           "endPoint": "#stickyBlockEndPoint",
                                           "stickyOffsetTop": 20,
                                           "stickyOffsetBottom": 0
                                         }'>
                    <!-- Step -->
                    <ul id="productStepFormProgress" class="js-step-progress step step-icon-xs step-border-last-0 mt-2">
                        <li class="step-item">
                            <a class="step-content-wrapper" href="javascript:;"
                               data-hs-step-form-next-options='{
                                                      "targetSelector": "#productStepGeneral"
                                                    }'>
                                <span class="step-icon step-icon-soft-dark">1</span>
                                <div class="step-content">
                                    <span class="step-title">{{ translate('General') }}</span>
                                    <span class="step-title-description step-text font-size-1">{{ translate('General product info') }}</span>
                                </div>
                            </a>
                        </li>

                        <li class="step-item">
                            <a class="step-content-wrapper" href="javascript:;"
                               data-hs-step-form-next-options='{
                                                      "targetSelector": "#productStepContent"
                                                   }'>
                                <span class="step-icon step-icon-soft-dark">2</span>
                                <div class="step-content">
                                    <span class="step-title">{{ translate('Content') }}</span>
                                    <span class="step-title-description step-text font-size-1">{{ translate('Beautify your product!') }}</span>
                                </div>
                            </a>
                        </li>

                        <li class="step-item">
                            <a class="step-content-wrapper" href="javascript:;"
                               data-hs-step-form-next-options='{
                      "targetSelector": "#uploadResumeStepWork"
                    }'>
                                <span class="step-icon step-icon-soft-dark">3</span>
                                <div class="step-content">
                                    <span class="step-title">Work experience</span>
                                    <span class="step-title-description step-text font-size-1">Add work experience</span>
                                </div>
                            </a>
                        </li>

                        <li class="step-item">
                            <a class="step-content-wrapper" href="javascript:;"
                               data-hs-step-form-next-options='{
                      "targetSelector": "#uploadResumeStepJobSkills"
                    }'>
                                <span class="step-icon step-icon-soft-dark">4</span>
                                <div class="step-content">
                                    <span class="step-title">Skills</span>
                                    <span class="step-title-description step-text font-size-1">Add skills</span>
                                </div>
                            </a>
                        </li>

                        <li class="step-item">
                            <a class="step-content-wrapper" href="javascript:;"
                               data-hs-step-form-next-options='{
                      "targetSelector": "#uploadResumeStepTypeOfJob"
                    }'>
                                <span class="step-icon step-icon-soft-dark">5</span>
                                <div class="step-content">
                                    <span class="step-title">Job type</span>
                                    <span class="step-title-description step-text font-size-1">The type of job you are looking for</span>
                                </div>
                            </a>
                        </li>
                    </ul>
                    <!-- End Step -->
                </div>
                <!-- End Sticky Block -->
            </div>

            <div id="formContainer" class="col-lg-8">
                <!-- Content Step Form -->
                <div id="productStepFormContent">
                    <!-- Card -->
                    <div id="productStepGeneral" class="active">
                        <!-- Header -->
                        <div class="border-bottom pb-2 mb-3">
                            <div class="flex-grow-1">
                                <span class="d-lg-none">Step 1 of 5</span>
                                <h3 class="card-header-title">{{ translate('General') }}</h3>
                            </div>
                        </div>
                        <!-- End Header -->

                        <!-- Body -->
                        <div class="">
                            <x-ev.form.input name="name" type="text" label="{{ translate('Product name') }}" :required="true" placeholder="{{ translate('Think of some catchy name...') }}" />

                            <x-ev.form.select name="category_id" :items="EV::getMappedCategories()" label="{{ translate('Category') }}" :required="true" :search="true" placeholder="{{ translate('Select the category...') }}" />

                            <x-ev.form.select name="brand_id" :items="EV::getMappedBrands()" label="{{ translate('Brand') }}" :search="true" placeholder="{{ translate('Select Brand...') }}" />

                            <x-ev.form.select name="unit" :items="EV::getMappedUnits()" label="{{ translate('Unit') }}" placeholder="{{ translate('Choose the product unit...') }}" />

                            <x-ev.form.select name="tags" :tags="true" label="{{ translate('Tags') }}" :multiple="true" placeholder="{{ translate('Type and hit enter to add a tag...') }}">
                                <small class="text-muted">{{ translate('This is used for search. Input relevant words by which customer can find this product.') }}</small>
                            </x-ev.form.select>
                        </div>
                        <!-- End Body -->

                        <!-- Footer -->
                        <div class="">
                            <div class="d-flex justify-content-end align-items-center">
                                <button type="button" class="btn btn-primary"
                                        onClick="document.dispatchEvent(new CustomEvent('validate-step', {detail: {component: @this, params: ['general', '{{ base64_encode(json_encode(['targetSelector' => '#productStepContent'])) }}']}}))"
                                        >
                                    {{ translate('Continue') }} <i class="fas fa-angle-right ml-1"></i>
                                </button>
                            </div>
                        </div>
                        <!-- End Footer -->
                    </div>
                    <!-- End Card -->

                    <div id="productStepContent" class="" style="display: none;">
                        <!-- Header -->
                        <div class="border-bottom pb-2 mb-3">
                            <div class="flex-grow-1">
                                <span class="d-lg-none">Step 2 of 5</span>
                                <h3 class="card-header-title">{{ translate('Content') }}</h3>
                            </div>
                        </div>
                        <!-- End Header -->

                        <!-- Body -->
                        <div class="">

                        </div>
                        <!-- End Body -->

                        <!-- Footer -->
                        <div class="card-footer">
                            <div class="d-flex align-items-center">
                                <button type="button" class="btn btn-ghost-secondary"
                                        data-hs-step-form-prev-options='{
                         "targetSelector": "#uploadResumeStepBasics"
                       }'>
                                    <i class="fas fa-angle-left mr-1"></i> Previous step
                                </button>

                                <div class="ml-auto">
                                    <button type="button" class="btn btn-primary"
                                            data-hs-step-form-next-options='{
                                "targetSelector": "#uploadResumeStepWork"
                              }'>
                                        Save and continue <i class="fas fa-angle-right ml-1"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <!-- End Footer -->
                    </div>
                </div>

                <!-- Message Body -->
                <div id="successMessageContent" style="display: none;">
                    <div class="text-center">
                        <img class="img-fluid mb-3" src="../assets/svg/illustrations/medal.svg" alt="Image Description" style="max-width: 15rem;">

                        <div class="mb-4">
                            <h2>Successful!</h2>
                            <p>Your resume job has been successfully created.</p>
                        </div>

                        <div class="d-flex justify-content-center">
                            <a class="btn btn-primary" href="employee.html">
                                Go to profile <i class="fas fa-angle-right ml-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <!-- End Message Body -->

                <!-- Sticky Block End Point -->
                <div id="stickyBlockEndPoint"></div>
            </div>
        </div>
        <!-- End Row -->
</form>
