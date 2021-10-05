function scrollToTop(el = '.js-step-form-1') {
    $('html, body').animate({
        scrollTop: $(el).offset().top - 60
    }, 500)
}

function getSelectedAttributeValuesForVariations() {
    let matrix = {};
    $('input[name$="for_variations"]:checked').each(function(index, element) {
        let select = $(element).closest('.form-group').find('select[data-attribute-id]');
        let other_att_id = Number(select.data('attribute-id'));
        matrix[other_att_id] = select.val().map(function(x) { return Number(x); });
    });
    return matrix;
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

    // INITIALIZATION OF TOASTUI EDITOR
    // =======================================================
    $.HSCore.components.EVToastUIEditor.init('.js-toast-ui-editor');


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

    /* Select multiple attributes change */
    window.EV.form.select.setOnAttributeChange();

    /* Radio Attributes values change */
    window.EV.form.radio.setOnAttributeValueChange();

    /* Select Attributes values change */
    window.EV.form.select.setOnAttributeValueChange();

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


    // INITIALIZATION OF FLATPICKR
    // =======================================================
    $('.js-flatpickr').each(function () {
        $.HSCore.components.HSFlatpickr.init($(this));
    });

    // ATTRIBUTES FOR VARIATIONS (remove modal)
    // =======================================================
    $('input[name$="for_variations"]:checked').each(function(index, element) {
        let select = $(element).closest('.form-group').find('select[data-attribute-id]');
        let variations_component = Livewire.find($(element).closest('.lw-form').find('.ev-product-variations-component').attr('wire:id'));
        let modal = $('#remove-selected-attribute-modal');

        // Remove Flag
        select.on('select2:unselecting', function (e) {
            e.preventDefault();
            e.stopPropagation();

            $(this).on('select2:opening', function (e) {
                e.preventDefault();
                $(this).off('select2:opening');
            });

            // This is triggered before attribute value is removed
            // Display a Modal and ask client if they are sure!
            let att_value_id = Number(e.params.args.data.id);
            let att_id = Number($(this).data('attribute-id'));

            modal.find('.remove-btn').off().on('click', function() {
                let newValues = [];

                select.find(':selected').each(function(index, element) {
                    let val_id = Number(element.value);

                    if(val_id === att_value_id) {
                        return; // skip the value we want to delete
                    }

                    newValues.push(val_id);
                });

                select.val(newValues).trigger('change');

                variations_component.setAttributeValueRemoveFlag(getSelectedAttributeValuesForVariations()); // make removeFlag TRUE

                modal.modal('hide');
            });

            modal.modal('toggle');
        });

        select.on('select2:select', function (e) {
            variations_component.setAttributeValueRemoveFlag(getSelectedAttributeValuesForVariations()); // make removeFlag FALSE
        });
    });
}

$(window).on('load', window.EVProductFormInit);
$(window).on('initProductForm', window.EVProductFormInit);

document.addEventListener('set-variations-data', async function (event) {
    let component = event.detail.component;
    let target = event.detail.target;

    /* Set file manager */
    $(target+' .custom-file-manager').each(function(index, element) {
        let input = $(element).find('input.selected-files');
        component.set(input.attr('name'), $(input).val()); // set livewire
    });

    component.setVariationsData();
});
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
            let $att_id = $(select).data('attribute-id');
            let $att_values_idx = Array.isArray($(select).val()) ? $(select).val().map(x => parseInt(x, 10)) : $(select).val();

            if($att_values_idx != null) {
                let $att_values = component.get('attributes.'+$att_id+'.attribute_values');

                // TODO: Check if new custom value is added and add it to the DB
                for (const index in $att_values) {
                    if($att_values_idx.indexOf($att_values[index].id) === -1) {
                        component.set('attributes.'+$att_id+'.attribute_values.'+index+'.selected', false);
                    } else {
                        component.set('attributes.'+$att_id+'.attribute_values.'+index+'.selected', true);
                    }
                }
            }

        }
    }

    /* Set Quill */
    $(".lw-form .quill-custom").each(function(index, element) {
        let input = $(element).find('input[data-textarea]');
        component.set(input.attr('name'), $(input).val()); // set livewire
    });

    /* Set ToastUI */
    $(".lw-form .toast-ui-editor-custom").each(function(index, element) {
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

// TODO: Find a better way to prevent Modal fade after clicking Save Variations
$(window).on('preventProductVariationsModalFade', function(event) {
    $('#product_variations_modal').addClass('show').css({
        'display':'block',
        'z-index': 1050
    });
});
document.addEventListener('triggerModal', function (event) {
    let id = event.detail.id;
    $(id).modal('toggle');
});

document.addEventListener('toastIt', async function (event) {
    let content = event.detail.content;
    let id = event.detail.id;

    $(id).find('.toast-body').text(content);

    $(id).toast({
        delay: 3000
    });

    $(id).toast('show');
});


document.addEventListener('goToTop', function (event) {
    scrollToTop('.lw-form');
});
