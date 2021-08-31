@extends('frontend.layouts.user_panel')

@section('page_title', translate('Add New Product'))

@push('head_scripts')

@endpush

@section('panel_content')
    <section id="app">
        {{-- $form->render() --}}
        <div class="card mb-3 mb-lg-5">
            <!-- Header -->
            <div class="card-header">
                <h4 class="card-header-title">{{ translate('Add New Product') }}</h4>
            </div>
            <!-- End Header -->

            <!-- Body -->
            <div class="card-body">
                <livewire:forms.products.product-form />
            </div>
        </div>
    </section>
@endsection

@push('footer_scripts')
    <script src="{{ static_asset('vendor/hs-step-form/dist/hs-step-form.min.js', false, true) }}"></script>
    <script src="{{ static_asset('vendor/hs-add-field/dist/hs-add-field.min.js', false, true) }}"></script>
    <script src="{{ static_asset('vendor/hs-sticky-block/dist/hs-sticky-block.min.js', false, true) }}"></script>

    <!-- JS Front -->
    <script src="{{ static_asset('vendor/hs.mask.js', false, true) }}"></script>
    <script src="{{ static_asset('vendor/hs.select2.js', false, true) }}"></script>
    <script src="{{ static_asset('vendor/hs.quill.js', false, true) }}"></script>

    <script>
        window.EVProductFormInit = function(event) {
            // INITIALIZATION OF UNFOLD
            // =======================================================
            var unfold = new HSUnfold('.js-hs-unfold-invoker').init();


            // INITIALIZATION OF SELECT2
            // =======================================================
            $('.custom-select').each(function () {
                var select2 = $.HSCore.components.HSSelect2.init($(this));
            });


            // INITIALIZATION OF STEP FORM
            // =======================================================
            var stepForm = new HSStepForm($('.js-step-form-1'), {
                finish: function() {
                    $("#postJobStepFormProgress").hide();
                    $("#postJobStepFormContent").hide();
                    $("#successMessageContentPostJob").show();
                    scrollToTop('#header');
                    $('#formContainerPostJob').removeClass('col-lg-8').addClass('col-lg-12')
                },
                onNextStep: function() {
                    scrollToTop()
                },
                onPrevStep: function() {
                    scrollToTop()
                }
            }).init();

            function scrollToTop(el = '.js-step-form-1') {
                $('html, body').animate({
                    scrollTop: $(el).offset().top - 60
                }, 500)
            }


            // INITIALIZATION OF MASKED INPUT
            // =======================================================
            $('.js-masked-input').each(function () {
                var mask = $.HSCore.components.HSMask.init($(this));
            });


            // INITIALIZATION OF ADD INPUT FILED
            // =======================================================
            $('.js-add-field').each(function () {
                new HSAddField($(this), {
                    addedField: function() {
                        $('.js-add-field .js-custom-select-dynamic').each(function () {
                            var select2Dynamic = $.HSCore.components.HSSelect2.init($(this));
                        });

                        $('.js-add-field .js-quill-dynamic').each(function () {
                            var quillDynamic = $.HSCore.components.HSQuill.init(this);
                        });
                    }
                }).init();
            });


            // INITIALIZATION OF QUILLJS EDITOR
            // =======================================================
            var quill = $.HSCore.components.HSQuill.init('.js-quill');


            // INITIALIZATION OF STICKY BLOCKS
            // =======================================================
            $('.js-sticky-block').each(function () {
                var stickyBlock = new HSStickyBlock($(this)).init();
            });


            // INITIALIZATION OF GO TO
            // =======================================================
            $('.js-go-to').each(function () {
                var goTo = new HSGoTo($(this)).init();
            });
        }

        $(window).on('load', window.EVProductFormInit);
        $(window).on('initProductForm', window.EVProductFormInit);
    </script>
   <!-- <script src="{{ static_asset('js/vue.js', false, true) }}"></script>-->
@endpush
