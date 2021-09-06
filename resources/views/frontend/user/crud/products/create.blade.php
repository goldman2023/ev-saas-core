@extends('frontend.layouts.user_panel')

@section('page_title', translate('Add New Product'))

@push('head_scripts')

@endpush

@section('panel_content')
    <section id="app">
        {{-- $form->render() --}}
        <livewire:forms.products.product-form page="general" />
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
    <script src="{{ static_asset('vendor/hs.sortable.js', false, true) }}"></script>

    <script>
        function scrollToTop(el = '.js-step-form-1') {
            $('html, body').animate({
                scrollTop: $(el).offset().top - 60
            }, 500)
        }

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
                let data = Livewire.find($(select).closest('.lw-form').attr('wire:id')).get(name); // get tags property from livewire form component instance

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
                    if(name === 'attributes' || name.match(/attributes\.[0-9]+/g)) {
                        // get only selected attributes
                        $(select).val(Object.keys(data).filter(x=>data[x].selected).map(f=>data[f].id)).trigger('change', [{init:true}]);
                    }

                }
            }

            // Update livewire data when attributes are changed
            $('select[name="attributes"]').off().on('change', function(e, data) {
                if(data && data.init) return;

                let component = Livewire.find($(this).closest('.lw-form').attr('wire:id'));

                let $att_idx = $(this).val().map(x => parseInt(x, 10));
                let $atts = component.get('attributes');

                for (const index in $atts) {
                    if($att_idx.indexOf($atts[index].id) === -1) {
                        component.set('attributes.'+$atts[index].id+'.selected', false);
                    } else {
                        component.set('attributes.'+$atts[index].id+'.selected', true);
                    }
                }
            });

            // Update livewire data when attribute values change
            $('select[name^="attributes."]').off().on('change', function(e, data) {
                if(data && data.init) return;

                let component = Livewire.find($(this).closest('.lw-form').attr('wire:id'));
                let $att_id = $(this).data('attribute-id');

                let $att_values_idx = $(this).val().map(x => parseInt(x, 10));
                let $att_values = component.get('attributes.'+$att_id+'.attribute_values');

                // TODO: Check if new custom value is added and add it to the DB

                for (const index in $att_values) {
                    if($att_values_idx.indexOf($att_values[index].id) === -1) {
                        component.set('attributes.'+$att_id+'.attribute_values.'+index+'.selected', false);
                    } else {
                        component.set('attributes.'+$att_id+'.attribute_values.'+index+'.selected', true);
                    }
                }
            });


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

            // INITIALIZATION OF SORTABLE
            // =======================================================
            $('.js-sortable').each(function () {
                var sortable = $.HSCore.components.HSSortable.init($(this));
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

                if(name && !$(select).is('[name^="attributes"]')) {
                    let data = $(select).val();
                    component.set(select.getAttribute('name'), $(select).val()); // set livewire
                } else if($(select).is('[name^="attributes."]')) {
                    console.log($(select).val());
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

        document.addEventListener('goToTop', function (event) {
            scrollToTop('.lw-form');
        });
    </script>
@endpush