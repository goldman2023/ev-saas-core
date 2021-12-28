window.initPaymentMethodForm = function(event) {
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
        var quantityCounter = (new window.EV.form.HSQuantityCounter()).init($(this));
    });


    // INITIALIZATION OF ADD INPUT FILED
    // =======================================================
    $('.js-add-field').each(function () {
        $(this).off();

    });


    // INITIALIZATION OF GO TO
    // =======================================================
    $('.js-go-to').each(function () {
        var goTo = new HSGoTo($(this)).init();
    });

}


$(window).on('load', window.initPaymentMethodForm);
$(window).on('initPaymentMethodForm', window.initPaymentMethodForm);
