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
                <livewire:forms.products.product-form page="general" />
            </div>
        </div>
    </section>
@endsection

@push('footer_scripts')
    <script src="{{ static_asset('js/aiz-core.js', false, true) }}"></script>
    <script src="{{ static_asset('vendor/hs-step-form/dist/hs-step-form.min.js', false, true) }}"></script>
    <script src="{{ static_asset('vendor/hs-add-field/dist/hs-add-field.min.js', false, true) }}"></script>
    <script src="{{ static_asset('vendor/hs-sticky-block/dist/hs-sticky-block.min.js', false, true) }}"></script>
    <script src="{{ static_asset('vendor/hs-toggle-switch/dist/hs-toggle-switch.min.js', false, true) }}"></script>

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
            window.stepForm = new HSStepForm($('.js-step-form-1'), {
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
            });
            window.stepForm.init();

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

            // INITIALIZATION OF TOGGLE SWITCH
            // =======================================================
            $('.js-toggle-switch').each(function () {
                var toggleSwitch = new HSToggleSwitch($(this)).init();
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


            // If select2 is of TAGS type and these tags can be dynamically created, populate options on dehydrate, otherwise added tags will vanish because new component is rendered!
            // =======================================================
            const selects = document.querySelectorAll(".lw-form select.custom-select");
            for (const select of selects) {
                let name = select.getAttribute('name');
                let data = Livewire.find($(select).closest('form').attr('wire:id')).get(name); // get tags property from livewire form component instance

                if($(select).is('[dynamic-items]')) {
                    try {
                        let select2options = $(select).is('[data-hs-select2-options]') ? JSON.parse($(select).attr('data-hs-select2-options')) : null;
                        if(select2options.tags) {
                            // Create a DOM Option and pre-select by default
                            data.forEach(function(value, key) {
                                $(select).append(new Option(value, value, true, true)).trigger('change');
                            });
                        }
                    } catch(error) {}
                } else {
                    if(name === 'attributes') {
                        // get only selected attributes
                        $(select).val(Object.keys(data).filter(x=>data[x].selected).map(f=>data[f].id)).trigger('change', [{init:true}]);
                    }

                }
            }


            /* Init file managers */
            $('.custom-file-manager [data-toggle="aizuploader"]').each(function(index, element) {
                let selected_files = $.map($(element).find(".selected-files").val().split(','), function(value){
                    let id = parseInt(value, 10);
                    if(id) {
                        return id;
                    }
                });

                window.AIZ.uploader.inputSelectPreviewGenerate($(element), selected_files, true);
            });

        }

        $(window).on('load', window.EVProductFormInit);
        $(window).on('initProductForm', window.EVProductFormInit);

        document.addEventListener('validate-step', async function (event) {
            let component = event.detail.component;
            let method = event.detail.method;
            let params = event.detail.params;

            /* Set selects */
            const selects = document.querySelectorAll(".lw-form .custom-select");
            for (const select of selects) {
                let name = select.getAttribute('name');
                if(name) {
                    let data = $(select).val();
                    component.set(select.getAttribute('name'), $(select).val()); // set livewire
                }
            }

            /* Set Quill */
            $(".lw-form .quill-custom").each(function(index, element) {
                let input = $(element).find('input[data-textarea]');
                component.set(input.attr('name'), $(input).val()); // set livewire
            });

            /* Set file manager */
            $(".lw-form .custom-file-manager").each(function(index, element) {
                let input = $(element).find('input.selected-files');
                component.set(input.attr('name'), $(input).val()); // set livewire
            });

            component.validateSpecificSet(...params);
        });


    </script>
@endpush
