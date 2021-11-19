window.EVStockManagementFormInit = function(event) {
    // INITIALIZATION OF UNFOLD
    // =======================================================
    var unfold = new HSUnfold('.js-hs-unfold-invoker').init();

    // INITIALIZATION OF DATATABLES
    // =======================================================
    //var datatable = $.HSCore.components.HSDatatables.init($('#serialNumbersDatatable'));

    // INITIALIZATION OF SELECT2
    // =======================================================
    $('.custom-select').each(function () {
        var select2 = $.HSCore.components.HSSelect2.init($(this));
    });

    // INITIALIZATION OF TOGGLE SWITCH
    // =======================================================
    $('.js-toggle-switch').each(function () {
        var toggleSwitch = new HSToggleSwitch($(this)).init();
    });

    // INITIALIZATION OF QUANTITY COUNTER
    // =======================================================
    $('.js-quantity-counter').each(function () {
        var quantityCounter = new HSQuantityCounter($(this)).init();
    });


    // INITIALIZATION OF ADD INPUT FILED
    // =======================================================
    $('.js-add-field').each(function () {
        new HSAddField($(this), {
            addedField: function() {
                // if added field is select2, quill or toastUI
                $('.js-add-field .js-custom-select-dynamic').each(function () {
                    var select2Dynamic = $.HSCore.components.HSSelect2.init($(this));
                });

                $('.js-add-field .js-quill-dynamic').each(function () {
                    var quillDynamic = $.HSCore.components.HSQuill.init(this);
                });
            }
        }).init();
    });


    // INITIALIZATION OF GO TO
    // =======================================================
    $('.js-go-to').each(function () {
        var goTo = new HSGoTo($(this)).init();
    });

}


$(window).on('load', window.EVStockManagementFormInit);
$(window).on('initStockManagementForm', window.EVStockManagementFormInit);
