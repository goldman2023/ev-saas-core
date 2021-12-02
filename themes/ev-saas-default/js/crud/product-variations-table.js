window.EVProductVariationsTableFormInit = function(event) {
    // INITIALIZATION OF UNFOLD
    // =======================================================
    var unfold = new HSUnfold('.ev-product-variations-component .js-hs-unfold-invoker').init();

    // INITIALIZATION OF SELECT2
    // =======================================================
    $('.ev-product-variations-component .custom-select').each(function () {
        var select2 = $.HSCore.components.HSSelect2.init($(this));
    });

    // INITIALIZATION OF TOGGLE SWITCH
    // =======================================================
    $('.ev-product-variations-component .js-toggle-switch').each(function () {
        var toggleSwitch = new HSToggleSwitch($(this)).init();
    });

    // INITIALIZATION OF QUANTITY COUNTER
    // =======================================================
    $('.ev-product-variations-component .js-quantity-counter').each(function () {
        var quantityCounter = (new window.EV.form.HSQuantityCounter()).init($(this));
    });

    /* Init file managers */
    $('.ev-product-variations-component .custom-file-manager [data-toggle="aizuploader"]').each(function(index, element) {
        let selected_files = $.map($(element).find(".selected-files").val().split(','), function(value){
            let id = parseInt(value, 10);
            if(id) {
                return id;
            }
        });

        window.AIZ.uploader.inputSelectPreviewGenerate($(element), selected_files, true);
    });
}


$(window).on('load', window.EVProductVariationsTableFormInit);
$(window).on('EVProductVariationsTableFormInit', window.EVProductVariationsTableFormInit);

document.addEventListener('save-variation', function (event) {
    let component = event.detail.component;
    let index = event.detail.index;

    /* Set selects */
    const selects = $(".lw-form #variation-"+index+" select.custom-select:not([disabled])");
    for (const select of selects) {
        component.set($(select).attr('name'), $(select).val());
    }

    /* Set file manager */
    $(".lw-form #variation-"+index+" .custom-file-manager").each(function(index, element) {
        let input = $(element).find('input.selected-files');
        component.set(input.attr('name'), $(input).val()); // set livewire
    });

    component.saveVariation(index);
});
