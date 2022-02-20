window.EVProductFormInit = function(event) {
    // INITIALIZATION OF SELECT2
    // =======================================================
    $('.custom-select').each(function () {
        var select2 = $.HSCore.components.HSSelect2.init($(this));
    });


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

    // INITIALIZATION OF TOASTUI EDITOR
    // =======================================================
    $.HSCore.components.EVToastUIEditor.init('.js-toast-ui-editor');

    /* Initialize Category selectors */
    window.EV.form.select.initCategoriesSelectors();

    // If select2 is of TAGS type and these tags can be dynamically created, populate options on dehydrate, otherwise added tags will vanish because new component is rendered!
    // =======================================================
    const selects = document.querySelectorAll(".lw-form select.custom-select");
    for (const select of selects) {
        try {
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
            }
            // } else {
            //     if(name === 'attributes' || name.match(/attributes\.[0-9]+/g)) {
            //         // get only selected attributes
            //         $(select).val(Object.keys(data).filter(x=>data[x].selected).map(f=>data[f].id)).trigger('change', [{init:true}]);
            //     } else if(name === 'selected_categories') {
            //         // Preselect livewire selected categories
            //         //window.EV.form.select.preselectCategories(data);
            //     }
    
            // }
        } catch(error) {
            console.log(error);
        }
        
    }

    // /* Select multiple attributes change */
    // window.EV.form.select.setOnAttributeChange();

    // /* Radio Attributes values change */
    // window.EV.form.radio.setOnAttributeValueChange();

    // /* Select Attributes values change */
    // window.EV.form.select.setOnAttributeValueChange();

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
}

$(window).on('load', window.EVProductFormInit);
$(window).on('initProductForm', window.EVProductFormInit);